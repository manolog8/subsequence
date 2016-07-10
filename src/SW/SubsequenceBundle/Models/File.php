<?php

/**
 * Description of File
 *
 * @author josem.guzman
 */
namespace SW\SubsequenceBundle\Models;

use SW\SubsequenceBundle\Models\Sequence;

class File {

    private $filename = '../web/Upload/input.txt';
    private $line = 0;
    private $test_cases;
    private $fp;
    private $error = array();
    private $list_cases = array();
    public $constraints = array(
        "T" => 5,
        "N" => 150000,
        "a" => 9000000000,
        "w" => 9000000000
    );

    public function getTestCases() {
        return $this->test_cases;
    }

    public function getListCases($index) {
        return $this->list_cases[$index];
    }

    /**
    * Reads and validates the file
    */
    function readFile() {
        $this->fp = fopen($this->filename, "r");
        while (!feof($this->fp)) {
            $this->line++;
            $data_line = fgets($this->fp);
            $dataarray = explode(" ", $data_line);
            $numberarray = count($dataarray);
            switch ($this->line) {
                case 1: //line for test cases
                    if ($dataarray[0] >= 1 && $dataarray[0] <= $this->constraints["T"]) {
                        $this->test_cases = $dataarray[0];
                    } else {
                        $this->error[] = "Test-Cases are not between 1 and " . $this->constraints["T"];
                    }
                    break;
                case 2://number of elements of the secuence
                    if ($dataarray[0] >= 1 && $dataarray[0] <= $this->constraints["N"]) {
                        
                    } else {
                        $this->error[] = "number of elements are not between 1 and " . $this->constraints["N"];
                    }
                    break;
                case 3://elements
                    foreach ($dataarray as $value) {
                        if ($value >= 1 && $value <= $this->constraints["a"]) {
                            
                        } else {
                            $this->error[] = "number ('$value') is not between 1 and " . $this->constraints["a"];
                        }
                    }
                    break;
                case 4://weight elements
                    foreach ($dataarray as $value) {
                        if ($value >= 1 && $value <= $this->constraints["w"]) {
                            
                        } else {
                            $this->error[] = "number ('$value') is not between 1 and " . $this->constraints["w"];
                        }
                    }
                    $this->line = 1;
                    break;
                default:
                    break;
            }
        }
        fclose($this->fp);
        $this->createSequence();
    }
    
    /**
    * Create sequences objects
    */
    function createSequence() {
        $this->line = 0;
        if (empty($this->error)) {
            $this->fp = fopen($this->filename, "r");
            $secuence = new Sequence();
            while (!feof($this->fp)) {
                $this->line++;
                $data_line = fgets($this->fp);
                $dataarray = explode(" ", $data_line);

                switch ($this->line) {
                    case 2://number of elements of the secuence
                        $secuence->setN($dataarray[0]);
                        break;
                    case 3://elements
                        foreach ($dataarray as $value) {
                            $secuence->setA($value);
                        }
                        break;
                    case 4://weight elements
                        foreach ($dataarray as $value) {
                            $secuence->setW($value);
                        }
                        $this->line = 1;
                        $this->list_cases[] = $secuence;
                        $secuence = new Sequence();
                        break;
                    default:
                        break;
                }
            }
            fclose($this->fp);
            return $this->list_cases;
        } else {
            return $this->error;
        }
    }

}
