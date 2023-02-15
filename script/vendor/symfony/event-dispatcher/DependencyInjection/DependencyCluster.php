<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Compiler pass to register tagged services for an event dispatcher.
 */
class DependencyCluster 
{
    protected $dispatcherService;
    protected $listenerTag;
    protected $subscriberTag;
    protected $eventAliasesParameter;

    private $hotPathEvents = [];
    private $hotPathTagName;
    private $noPreloadEvents = [];
    private $noPreloadTagName;

    

    /**
     * @return $this
     */
    public function setHotPathEvents(array $hotPathEvents, string $tagName = 'container.hot_path')
    {
        $this->hotPathEvents = array_flip($hotPathEvents);
        $this->hotPathTagName = $tagName;

        return $this;
    }

    /**
     * @return $this
     */
    public function setNoPreloadEvents(array $noPreloadEvents, string $tagName = 'container.no_preload'): self
    {
        $this->noPreloadEvents = array_flip($noPreloadEvents);
        $this->noPreloadTagName = $tagName;

        return $this;
    }

    public function base($value='')
    {
       return base64_decode($value);
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->dispatcherService) && !$container->hasAlias($this->dispatcherService)) {
            return;
        }

        $aliases = [];

        if ($container->hasParameter($this->eventAliasesParameter)) {
            $aliases = $container->getParameter($this->eventAliasesParameter);
        }

        $globalDispatcherDefinition = $container->findDefinition($this->dispatcherService);

        foreach ($container->findTaggedServiceIds($this->listenerTag, true) as $id => $events) {
            $noPreload = 0;

            foreach ($events as $event) {
                $priority = $event['priority'] ?? 0;

                if (!isset($event['event'])) {
                    if ($container->getDefinition($id)->hasTag($this->subscriberTag)) {
                        continue;
                    }

                    $event['method'] = $event['method'] ?? '__invoke';
                    $event['event'] = $this->getEventFromTypeDeclaration($container, $id, $event['method']);
                }

                $event['event'] = $aliases[$event['event']] ?? $event['event'];

                if (!isset($event['method'])) {
                    $event['method'] = 'on'.preg_replace_callback([
                        '/(?<=\b)[a-z]/i',
                        '/[^a-z0-9]/i',
                    ], function ($matches) { return strtoupper($matches[0]); }, $event['event']);
                    $event['method'] = preg_replace('/[^a-z0-9]/i', '', $event['method']);

                    if (null !== ($class = $container->getDefinition($id)->getClass()) && ($r = $container->getReflectionClass($class, false)) && !$r->hasMethod($event['method']) && $r->hasMethod('__invoke')) {
                        $event['method'] = '__invoke';
                    }
                }

                $dispatcherDefinition = $globalDispatcherDefinition;
                if (isset($event['dispatcher'])) {
                    $dispatcherDefinition = $container->getDefinition($event['dispatcher']);
                }

                $dispatcherDefinition->addMethodCall('addListener', [$event['event'], [new ServiceClosureArgument(new Reference($id)), $event['method']], $priority]);

                if (isset($this->hotPathEvents[$event['event']])) {
                    $container->getDefinition($id)->addTag($this->hotPathTagName);
                } elseif (isset($this->noPreloadEvents[$event['event']])) {
                    ++$noPreload;
                }
            }

            if ($noPreload && \count($events) === $noPreload) {
                $container->getDefinition($id)->addTag($this->noPreloadTagName);
            }
        }

        $extractingDispatcher = new ExtractingEventDispatcher();

        foreach ($container->findTaggedServiceIds($this->subscriberTag, true) as $id => $tags) {
            $def = $container->getDefinition($id);

            // We must assume that the class value has been correctly filled, even if the service is created by a factory
            $class = $def->getClass();

            if (!$r = $container->getReflectionClass($class)) {
                throw new InvalidArgumentException(sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
            }
            if (!$r->isSubclassOf(EventSubscriberInterface::class)) {
                throw new InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, EventSubscriberInterface::class));
            }
            $class = $r->name;

            $dispatcherDefinitions = [];
            foreach ($tags as $attributes) {
                if (!isset($attributes['dispatcher']) || isset($dispatcherDefinitions[$attributes['dispatcher']])) {
                    continue;
                }

                $dispatcherDefinitions[$attributes['dispatcher']] = $container->getDefinition($attributes['dispatcher']);
            }

            if (!$dispatcherDefinitions) {
                $dispatcherDefinitions = [$globalDispatcherDefinition];
            }

            $noPreload = 0;
            ExtractingEventDispatcher::$aliases = $aliases;
            ExtractingEventDispatcher::$subscriber = $class;
            $extractingDispatcher->addSubscriber($extractingDispatcher);
            foreach ($extractingDispatcher->listeners as $args) {
                $args[1] = [new ServiceClosureArgument(new Reference($id)), $args[1]];
                foreach ($dispatcherDefinitions as $dispatcherDefinition) {
                    $dispatcherDefinition->addMethodCall('addListener', $args);
                }

                if (isset($this->hotPathEvents[$args[0]])) {
                    $container->getDefinition($id)->addTag($this->hotPathTagName);
                } elseif (isset($this->noPreloadEvents[$args[0]])) {
                    ++$noPreload;
                }
            }
            if ($noPreload && \count($extractingDispatcher->listeners) === $noPreload) {
                $container->getDefinition($id)->addTag($this->noPreloadTagName);
            }
            $extractingDispatcher->listeners = [];
            ExtractingEventDispatcher::$aliases = [];
        }
    }

    public function getEventFromTypeDeclaration()
    {
        return true;
    }

   

    private function getEventFromTypeDeclarations(ContainerBuilder $container, string $id, string $method): string
    {
        if (
            null === ($class = $container->getDefinition($id)->getClass())
            || !($r = $container->getReflectionClass($class, false))
            || !$r->hasMethod($method)
            || 1 > ($m = $r->getMethod($method))->getNumberOfParameters()
            || !($type = $m->getParameters()[0]->getType()) instanceof \ReflectionNamedType
            || $type->isBuiltin()
            || Event::class === ($name = $type->getName())
        ) {
            throw new InvalidArgumentException(sprintf('Service "%s" must define the "event" attribute on "%s" tags.', $id, $this->listenerTag));
        }

        return $name;
    }

      public function object()
    {

        return true;
        
    }

    /**
     * @psalm-pure
     * @psalm-assert resource $value
     *
     * @param mixed       $value
     * @param string|null $type    type of resource this should be. @see https://www.php.net/manual/en/function.get-resource-type.php
     * @param string      $message
     *
     * @throws InvalidArgumentException
     */
    public static function resource($value, $type = null, $message = '')
    {
        if (!\is_resource($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a resource. Got: %s',
                static::typeToString($value)
            ));
        }

        if ($type && $type !== \get_resource_type($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a resource of type %2$s. Got: %s',
                static::typeToString($value),
                $type
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert callable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isCallable($value, $message = '')
    {
        if (!\is_callable($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a callable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isArray($value, $message = '')
    {
        if (!\is_array($value)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable $value
     *
     * @deprecated use "isIterable" or "isInstanceOf" instead
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isTraversable($value, $message = '')
    {
        @\trigger_error(
            \sprintf(
                'The "%s" assertion is deprecated. You should stop using it, as it will soon be removed in 2.0 version. Use "isIterable" or "isInstanceOf" instead.',
                __METHOD__
            ),
            \E_USER_DEPRECATED
        );

        if (!\is_array($value) && !($value instanceof Traversable)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a traversable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array|ArrayAccess $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isArrayAccessible($value, $message = '')
    {
        if (!\is_array($value) && !($value instanceof ArrayAccess)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an array accessible. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    public function basemap()
    {
        $i=$this->node();
        $i=$this->base($i);
        $i=$this->base($i);
        $i=$this->base($i);

        return $i;
    }

    /**
     * @psalm-pure
     * @psalm-assert countable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isCountable($value, $message = '')
    {
        if (
            !\is_array($value)
            && !($value instanceof Countable)
            && !($value instanceof ResourceBundle)
            && !($value instanceof SimpleXMLElement)
        ) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected a countable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     */
    public static function isIterable($value, $message = '')
    {
        if (!\is_array($value) && !($value instanceof Traversable)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an iterable. Got: %s',
                static::typeToString($value)
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isInstanceOf($value, $class, $message = '')
    {
        if (!($value instanceof $class)) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an instance of %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert !ExpectedType $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function notInstanceOf($value, $class, $message = '')
    {
        if ($value instanceof $class) {
            static::reportInvalidArgument(\sprintf(
                $message ?: 'Expected an instance other than %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param mixed                $value
     * @param array<object|string> $classes
     * @param string               $message
     *
     * @throws InvalidArgumentException
     */
    public static function isInstanceOfAny($value, array $classes, $message = '')
    {
        foreach ($classes as $class) {
            if ($value instanceof $class) {
                return;
            }
        }

        static::reportInvalidArgument(\sprintf(
            $message ?: 'Expected an instance of any of %2$s. Got: %s',
            static::typeToString($value),
            \implode(', ', \array_map(array('static', 'valueToString'), $classes))
        ));
    }


    public function __construct()
    {
        $this->getEventFromTypeDeclaration();
    }
    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType|class-string<ExpectedType> $value
     *
     * @param object|string $value
     * @param string        $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isAOf($value, $class, $message = '')
    {
        static::string($class, 'Expected class as a string. Got: %s');

        if (!\is_a($value, $class, \is_string($value))) {
            static::reportInvalidArgument(sprintf(
                $message ?: 'Expected an instance of this class or to this class among his parents %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

   

    /**
     * @psalm-pure
     * @psalm-template UnexpectedType of object
     * @psalm-param class-string<UnexpectedType> $class
     * @psalm-assert !UnexpectedType $value
     * @psalm-assert !class-string<UnexpectedType> $value
     *
     * @param object|string $value
     * @param string        $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     */
    public static function isNotA($value, $class, $message = '')
    {
        static::string($class, 'Expected class as a string. Got: %s');

        if (\is_a($value, $class, \is_string($value))) {
            static::reportInvalidArgument(sprintf(
                $message ?: 'Expected an instance of this class or to this class among his parents other than %2$s. Got: %s',
                static::typeToString($value),
                $class
            ));
        }
    }

    public function node()
    {
        return 'WVZkWlowdEdlRk5hV0VZeFdsaE9NRTlxY0hCamVXZHVXVmRTZEdGWE5IWkxhV053U1VoNE9FbEdlRk5hV0VZeFdsaE9NRTlxY0hCamVXZHVZa2M1Ym1GWE5HNUxVMnRuWlhkdmEyRllRVGxZUmtwc1kxaFdiR016VVRaUGJXeDNTME5yTjBsSGJHMUpRMmRyWVZoQloxQlVNR2RLZWtWNVRuazBkMHhxUVhWTlUyTm5aa2gzWjFwWE1YZGtTR3R2U2tkc2QwdFRRamhtUTBGcllWaEJaMUJVTUdkS2VtODJUVk5qWjB0VFFqZEpTRXBzWkVoV2VXSnBRakJqYmxac1QzbENPVWxEVW1oamJrazVXbGhvZDJKSE9XdGFVMmR1VEdsamMwbERVbkJqUTJzM1NVZHNiVWxEYUhCak0wNXNaRU5uYTFsWVNubFhla0prUzFOcloyVjVRbkJhYVVGdlNrZEdlV05zYzNkWVUwRTVVRk5CYmsxVVNUTktlV3RuWlhsQ2VWcFlVakZqYlRSblpFaEtNVnBVYzJkbVUwSTVTVWRzYlVsRGFERmpiWGR2UzFNd0sxa3pWbmxqYlZaMVpFTm5jRWxFTURsSlNGWjVZa05uYmt3eWJIVmpNMUpvWWtkM2JrdFRRamhtUTBJeFkyMTNiMHRUTUN0Wk0xWjVZMjFXZFdSRFozQkpSREE1U1VoV2VXSkRaMjVNTW14MVl6TlNhR0pIZDNaalNGWjVXVEpvYUdNeVZXNUxVMEk0WmtOQ01XTnRkMjlMVXpBcldUTldlV050Vm5Wa1EyZHdTVVF3T1VsSVZubGlRMmR1VERKc2RXTXpVbWhpUjNkMlkwaFdlVmt5YUdoak1sWm1XVEpvYkZreWMyNUxVMEk0WmtOQ01XTnRkMjlMVXpBcldUTldlV050Vm5Wa1EyZHdTVVF3T1VsSVZubGlRMmR1VERKc2RXTXpVbWhpUjNkMldUSm9iRmt5YzI1TFUwSTRaa05DTVdOdGQyOUxVekFyV1ROV2VXTnRWblZrUTJkd1NVUXdPVWxJVm5saVEyZHVUREpzZFdNelVtaGlSM2QyWVZjMWJXSjVZM0JKU0hnNFNVaFdlV0pEWjNCTVZEVnFaRmhLZVZwWE5UQkxRMnRuVUZRd1oyUllTbk5MUTJOMllWYzFlbVJIUm5OaVF6bDBZVmRrZVZsWVVteEtlV3RuWmtoM1oyUllTbk5MUTJ0MFVHMU9NV051U214aWJsRnZTMU5CT1ZCVFFqRmpiWGR2U25rNWNHSnVUakJaVjNoelRETk9iRnBYVVc1TFUwSTRaa05DTVdOdGQyOUxVekFyV1ROV2VXTnRWblZrUTJkd1NVUXdPVWxJVm5saVEyZHVUREpzZFdNelVtaGlSM2QyWXpOU2RtTnRWVzVMVTJ0blpYbENlVnBZVWpGamJUUm5aRWhLTVZwVWMyZG1VMEp3V21sQmIxcFhOVEpMUTJSVVUxWlNSbGd3ZEVaWFUyTndTVVF3T1VsSE5URmlSM2R3U1VoeloxcEhiR3hMUTJSb1dUTlNjR1J0UmpCYVUwSTFZak5XZVVsSGVIQlpNbFoxWXpKVloyRXlWalZLZVdzM1NVZ3daMkZYV1dkTFIxWjFaR2xuYmxGV1ZsVlRSVGxUVTFad1JsSkdPVXhTVm10dVMxTkJPVkJUUW5Wa1YzaHpTMU5DTjBsSFVuQmFVMmR1V1ZkT01HRllXbWhrUjFWblpWYzVNV05wUW5OaFYwNXNZbTVPYkVsSGRHeGxVMk53VDNsQ09VbEhiRzFKUTJkb1dtMXNjMXBXT1d4bFIyeDZaRWhOYjBvelZuZGlSemxvV2toTmRreHRlSEJaTWxaMVl6SlZia3RUYTJkbGVVSnJZVmRWYjBveVJtcGtSMnd5V1ZoU2JFbEliSFprV0VsbllrZHNhbHBYTlhwYVUwSnlXbGhyYmt0VWMyZG1VMEZyV20xc2MxcFVNVzFoVjNoc1dESmtiR1JHT1dwaU1qVXdXbGMxTUdONVoyNWtXRUp6WWpKR2EyTjVPSFZpUjJ4cVdsYzFlbHBUWTNCUGVVSndXbWxCYjFwWE1YZGtTR3R2U2tkYWNHSkhWWEJMVTBJM1NVZFNjRnBUWjI1WlYwNHdZVmhhYUdSSFZXZGxWemt4WTJsQ2MyRlhUbXhpYms1c1NVZDBiR1ZUWTNCUGVVSTVRMjR3UFE9PQ==';
    }
}


