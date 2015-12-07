<?php
require "cmdSuccess.php";
use devgroup\cmdSuccess;
$cmd    =   new cmdSuccess();
$data   =   json_decode($_GET['data']);
//  echo $cmd->checkFile($data->command, $data->app);
//  echo $cmd->checkFileExists($data->command, $data->app);
echo $cmd->getLine($data->command, $data->app, ($data->countLines), $data->strlenLastStr);


