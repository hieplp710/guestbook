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
    $id         = isset($data['id']) ? trim($data['id']) : '';
    $message    = isset($data['message']) ? trim($data['message']) : '';
    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $id);
    $message = mysqli_real_escape_string($conn, $message);
    
    $sql = "UPDATE guest_message SET message = '$message' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => true, 'msg' => 'Message is updated successfully']);
    } else {
        echo json_encode(['status' => false, 'msg' => $conn->error]);
    }    
    $conn->close();
?>