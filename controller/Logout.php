<?php
    include __DIR__ . '/../helper/Auth.php';
    $now = new DateTime();
    $current_time = $now->format('Y-m-d H:i:s');
    //check if post request
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(['status' => false, 'msg' => 'Method is not allowed']);
        exit();
    }    

    $logged_out = Auth::logout();
    echo json_encode($logged_out);
?>