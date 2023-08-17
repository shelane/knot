<?php

namespace App;

use PDO;

/**
 * The database class to maintain a singleton database connection so that
 * all database calls use that connection to reduce expensive operations.
 * A `config` array must be defined in Knot as `dbconfig` with the keys (example
 * values listed):
 *  - host => localhost
 *  - dbname => 'mydb'
 *  - username => 'user'
 *  - password => 'password'
 *  - options => [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,]
 */
class Database {

  /**
   * The Database Connection. This is a static connection that will be
   * reused for every database call.
   *
   * @var \PDO|null
   */
  private static $instance;

  /**
   * The PDO connection from $instance for use by individual defined objects.
   *
   * @var \PDO
   */
  protected PDO $connection;

  /**
   * The PDO Statement.
   *
   * @var \PDOStatement
   */
  private $statement;

  /**
   * The query result set.
   *
   * @var array
   */
  private array $queryResult = [];

  /**
   * Database constructor that is only created when getConnection is called
   * so that we maintain a single database connection for all queries.
   *
   * @param $config
   */
  private function __construct($config) {
    // Private constructor to prevent direct instantiation
    if (!self::$instance) {
      $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];
      self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
      self::$instance->exec("SET time_zone = '-7:00'");
    }
    $this->connection = self::$instance;
  }

  /**
   * Creates or returns the instance of the database connection.
   *
   * @throws \Exception
   */
  public static function getConnection($config = []): Database {
    if (empty($config)) {
      $config = Knot::get('dbconfig');
    }
    return new self($config);
  }

  /**
   * The query to be executed. It will store the results in the object to be
   * retrieved as needed.
   *
   * @param $sql
   *   The sql statement query. It can contain ? or :nameparameter.
   * @param array $params
   *   An array of values or associative array of named parameters
   *   to be inserted into the sql statement.
   *
   * @return \App\Database
   *   This database object will be returned so that actions can be chained.
   */
  public function query($sql, array $params = []): Database {
    $this->queryResult = [];
    $this->statement = $this->connection->prepare($sql);
    $this->statement->execute($params);

    return $this;
  }

  /**
   * Gets the prepared sql statement.
   *
   * @return \PDOStatement
   */
  public function getStatement(): \PDOStatement {
    return $this->statement;
  }

  /**
   * This is equivalent to the PDO fetchAll method.
   *
   * @return array|null
   */
  public function getAll($fetch_as = PDO::FETCH_ASSOC): ?array {
    if (empty($this->queryResult)) {
      $this->queryResult = $this->statement->fetchAll($fetch_as);
    }
    return $this->queryResult;
  }

  /**
   * This is equivalent to the PDO fetch method.
   *
   * @return array|bool
   */
  public function getRow() {
    return $this->statement->fetch();
  }

  /**
   * Returns an identifier for the record that was just added. For MySQL
   * databases, this is the value of the auto increment field in the tables,
   * usually the ID primary key field.
   *
   * @return int|null
   *   The last inserted ID or null.
   */
  public function getInsertId(): ?int {
    // Get the last inserted ID from the database connection.
    $keyfield_value = $this->connection->lastInsertId();

    // Return the last inserted ID or null if no row was inserted.
    return ($keyfield_value !== '0') ? (int) $keyfield_value : NULL;
  }

  /**
   * Returns the number of rows in the query result.
   *
   * @return int|null
   */
  public function rowCount(): ?int {
    return $this->statement->rowCount();
  }

}
