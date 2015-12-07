<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.11.15
 * Time: 10:36
 */


namespace devgroup;

use Ballen\Executioner\Executioner;

require "vendor/autoload.php";

class cmdSuccess
{
    private $_fileDir = 'file/';

    function checkFile($aplication, $command, $lastLine = -1)
    {
        $fileExists = $this->checkFileExists($aplication, $command);
        if ($fileExists === "not start") {
            return $this->commandExecution($aplication, $command);
        } else {
            return $this->getLine($aplication, $command, $lastLine);
        }
    }


    function commandExecution($aplication, $command)
    {
        ignore_user_abort(true);
        @set_time_limit(0);

        $fopen = $this->fileNameGen($aplication, $command);

        $runner = new Executioner();
        $runner->setApplication($aplication)
            ->addArgument($command)
            ->addArgument('> ' . $fopen)// Displays the PHP version number!
            ->execute();

        $fileopen = fopen('./' . $fopen, "a+");

        fwrite($fileopen, "\n" . base64_encode("done"));
        fclose($fileopen);

        return true;
    }

    /**
     * @param $aplication
     * @param $command
     * @return string
     */
    public function getFileName($aplication, $command)
    {
        return $fileName = $aplication . base64_encode($command);
    }

    /**
     * @param $fopen
     * @param $config
     */
    public function getLine($aplication, $command, $lastLine = -1)
    {
        $fopen = $this->fileNameGen($aplication, $command);
        $file = escapeshellarg($fopen);
        $done = `tail -n 1 $file`;
        $lines = @file($fopen);
        if ($done === base64_encode('done')) {
            unset($lines[count($lines)]);
        }
        return $this->getResultforLine($fopen, $lastLine);
    }

    /**
     * @param $aplication
     * @param $command
     * @return string
     */
    public function fileNameGen($aplication, $command)
    {
        $fileName = $this->getFileName($aplication, $command);
        $fopen = $this->_fileDir . $fileName;
        return $fopen;
    }

    /**
     * @param $fopen
     * @param $lastLine
     * @return string
     */
    public function getResultforLine($fopen, $lastLine)
    {
        $lines = @file($fopen);

        if ($lastLine !== -1 && $lastLine !== 0)
            for ($i = 0; $i <= $lastLine; $i++) {
                unset($lines[$i]);
            }

        if ($lines[count($lines) - 1] === base64_encode('done')) {
            unset($lines[count($lines) - 1]);
        }
        if ($lines[$lastLine] === base64_encode('done')) {
            unset($lines[$lastLine]);
        }
        return (!empty($lines)) ? implode("", $lines) : false;
    }

    /**
     * @param $aplication
     * @param $command
     * @return string
     */
    public function checkFileExists($aplication, $command)
    {
        $fopen = $this->fileNameGen($aplication, $command);

        if (@file_exists($fopen)) {
            $fileOpen = escapeshellarg($fopen);
            $done = `tail -n 1 $fileOpen`;
            if ($done === base64_encode('done')) {
                return 'access';
            } else {
                return 'in works';
            }
        } else {
            return 'not start';
        }
    }

    public function getWidget($command, $app)
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $fileName = $this->fileNameGen($command, $app);

        require "widget.phtml";
    }
}



