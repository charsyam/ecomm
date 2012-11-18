<?php
    session_start();
    header('Content-type: application/json');

    $_SESSION["login"] = 0;
    $status = '200';
    $messsage = "logout ok";
    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
