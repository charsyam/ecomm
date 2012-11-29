<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';


if( $_SESSION["admin"] != 1 ){
    exit(-1);
}

$h2o = new h2o('templates/goods.html');

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$pagenum = 0;
if ( isset($_GET['page']) )
    $pagenum = $_GET['page'];

$startnum = $pagenum * 9;
$endnum = $startnum + 9;

$items = array();
$query = "select * from tbl_goods order by id desc limit $startnum, $endnum";
$result = mysql_query($query);
$count = mysql_num_rows($result);
$num = 0;

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
            'label' => '상품',
            'title' => $row['title'],
            'price' => $row['price'],
            'image' => $row['image']
    );
    array_push( $items, $newitem );
    $num++;
}

$lastpagenum = 1;

$hasprevpage = 0;
if( $pagenum > 0 )
    $hasprevpage = 1;
$hasnextpage = 1;
if( $pagenum == $lastpagenum )
    $hasnextpage = 0;
    
$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => $_SESSION["login"],
    'name' => $_SESSION["name"],
    'hastoday' => 1,
    'today' => array(
        'id' => 1,
        'label' => '상품',
        'title' => '밴쿠버 진천쌀',
        'price' => 28000,
        'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
    ),
    'itemcount' => $count,
    'items' => $items,
    'prevpage' => $pagenum-1,
    'nextpage' => $pagenum+1,
    'hasprevpage' => $hasprevpage, 
    'hasnextpage' => $hasnextpage
);

echo $h2o->render(compact('page'));
?>
