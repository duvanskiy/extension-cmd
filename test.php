<?php
require "cmdSuccess.php";
use devgroup\cmdSuccess;
$file = new cmdSuccess();
$cmd = "ping";
$app = "-c 50 ya.ru";
//echo $file->commandExecution('ping', '-c 10 ya.ru');
echo $file->getWidget($cmd, $app);
//echo $file->getLine('ping', '-c 6 ya.ru', 4);
