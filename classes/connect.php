<?php
class connect
{
    private $conn = NULL;
    private $servername = "";
    private $username = "";
    private $password = "";
    private $database = "";

    public function __construct($server, $user, $pass, $db = "")
    {
        $this->servername = $server;
        $this->username   = $user;
        $this->password   = $pass;
        $this->database   = $db;
    }

    public function connect_db($db = "")
    {
        $status = false;
        $db_inuse = $this->database;
        if (trim($db) != "") $db_inuse = $db;
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $db_inuse);

            $status = true;
            if (mysqli_connect_errno()) {
                echo "Connection failed: " . mysqli_connect_error();
                $status = false;
            }
        } catch (Exception $ex) {
            echo "Connection failed: " . $ex->getMessage();
        }

        return $status;
    }

    public function execute_query($query)
    {
        $result = array();
        if ($this->connect_db()) {
            try {
                $stmt = $this->conn->query($query);
                $result = $stmt->fetch_all(MYSQLI_ASSOC);
            } catch (Exception $ex) {
                echo "Query failed: " . $ex->getMessage();
            }
        }
        return $result;
    }
}
