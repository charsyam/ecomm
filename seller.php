<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/seller.html');

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$pagenum = 0;
if ( isset($_GET['page']) )
    $pagenum = $_GET['page'];

$startnum = $pagenum * 9;
$endnum = $startnum + 9;

$items = array();
$query = "select * from tbl_seller order by id desc limit $startnum, $endnum";
$result = mysql_query($query);
$count = mysql_num_rows($result);
$num = 0;

while( $row = mysql_fetch_array($result) ){
    $newitem = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'comment' => $row['comment']
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
    'admin' => $_SESSION["admin"],
    'itemcount' => $count,
    'items' => $items,
    'prevpage' => $pagenum-1,
    'nextpage' => $pagenum+1,
    'hasprevpage' => $hasprevpage, 
    'hasnextpage' => $hasnextpage
);

echo $h2o->render(compact('page'));
?>
