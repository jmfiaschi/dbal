<?php
namespace Doctrine\DBAL\Driver\PDOCache;

/**
 * Cache Connection implementation.
 *
 * @since 2.0
 */
class Connection extends \Doctrine\DBAL\Driver\PDOConnection implements \Doctrine\DBAL\Driver\Connection
{    
    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        $sql    = 'SELECT LAST_IDENTITY() as LASTID FROM %TSQL_sys.snf';
        $stmt   = $this->query($sql);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return (int) $result['LASTID'];
    }
}
