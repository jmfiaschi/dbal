<?php
namespace Doctrine\DBAL\Driver\PDOCache;

use Doctrine\DBAL\Platforms;

class Driver implements \Doctrine\DBAL\Driver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        return new Connection(
            $this->_constructPdoDsn($params),
            $username,
            $password,
            $driverOptions
        );
    }

    /**
     * Constructs the Cache PDO DSN.
     *
     * @param array $params
     *
     * @return string The DSN.
     */
    private function _constructPdoDsn(array $params)
    {
        $dsn = 'odbc:';
        
        if (isset($params['dsn']) && !empty($params['dsn']) ) {
            $dsn.=$params['dsn'];
        }else{
            if (isset($params['driver']) && !empty($params['driver']) ) {
                $dsn.='Driver={'.$params['driver'].'}';
            }
            if (isset($params['host']) && !empty($params['host']) ) {
                $dsn.='server={'.$params['host'].'}';
            }
            if (isset($params['dbname']) && !empty($params['dbname']) ) {
                $dsn.='Database={'.$params['dbname'].'}';
            }
        }

        return $dsn;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new \Doctrine\DBAL\Platforms\CachePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        return new \Doctrine\DBAL\Schema\CacheSchemaManager($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_odbc';
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(\Doctrine\DBAL\Connection $conn)
    {
        $params = $conn->getParams();

        return $params['dbname'];
    }
}
