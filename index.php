<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//require('db.php');
require('core.php');

$URI = $_SERVER['REQUEST_URI'];

$path = preg_replace('/^\//', '', $URI);
$path = explode('?', preg_replace('#' . ROOT . '#', '', $path))[0] ?: 'index';

$dp = "source/$path.php";

$rp = 'source/default.php';
if (file_exists($dp)) {
    $rp = $dp;
}

render($rp);