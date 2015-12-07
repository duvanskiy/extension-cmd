<?php

namespace devgroup;
require 'cmdSuccess.php';


class cmdSuccessTest extends \PHPUnit_Framework_TestCase
{
    public function testFileName()
    {
        $cmd = new cmdSuccess();
        $this->assertEquals('pingLTUgeWEucnU=',
            $cmd->getFileName('ping', '-5 ya.ru'));
    }

    public  function testIsWritable(){
        $filename = 'file/';
        $this->assertTrue(is_writable($filename));
    }
}
