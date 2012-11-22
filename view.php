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

$items = array();
$query = "select * from tbl_goods where id=$id ";

$result = mysql_query($query);
$count = mysql_num_rows($result);
$item = mysql_fetch_array($result);

$query = "select * from tbl_seller where id=".$item['seller'];
$result = mysql_query($query);
$count = mysql_num_rows($result);
$seller = mysql_fetch_array($result);

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
    'images' => array(
        array(
            'starttag' => '<tr>',
            'image' => 'http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg',
            'endtag' => ''
        ),
        array(
            'starttag' => '',
            'image' => 'http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg',
            'endtag' => ''
        ),
        array(
            'starttag' => '',
            'image' => 'http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg',
            'endtag' => '</tr>'
        ),
        array(
            'starttag' => '<tr>',
            'image' => 'http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg',
            'endtag' => '</tr>'
        )
    )
);

echo $h2o->render(compact('page'));
?>
