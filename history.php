<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/history.html');

$items = array();

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$total_price =0;

if ( !isset( $_SESSION["uid"] ) )
{
    echo "로그인이 필요합니다.";
    return;
}

$uid = $_SESSION["uid"];
$query = "select * from tbl_histories where uid=$uid";
$result = mysql_query( $query );
$num = 0;

while( $row = mysql_fetch_array($result) )
{
    $id = $row['id'];
    $count = $_SESSION["cart"]["$id"];
    $price = $row['price'];
    $realprice = $count * $price;
    $newitem = array(
                'id' => $row['id'],
                'price' => $row['price'],
                'buytime' => $row['buytime']
                );

    array_push( $items, $newitem );
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
