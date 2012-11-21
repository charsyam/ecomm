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
    $pagenum = $_GET['id'];

$items = array();
$query = "select * from tbl_goods where id=$id ";
$result = mysql_query($query);
$count = mysql_num_rows($result);

$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => $_SESSION["login"],
    'name' => $_SESSION["name"],
    'item' => array(
        'id' => 1,
        'label' => '상품',
        'title' => '밴쿠버 진천쌀',
        'price' => 28000,
        'comment' => "밴쿠버 최고의 농부가 생산한 햅쌀, 밥만 먹어도 밥이 뚝딱, 사라지는 밥도둑, 일단 한번 잡사봐. 한번 먹으면 잊을 수 없는 밥맛, 우리 애들이 달라졌어요. 엄마 밥줘!!! 맨날 햄버거, 피자를 찾던 아이들이, 밥을 찾습니다."
    ),
    'seller' => array(
        'name' => '김정수',
        'phone' => '000-000-0000',
        'comment' => '밴쿠버 최고의 농부'
    ),
    'images' => array()
);

echo $h2o->render(compact('page'));
?>
