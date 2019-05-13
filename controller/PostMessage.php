<?php
    include '../helper/Database.php';     
    $now = new DateTime();
    $current_time = $now->format('Y-m-d H:i:s');
    //check if post request
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['status' => false, 'msg' => 'Method is not allowed']);
        exit();
    }
    
    $database = new Database();
    $conn = $database->connect();    
    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $guest_name = isset($data['guest_name']) ? trim($data['guest_name']) : '';
    $message    = isset($data['message']) ? trim($data['message']) : '';
    // Escape user inputs for security
    $guest_name = mysqli_real_escape_string($conn, $guest_name);
    $message = mysqli_real_escape_string($conn, $message);
    
    $sql = "INSERT INTO guest_message (guest_name, message, timestamp)
    VALUES ('$guest_name', '$message', '$current_time')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => true, 'msg' => 'Message is posted successfully']);
    } else {
        echo json_encode(['status' => false, 'msg' => $conn->error]);
    }    
    $conn->close();
?>