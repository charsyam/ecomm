<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/admin_history.html');

$items = array();

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$total_price =0;

if ( !isset( $_SESSION["admin"] ) )
{
    echo "관리자 로그인이 필요합니다.";
    return;
}

if ( isset($_GET["id"]) && isset($_GET["action"] )) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    if( $action != "" && $action != "undefined" ){
        $query = "update tbl_histories set action=$action where id=$id";
        $result = mysql_query( $query );
    }
}

$uid = $_SESSION["uid"];
$query = "select * from tbl_histories order by id desc";
$result = mysql_query( $query );
$num = 0;

while( $row = mysql_fetch_array($result) ){
    $id = $row['id'];
    $count = $_SESSION["cart"]["$id"];
    $price = $row['price'];
    $realprice = $count * $price;
    $action = $row['action'];

    $newitem = array(
                'id' => $row['id'],
                'price' => $row['price'],
                'buytime' => $row['buytime'],
                'action' => $action
                );

    for ( $i = 0; $i < 6; $i++ ){
        $keyname = "action".$i;
        $newitem[$keyname] = "";
        if( $i == $action ){
            $newitem[$keyname] = "selected";
        }        
    }


    $action = $row['action'];
    array_push( $items, $newitem );
}

foreach( $items as &$item ){
    $hid = $item['id'];
    $query = "select * from tbl_histories_detail where hid=$hid";
    $result = mysql_query( $query );
    $goods = "";
    
    while( $row = mysql_fetch_array($result) ){
        $goods .= "<div style='line-height:160%;'>";
        $goods = $goods."<span class='label'>".$row['title']."(".$row['price']." * ".$row['count'].")</span>";
        $goods .= "</div>";
    }
    $item["goods"] = $goods;
}

$name = "";
if ( isset( $_SESSION["name"] ) ){
    $name = $_SESSION["name"];
}

$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => 1,
    'name' => "$name",
    'items' => $items
);

echo $h2o->render(compact('page'));
?>
