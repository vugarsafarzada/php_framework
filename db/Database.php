<?php
class Database
{
    private $conn = null;

    public function __construct() {
        $this->connectToMysql();
    }

    public function __destruct() {
        $this->conn->close();
    }

    /**
     * @throws Exception
     */
    private function connectToMysql(): void
    {
        $servername = $_ENV['DATABASE_HOST'];
        $username = $_ENV['DATABASE_USER'];
        $password = $_ENV['DATABASE_PASSWORD'];
        $dbname = $_ENV['DATABASE_NAME'];

        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function select($query): array
    {
        $result = $this->conn->query($query);
        if ($result === false) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Query Error: " . $this->conn->error
            ];
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return ["data" => $data, "success" => true];
    }

    public function insert($table, $data): array
    {
        $keys = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));
        $stmt = $this->conn->prepare("INSERT INTO $table ($keys) VALUES ($placeholders)");

        $types = str_repeat('s', count($data)); // assuming all are strings, enhance if needed
        $stmt->bind_param($types, ...array_values($data));

        if (!$stmt->execute()) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Insert Error: " . $stmt->error
            ];
        }

        return ["data" => ["insert_id" => $this->conn->insert_id], "success" => true];
    }

    public function update($table, $data, $condition): array
    {
        $setStr = implode("=?, ", array_keys($data)) . "=?";
        $stmt = $this->conn->prepare("UPDATE $table SET $setStr WHERE $condition");

        $types = str_repeat('s', count($data)); // assuming all are strings, enhance if needed
        $stmt->bind_param($types, ...array_values($data));

        if (!$stmt->execute()) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Update Error: " . $stmt->error
            ];
        }

        return ["data" => ["affected_rows" => $stmt->affected_rows], "success" => true];
    }

    public function delete($table, $condition): array
    {
        $stmt = $this->conn->prepare("DELETE FROM $table WHERE $condition");

        if (!$stmt->execute()) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Delete Error: " . $stmt->error
            ];
        }

        return ["data" => ["affected_rows" => $stmt->affected_rows], "success" => true];
    }

    public function createTable($tableName, $columns): array
    {
        $columnDefinitions = implode(", ", $columns);
        $query = "CREATE TABLE $tableName ($columnDefinitions)";

        if (!$this->conn->query($query)) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Create Table Error: " . $this->conn->error
            ];
        }

        return ["data" => [], "success" => true];
    }

    public function deleteTable($tableName): array
    {
        $query = "DROP TABLE $tableName";

        if (!$this->conn->query($query)) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Delete Table Error: " . $this->conn->error
            ];
        }

        return ["data" => [], "success" => true];
    }

    public function getTableColumns($tableName): array
    {
        $result = $this->conn->query("DESCRIBE $tableName");

        if ($result === false) {
            return [
                "data" => [],
                "success" => false,
                "error_message" => "Query Error: " . $this->conn->error
            ];
        }

        $columns = [];
        while ($row = $result->fetch_assoc()) {
            $columns[] = $row;
        }

        return ["data" => $columns, "success" => true];
    }

    public function createSchema($schemaName): bool
    {
        $query = "CREATE DATABASE $schemaName";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            return $this->conn->error;
        }
    }

    public function deleteSchema($schemaName): bool
    {
        $query = "DROP DATABASE $schemaName";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            return $this->conn->error;
        }
    }

    public function checkSchemeIsExists($schemaName): bool
    {
        $query = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$schemaName'";
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkTableIsExists($tableName, $databaseName): bool
    {
        $sql = "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$databaseName' AND TABLE_NAME = '$tableName'";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

}
