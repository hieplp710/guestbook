<?php
session_start();
include __DIR__ . '/Database.php';
class Auth {
    public static function register($name = 'Admin', $username = 'admin', $password = '123456') {
        // Create connection
        $database = new Database();
        $conn = $database->connect();

        // Escape user inputs for security
        $username = mysqli_real_escape_string($conn, $username);
        $name = mysqli_real_escape_string($conn, $name);
        $password = mysqli_real_escape_string($conn, $password);
        $encry_password = md5($password);
        $sql = "INSERT INTO user (name, username, password)
        VALUES ('$name', '$username', '$encry_password')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => true, 'msg' => 'User is created']);
        } else {
            echo json_encode(['status' => false, 'msg' => $conn->error]);
        }    
        $conn->close();
    }

    public static function login($username, $password) {
        if (isset($_SESSION['logged']) && $_SESSION['logged']) {
            return ["status" => true];
        }
        $database = new Database();
        $conn = $database->connect();

        // Escape user inputs for security
        $username = mysqli_real_escape_string($conn, $username);
        $encry_password = md5($password);
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$encry_password'";
        $result = $conn->query($sql);
        $messages = [];
        $resp = ["status" => false, "msg" => "Invalid username or password"];    
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = intval($row['id']);
                $_SESSION['logged'] = ["username" => $username, "id" => $id];            
            }            
            $resp = ["status" => true];
        }
        $conn->close();
        return $resp;
    }

    public static function logout() {
        if (!isset($_SESSION['logged'])) {
            return ["status" => true];
        }
        unset($_SESSION['logged']);
        return ["status" => true];
    }

    public static function isLogged() {
        if (isset($_SESSION['logged'])) {
            return $_SESSION['logged'];
        }
        return false;
    }
}
?>