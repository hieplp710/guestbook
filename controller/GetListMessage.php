<?php
    include '../helper/Database.php'; 
    $now = new DateTime();
    $page_length = 10;
    $current_time = $now->format('Y-m-d H:i:s');
       
    $database = new Database();
    $conn = $database->connect();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $page_length;
    $sql = "SELECT * FROM guest_message WHERE is_deleted = 0 ORDER BY timestamp DESC LIMIT $page_length OFFSET $offset";    
    $result = $conn->query($sql);
    $messages = [];    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $timestamp = isset($row["timestamp"]) ? DateTime::createFromFormat('Y-m-d H:i:s', $row["timestamp"]) : null;
            $post_date = '';
            if ($timestamp) {
                $post_date = $timestamp->format('dS M, Y') . ' at '. $timestamp->format('h:ia');
            }
            $messages[] = [
                "id"         => $row["id"],
                "guest_name" => $row["guest_name"],
                "message"    => $row["message"],
                "timestamp"  => $post_date
            ];
        }
    }
    $sqlCount = "SELECT COUNT(*) AS total FROM guest_message WHERE is_deleted = 0";    
    $resultCount = $conn->query($sqlCount);    
    $count = 0;
    if ($resultCount->num_rows > 0) {
        // output data of each row
        while($row = $resultCount->fetch_assoc()) {
            $count = intval($row['total']);
        }
    }
    echo json_encode([
        "status" => true,
        "data"   => $messages,
        "numberPage" => ceil($count / $page_length)
    ]);
    $conn->close();
?>