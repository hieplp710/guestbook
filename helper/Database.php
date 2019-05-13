<?php
    class Database{
        protected $conn;
        function __construct() {            
        }

        public function connect() {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "guestbook";
            // Create connection
            $this->conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            return $this->conn;
        }
    }
?>