<?php
error_reporting(E_ERROR);
require_once 'lib/phpqrcode/phpqrcode.php';
$url = urldecode($_GET["data"]);
QRcode::png($url);
