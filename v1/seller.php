<?php
    session_start();
    header('Content-type: application/json');

    require("../config.php");

    $status = '200';
    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

        $method = $_SERVER['REQUEST_METHOD'];
        if( $method == "POST" ){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $comment = $_POST['comment'];

            $query = "insert into tbl_seller values( '', '$name', '$phone', '$comment' )";
            $result = mysql_query($query);
            if( !$result ){
                $status = "500";
                $message = mysql_error();
            }
        }
    }else{
        $status = '500';
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
