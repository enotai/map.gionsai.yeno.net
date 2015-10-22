<?php
/**
 * Created by PhpStorm.
 * User: enotai
 * Date: 15/07/09
 * Time: 10:01
 */

//header('Access-Control-Allow-Origin:*');
define('BASEURL', 'http://map.gionsai.yeno.net');

$debug = (isset($_GET['debug']) && htmlspecialchars($_GET['debug']) !== 0)? true : false;//デバッグモード
$start = microtime();//読み込み時間計測

$title='木更津高専祇園祭2015 企画案内 - ';
$description='木更津高専祇園祭2015の企画案内。企画分類別案内や現在地検索などを提供。';
$keyword='木更津高専, 木更津工業高等専門学校, 祇園祭';








