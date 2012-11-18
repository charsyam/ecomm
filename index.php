<?php
session_start();
require 'h2o/h2o.php';
require 'util.php';

$h2o = new h2o('templates/index.html');

$page = array(
    'title' => "A Farmer's Marke",
    'currenttime' => getCurrentTime(),
    'login' => $_SESSION["login"],
    'hastoday' => 1,
    'today' => array(
        'uid' => 1,
        'label' => '상품',
        'title' => '밴쿠버 진천쌀',
        'price' => 28000,
        'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
    ),
    'itemcount' => 4,
    'items' => array(
        array(
            'starttag' => '<tr>',
            'endtag' => '',
            'uid' => 2,
            'label' => '상품',
            'title' => '밴쿠버 진천쌀',
            'price' => 28000,
            'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
        ),
        array(
            'starttag' => '',
            'endtag' => '',
            'uid' => 2,
            'label' => '상품',
            'title' => '밴쿠버 진천쌀',
            'price' => 28000,
            'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
        ),
        array(
            'starttag' => '',
            'endtag' => '</tr>',
            'uid' => 2,
            'label' => '상품',
            'title' => '밴쿠버 진천쌀',
            'price' => 28000,
            'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
        ),
        array(
            'starttag' => '<tr>',
            'endtag' => '</tr>',
            'uid' => 2,
            'label' => '상품',
            'title' => '밴쿠버 진천쌀',
            'price' => 28000,
            'image' => "http://img1.coupangcdn.com/image/dd/61/63/27936163_7b7104f9-298b-4b32-b452-d95c8430e83a.jpg"
        )
    )
);

# render your awesome page
echo $h2o->render(compact('page'));
?>
