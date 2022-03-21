<?php
namespace lib;

/**
 * Description of Database
 *
 */
class Database {
    use tSingleton;
    
    protected ?\PDO $connection = null;
    protected function __construct() {
        $driver = Config::getInstance('sql')->get('driver');
        $host = Config::getInstance('sql')->get('host');
        $usr = Config::getInstance('sql')->get('user');
        $pwd = Config::getInstance('sql')->get('pwd');
        $dsn = $driver.':host='.$host;
        $this->connection = new \PDO($dsn, $usr, $pwd, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
        $this->useDatabase();
    }
    
    public function useDatabase(?string $db = null): self {
        if(null === $db) {
            $db = Config::getInstance('sql')->get('db');
        }
        $this->connection->query("use `".$db."`");
        return $this;
    }
    
    public function getConnection(): \PDO {
        return $this->connection;
    }
    
    public function q(string $q, array $qa = []): \PDOStatement {
        $stmt = $this->connection->prepare($q);
        $stmt->execute($qa);
        return $stmt;
    }
    
    public function qa(string $q, array $qa = []): array {
        return $this->q($q, $qa)->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function qo(string $q, array $qa = []) {
        return $this->q($q, $qa)->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function qu(string $q, array $qa = []): int {
        $stmt = $this->q($q, $qa);
        return $stmt->rowCount();
    }
    
    public function qi(string $q, array $qa = []) {
        $this->q($q, $qa);
        return $this->connection->lastInsertId();
    }
}
