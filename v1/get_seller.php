<?php
    require("../config.php");

    $status = '200';
    $seller = "";

    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

        $id = $_GET['id'];
        $query = "select * from tbl_seller where id=$id";
        $result = mysql_query($query);
        if( !$result ){
            $status = "500";
            $message = mysql_error();
        }else{
            $count = mysql_num_rows($result);
            $seller = mysql_fetch_array($result);
        }
        $message = mysql_error();
    }else{
        $status = '500';
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'seller' => $seller, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
