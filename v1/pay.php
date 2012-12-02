<?php
    session_start();
    header('Content-type: application/json');
    require("../config.php");

    $login = 0;
    if ( isset( $_SESSION["login"] ) ){
        $login = $_SESSION["login"];
    }

    if ($login == 0 ){
        $ret = array( 'status' => '501', 'message' => '구매를 위해서 로그인이 필요합니다.', "code" => 0, "more_info" => "http://localhost/errors/2003" );
        echo json_encode($ret);
        return;
    }

    $idlist = "";
    $num = 0;
    foreach( $_SESSION["cart"] as $id => $count ){
        if( $id=="" || $id=="undefined" )
            continue;

        if ( $num == 0 ){
            $idlist = "$id";
        }else{
            $idlist = $idlist.",$id";
        }
        $num++;
    }

    $total_price =0;

    $link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
    mysql_select_db(DBNAME);

    if ($idlist == "" ){
        $ret = array( 'status' => '501', 'message' => '장바구니에 상품이 없습니다.', "code" => 0, "more_info" => "http://localhost/errors/2003" );
        echo json_encode($ret);
        return;
    }

    mysql_query("BEGIN");
    $query = "select * from tbl_goods";
    $query = $query." where id in ($idlist)";
    $result = mysql_query( $query );
    $num = 0;

    $items = array();

    while( $row = mysql_fetch_array($result) ){
        $id = $row['id'];
        $count = $_SESSION["cart"]["$id"];
        $price = $row['price'];
        $realprice = $count * $price;
        $newitem = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'price' => $row['price'],
                'count' => $count,
                'realprice' => $realprice
                );

        $total_price += $realprice;
        array_push( $items, $newitem );
        $num++;
    }

    $status = '200';
    if ($link) {
        $time = date("YmdHi");
        $uid = $_SESSION['uid'];
        $query = "insert into tbl_histories values( '', $uid, '$time', $total_price )";
        $result = mysql_query($query);
        $hid = mysql_insert_id();

        foreach( $items as $item ){
            $itemid = $item['id'];
            $price = $item['price'];
            $count = $item['count'];
            $title = $item['title'];
            $query = "insert into tbl_histories_detail values( '', $uid, $hid, $itemid, $price, $count, '0', '$title' )";
            $result = mysql_query($query);
        }
        mysql_query("COMMIT");
    
        foreach( $items as $item ){
            unset( $_SESSION["cart"][$item["id"]] );
        }

        $message = "ok";
    }else{
        $status = '500';
        $message = mysql_error();
    }
    $ret = array( 'status' => $status, 'message' => $message, "code" => 0, "more_info" => "http://localhost/errors/2003" );
    echo json_encode($ret);
?>
