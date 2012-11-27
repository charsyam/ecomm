<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/cart.html');

if( isset( $_GET["id"] ) ) {
    $id = $_GET["id"];
    $value = 1;
    if( isset( $_SESSION["cart"]["$id"] ) ){
        $value = $_SESSION["cart"]["$id"];
        $value++;
    }
    $_SESSION["cart"]["$id"] = $value;
}

$items = array();

$idlist = "";
$num = 0;
foreach( $_SESSION["cart"] as $id => $count ){
    if( $id=="" )
        continue;

    if ( $num == 0 ){
    $idlist = "$id";
    }else{
        $idlist = $idlist.",$id";
    }
    $num++;
}

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$query = "select * from tbl_goods where id in ($idlist)";
$result = mysql_query( $query );
$numcount = mysql_num_rows($result);
$num = 0;
while( $row = mysql_fetch_array($result) )
{
    $starttag = '';
    $endtag = '';

    if( $num % 3 == 0){
        $starttag = "<tr>";
    }
    if( ($num % 3) == 2 || $num == ($numcount-1)){
        $endtag = "</tr>";
    }

    $id = $row['id'];
    $count = $_SESSION["cart"]["$id"];
    $price = $row['price'];
    $realprice = $count * $price;
    $newitem = array(
            'starttag' => $starttag,
            'endtag' => $endtag,
            'id' => $row['id'],
            'label' => '상품',
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $row['image'],
            'count' => $count,
            'realprice' => $realprice
    );

    array_push( $items, $newitem );
    $num++;
}

$login = 0;
if ( isset( $_SESSION["login"] ) ){
    $login = $_SESSION["login"];
}

$name = "";
if ( isset( $_SESSION["name"] ) ){
    $name = $_SESSION["name"];
}

$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => $login,
    'name' => "$name",
    'itemcount' => count($items),
    'items' => $items
);

echo $h2o->render(compact('page'));
?>
