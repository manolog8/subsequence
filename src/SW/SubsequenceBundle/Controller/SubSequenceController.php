<?php

namespace SW\SubsequenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SW\SubsequenceBundle\Models\File;

class SubSequenceController extends Controller
{
    public function indexAction()
    {
        /**
        * Initialize
        */
        $file = new File();
        $weightlist=array();
        $a = $file->readFile();
         /**
        * Number of test cases to solve
        */
        $cases = $file->getTestCases();
        if (empty($a)) {
             /**
            * Iterate each test case
            */
            for ($index = 0; $index < $cases; $index++) {
                $result = 0;
                $weight = 0;
                $indexUpdate = true;
                /**
                * Obtain sequence objects target
                */
                $secuenceobj = $file->getListCases($index);
                /**
                * Get list of items by weight array()
                */
                $secuence = $secuenceobj->getSequence();
                $maxListLength = count($secuence[1]);
                /**
                * Validate sequence
                */
                while ($secuenceobj->sequenceValidates() && $indexUpdate) {
                     /**
                     * Returns the weight of the sequence
                     */
                    $result = $secuenceobj->sequenceResultSum($secuenceobj->getList());
                    if ($weight < $result) {
                        $weight = $result;
                    }
                    /**
                     * Update the sequence evaluates
                     */
                    $indexUpdate = $secuenceobj->updateIndex($maxListLength);
                }
                /**
                * Save results
                */
                $secuencel=json_encode($secuence);
                $weightlist[$secuencel] = $weight;
            }
        } else {
            /**
            * Save errors
            */
            $weightlist[]= $a;
        }
        
        
        return $this->render('SWSubsequenceBundle:SubSequence:index.html.twig', array(
            'weightlist' => $weightlist,
        ));
    }
}
