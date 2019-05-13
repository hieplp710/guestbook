<?php
    include '../helper/Database.php';    
    $database = new Database();
    $conn = $database->connect();

    //check if post request
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['status' => false, 'msg' => 'Method is not allowed']);
        exit();
    }    
    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $id         = isset($data['id']) ? trim($data['id']) : '';
    // Escape user inputs for security
    $id = mysqli_real_escape_string($conn, $id);
    
    $sql = "UPDATE guest_message SET is_deleted = 1 WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => true, 'msg' => 'Message is deleted successfully']);
    } else {
        echo json_encode(['status' => false, 'msg' => $conn->error]);
    }    
    $conn->close();
?>