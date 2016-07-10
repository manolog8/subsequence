<?php
/**
 * Description of Sequence
 *
 * @author Manuel
 */
namespace SW\SubsequenceBundle\Models;

class Sequence {

    private $N;
    private $a = array();
    private $w = array();
    private $secuencelist = array();
    private $list = array();
    private $index = array();

    public function setN($value) {
        $this->N = $value;
    }

    public function setA($value) {
        $this->a[] = (int) $value;
    }

    public function setW($value) {
        $this->w[] = (int) $value;
    }

    public function getList() {
        return $this->list;
    }
    
    /**
    * Get list of items by weight array()
    */
    public function getSequence() {
        for ($i = 0; $i < $this->N; $i++) {
            $key = (int) $this->a[$i];
            $valor = (int) $this->w[$i];
            if (in_array($key, $this->secuencelist)) {
                array_push($this->secuencelist, $valor);
            } else {
                $this->secuencelist[$key][] = $valor;
            }
        }
        $this->fillIndex();
        return $this->secuencelist;
    }

    function fillIndex() {
        for ($i = 0; $i < count($this->secuencelist); $i++) {
            $this->index[$i] = 0;
        }
        foreach ($this->secuencelist as $value) {
            array_push($this->list, $value);
        }
    }
    
    /**
    * Validate sequence
    */
    function sequenceValidates() {
        $i = $this->index[0];
        $result = false;

        for ($l = 1; $l < count($this->index); $l++) {
            if ($i <= $this->index[$l]) {
                $result = true;
            } else {
                $result = false;
            }
            $i = $this->index[$l];
        }
        return $result;
    }

    /**
    * Sum sequences
    */
    function sequenceResultSum($list) {
        $result = 0;
        for ($i = 0; $i < count($list); $i++) {
            $result += $list[$i][$this->index[$i]];
        }
        return $result;
    }

    /**
    * update index already analized
    */
    function updateIndex($maxIndex) {
        $result = false;
        if ($this->index[0] == $maxIndex - 1) {
            return $result;
        }
        $indexSize = count($this->index) - 1;
        if ($this->index[0] == $this->index[$indexSize]) {
            $this->index[$indexSize] ++;
            $result = true;
        } else {
            for ($i = $indexSize; $i > 0; $i--) {
                $indexValue = $this->index[$i];
                if ($indexValue > $this->index[$i - 1]) {
                    $this->index[$i - 1] ++;
                    $result = true;
                    break;
                }
            }
        }
        return $result;
    }

}
