<?php
/**
 * @throws Exception
 */
function connectToMysql(): mysqli
{
    // Create connection
    $servername = $_ENV['DATABASE_HOST'];
    $username = $_ENV['DATABASE_USER'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $dbname = $_ENV['DATABASE_NAME'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    return $conn;
};

/**
 * @throws Exception
 */
function runSqlQuery($query): array
{
    $conn = connectToMysql();
    $result = $conn->query($query);

    if ($result === false) {
        throw new Exception("Query Error: " . $conn->error);
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}

function createSqlQuery($query): array
{
    try {
        return [
            'data' => runSqlQuery($query),
            'error' => null

        ];
    } catch (Exception $e) {
        return [
            'data' => [],
            'error' => $e->getMessage()

        ];
    }
}
