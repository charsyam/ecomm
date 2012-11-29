<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';
require 'config.php';

$h2o = new h2o('templates/index.html');

$link = mysql_connect( DBHOST, DBUSER, DBPASS ) or die('Could not connect: '.mysql_error());
mysql_select_db(DBNAME);

$pagenum = 0;
if ( isset($_GET['page']) )
    $pagenum = $_GET['page'];

$startnum = $pagenum * 9;
$endnum = $startnum + 9;

$items = array();
$type = 0;

$json = file_get_contents('http://14.63.227.140/ecomm/v1/today.php');
$todayjson = json_decode($json);
print $todayjson;
$hastoday = 0;
if( $todayjson->{'status'} == "200" )
    $hastoday = 1;

print $hastoday;

$today = $todayjson->{'today'};
print $today;

$sortby = 0;
if ( isset($_GET['sortby']) )
    $sortby = $_GET['sortby'];

if( $sortby == 1 ){
    $query = "select * from tbl_goods order by price desc limit $startnum, $endnum";
} else {
    $query = "select * from tbl_goods order by id desc limit $startnum, $endnum";
}

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
    'hastoday' => $hastoday,
    'today' => $today,
    'type' => 0,
    'itemcount' => $count,
    'items' => $items,
    'currentpage' => $pagenum,
    'prevpage' => $pagenum-1,
    'nextpage' => $pagenum+1,
    'hasprevpage' => $hasprevpage, 
    'hasnextpage' => $hasnextpage
);

echo $h2o->render(compact('page'));
?>
