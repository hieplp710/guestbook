<?php
    include '../helper/Auth.php';
    $now = new DateTime();
    $current_time = $now->format('Y-m-d H:i:s');
    //check if post request
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['status' => false, 'msg' => 'Method is not allowed']);
        exit();
    }    
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $username    = isset($data['username']) ? trim($data['username']) : '';
    $password    = isset($data['password']) ? trim($data['password']) : '';

    $isLogged = Auth::login($username, $password);
    echo json_encode($isLogged);
?>