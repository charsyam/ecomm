<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/view.html');

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$id = 0;
if ( isset($_GET['id']) )
    $id = $_GET['id'];

$query = "select * from tbl_goods where id=$id";

$result = mysql_query($query);
$count = mysql_num_rows($result);
$item = mysql_fetch_array($result);

$query = "select * from tbl_seller where id=".$item['seller'];
$result = mysql_query($query);
$count = mysql_num_rows($result);
$seller = mysql_fetch_array($result);

$query = "select * from tbl_images where good_id=$id";
$result = mysql_query($query);
$count = mysql_num_rows($result);

$images = array();

while( $row = mysql_fetch_array($result) ){
    $starttag = '';
    $endtag = '';

    if( $num % 3 == 0){
        $starttag = "<tr>";
    }
    if( $num % 3 == 2 || $num == $count-1){
        $endtag = "</tr>";
    }

    $newitem = array(
            'starttag' => $starttag,
            'endtag' => $endtag,
            'id' => $row['id'],
            'image' => $row['image']
    );
    array_push( $images, $newitem );
    $num++;
}


$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => $_SESSION["login"],
    'name' => $_SESSION["name"],
    'item' => array(
        'id' => $item['id'],
        'label' => $item['label'],
        'title' => $item['title'],
        'price' => $item['price'],
        'comment' => $item['comment']
    ),
    'seller' => array(
        'name' => $seller['name'],
        'phone' => $seller['phone'],
        'comment' => $seller['comment']
    ),
    'images' => $images
);

echo $h2o->render(compact('page'));
?>
