<?php
    require("../config.php");

    $status = '200';
    $seller = "";

    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    if ($link) {
        mysql_select_db(DBNAME);

        $query = "select * from tbl_today where date='".date("Ymd")."' order by id desc";
        $result = mysql_query($query);
        if( !$result ){
            $status = "500";
            $message = mysql_error();
        }else{
            $count = mysql_num_rows($result);
            if( $count > 0 ){
                $ret = mysql_fetch_array($result);
                $today = $ret['good_id'];

                $query = "select * from tbl_goods where id='$today'";
                $result = mysql_query($query);
                $ret = mysql_fetch_array($result);

                $today = array(
                    'id' => $ret["id"],
                    'label' => "상품",
                    'title' => $ret["title"],
                    'price' => $ret["price"],
                    'image' => $ret["image"]
                );
            }else{
                $status = "501";
                $message = "not found";
            }

            
        }
        $message = mysql_error();
    }else{
        $status = '500';
        $message = mysql_error();
    }

    $ret = array( 'status' => $status, 'today' => $today, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
