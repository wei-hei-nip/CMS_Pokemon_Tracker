<?php


/**
 * A simple database wrapper over the PDO object
 * Class Db
 */
class Db {
    // The default driver settings
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    // PDO database connection
    private static $connection;

    /**
     * Connects to the database using given credentials
     * @param string $user Username
     * @param string $password Password
     * @param string $database Database name
     */
    public static function connect($user, $password, $database) {
        if (!isset(self::$connection)) {
            try {
                self::$connection = new PDO(
                    "pgsql:dbname=$database",
                    $user,
                    $password,
                    self::$settings
                );
            }
            catch (PDOException $e) {
                echo 'Unable to connect to the database server: ' . $e;
            }
        }
    }

    /**
     * Executes a query and returns all resulting rows as an array of associative arrays
     * @param string $query The query
     * @param array $params Parameters to be passed into the query
     * @return mixed An array of associative arrays or false in no data returned
     */
    public static function queryAll($query, $params = array()) {
        try {
            $result = self::$connection->prepare($query);
            $result->execute($params);
            return $result->fetchAll();
        }
        catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Executes a query and returns the first row of the result
     * @param string $query The query
     * @param array $params Parameters to be passed into the query
     * @return mixed An associative array representing the row or false in no data returned
     */
    public static function queryOne($query, $params = array()) {
        try {
            $result = self::$connection->prepare($query);
            $result->execute($params);
            return $result->fetch();
        }
        catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Executes a query and returns the number of affected rows
     * @param string $query The query
     * @param array $params Parameters to be passed into the query
     * @return int The number of affected rows
     */
    public static function query($query, $params = array()) {
        $result = self::$connection->prepare($query);
        try {
            $result->execute($params);
        }
        catch(PDOException $ex) {
            throw new PDOException();
        }
        return $result->rowCount();
    }

    /**
     * Inserts data from an associative array into the database as a new row
     * @param string $table The table name
     * @param array $params The associative array where keys represent columns and values their values
     * @return int The number of affected rows
     */
    public static function insert($table, $params = array()) {
        return self::query('INSERT INTO ' . $table . ' ('.
            implode(', ', array_keys($params)).
            ') VALUES ('.str_repeat('?,', sizeof($params)-1).'?)',
            array_values($params));
    }

    /**
     * Executes an update and passes data from an associative array to it
     * @param string $table The table name
     * @param array $values The associative array where keys represent columns and values their values
     * @param string $condition A string containing the condition (WHERE)
     * @return int The number of affected rows
     */
    public static function update($table, $values = array(), $condition, $params = array()) {
        return self::query('UPDATE ' . $table . ' SET '.
            implode(' = ?, ', array_keys($values)).
            ' = ? ' . $condition,
            array_merge(array_values($values), $params));
    }
}