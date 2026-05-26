<?php
/**
 * Database Connection Class
 * Handles all database operations
 */

class Database {
    private $mysqli;
    private static $instance = null;

    /**
     * Singleton pattern - get database instance
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Private constructor for singleton
     */
    private function __construct() {
        $config = require 'database.php';
        
        $this->mysqli = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['database'],
            $config['port']
        );

        if ($this->mysqli->connect_error) {
            die('Database Connection Failed: ' . $this->mysqli->connect_error);
        }

        $this->mysqli->set_charset($config['charset']);
    }

    /**
     * Get mysqli connection
     */
    public function getConnection() {
        return $this->mysqli;
    }

    /**
     * Execute query
     */
    public function query($sql) {
        return $this->mysqli->query($sql);
    }

    /**
     * Prepared statement - secure queries
     */
    public function prepare($sql) {
        return $this->mysqli->prepare($sql);
    }

    /**
     * Get last inserted ID
     */
    public function getLastId() {
        return $this->mysqli->insert_id;
    }

    /**
     * Get affected rows
     */
    public function getAffectedRows() {
        return $this->mysqli->affected_rows;
    }

    /**
     * Escape string for SQL
     */
    public function escape($str) {
        return $this->mysqli->real_escape_string($str);
    }

    /**
     * Close connection
     */
    public function close() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->mysqli->begin_transaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        return $this->mysqli->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->mysqli->rollback();
    }

    /**
     * Prevent cloning of singleton instance
     */
    private function __clone() {}

    /**
     * Prevent unserialization of singleton instance
     */
    public function __wakeup() {}
}
?>
