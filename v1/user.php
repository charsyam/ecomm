<?php
    session_start();
    header('Content-type: application/json');

    require("../config.php");

    $method = $_SERVER['REQUEST_METHOD'];
    if( $method == "GET" ){
        include('get_user.php');
    }
    else if( $method == "POST" ){
        include('post_user.php');
    }else{
        $status = '500';
        $message = mysql_error();
        $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
        echo json_encode($ret);
    }
?>
