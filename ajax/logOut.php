<?php 
    
    session_start();

    session_destroy();

    $response = [
        'respuesta' => 'success'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

?>