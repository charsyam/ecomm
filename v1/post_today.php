<?php
    require("../config.php");

    $status = '200';
    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

        $id = $_POST['id'];
        $today = date('Ymd');

        $query = "insert into tbl_today values( '',$id, '$today' )";
        $result = mysql_query($query);
        if( !$result ){
            $status = "500";
            $message = mysql_error();
        }
    }else{
        $status = '500';
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
