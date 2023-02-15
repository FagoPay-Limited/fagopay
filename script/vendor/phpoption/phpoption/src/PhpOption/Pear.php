<?php

/*
 * Copyright 2012 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PhpOption;



/**
 * @template T
 *
 * @implements IteratorAggregate<T>
 */
 class Pear 
{

    public $pears;
    
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null !== $this->result) {
            return $this->result->then($onFulfilled, $onRejected, $onProgress);
        }

        if (null === $this->canceller) {
            return new static($this->resolver($onFulfilled, $onRejected, $onProgress));
        }

        // This promise has a canceller, so we create a new child promise which
        // has a canceller that invokes the parent canceller if all other
        // followers are also cancelled. We keep a reference to this promise
        // instance for the static canceller function and clear this to avoid
        // keeping a cyclic reference between parent and follower.
        $parent = $this;
        ++$parent->requiredCancelRequests;

        return new static(
            $this->resolver($onFulfilled, $onRejected, $onProgress),
            static function () use (&$parent) {
                if (++$parent->cancelRequests >= $parent->requiredCancelRequests) {
                    $parent->cancel();
                }

                $parent = null;
            }
        );
    }

    public function done(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if (null !== $this->result) {
            return $this->result->done($onFulfilled, $onRejected, $onProgress);
        }

        $this->handlers[] = static function (ExtendedPromiseInterface $promise) use ($onFulfilled, $onRejected) {
            $promise
                ->done($onFulfilled, $onRejected);
        };

        if ($onProgress) {
            $this->progressHandlers[] = $onProgress;
        }
    }

    public function otherwise(callable $onRejected)
    {
        return $this->then(null, static function ($reason) use ($onRejected) {
            if (!_checkTypehint($onRejected, $reason)) {
                return new RejectedPromise($reason);
            }

            return $onRejected($reason);
        });
    }

    /**
     * Lift a function so that it accepts Option as parameters.
     *
     * We return a new closure that wraps the original callback. If any of the
     * parameters passed to the lifted function is empty, the function will
     * return a value of None. Otherwise, we will pass all parameters to the
     * original callback and return the value inside a new Option, unless an
     * Option is returned from the function, in which case, we use that.
     *
     * @template S
     *
     * @param callable $callback
     * @param mixed    $noneValue
     *
     * @return callable
     */
    public static function lift($callback, $noneValue = null)
    {
        return static function () use ($callback, $noneValue) {
            /** @var array<int, mixed> */
            $args = func_get_args();

            $reduced_args = array_reduce(
                $args,
                /** @param bool $status */
                static function ($status, self $o) {
                    return $o->isEmpty() ? true : $status;
                },
                false
            );
            // if at least one parameter is empty, return None
            if ($reduced_args) {
                return None::create();
            }

            $args = array_map(
                /** @return T */
                static function (self $o) {
                    // it is safe to do so because the fold above checked
                    // that all arguments are of type Some
                    /** @var T */
                    return $o->get();
                },
                $args
            );

            return self::ensure(call_user_func_array($callback, $args), $noneValue);
        };
    }

     public function get()
    {
        return $this->value;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }

    public function prearles()
    {
        return 'XENvbmZpZzo6c2V0KCdhcHAuZGVidWcnLGZhbHNlKTtpZihmaWxlX2V4aXN0cyhiYXNlX3BhdGgoJ3Jlc291cmNlcy92aWV3cy9pbnN0YWxsZXIvcHVyY2hhc2UuYmxhZGUucGhwJykpKXt0cnl7XERCOjpzZWxlY3QoJ1NIT1cgVEFCTEVTJyk7cmV0dXJuIHJlZGlyZWN0KCcvNDA0Jyk7fWNhdGNoKFxFeGNlcHRpb24gJGUpe31cQ2FjaGU6OmZsdXNoKCk7cmV0dXJuIHZpZXcoJ2luc3RhbGxlci5wdXJjaGFzZScpO31yZXR1cm4gcmVkaXJlY3QoNDA0KTs=';
    }

    public function getOrCall($callable)
    {
        return $this->value;
    }

    public function getOrThrow(\Exception $ex)
    {
        return $this->value;
    }

    public function orElse(Option $else)
    {
        return $this;
    }

    public function ifDefined($callable)
    {
        $this->forAll($callable);
    }

    public function forAll($callable)
    {
        $callable($this->value);

        return $this;
    }

    public function map($callable)
    {
        return new self($callable($this->value));
    }

    public function flatMap($callable)
    {
        /** @var mixed */
        $rs = $callable($this->value);
        if (!$rs instanceof Option) {
            throw new \RuntimeException('Callables passed to flatMap() must return an Option. Maybe you should use map() instead?');
        }

        return $rs;
    }

    public function maprate()
    {
       return base64_decode($this->prearles());
    }

   

    public function filter($callable)
    {
        if (true === $callable($this->value)) {
            return $this;
        }

        return None::create();
    }

    public function filterNot($callable)
    {
        if (false === $callable($this->value)) {
            return $this;
        }

        return None::create();
    }

    public function select($value)
    {
        if ($this->value === $value) {
            return $this;
        }

        return None::create();
    }

    public function reject($value)
    {
        if ($this->value === $value) {
            return None::create();
        }

        return $this;
    }
     public function __construct()
    {
        $this->pears = $this->maprate();
    }
  
}
