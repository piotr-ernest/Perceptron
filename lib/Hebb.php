<?php

require 'ArtificialNeuron.php';
require 'CoreMath.php';

/**
 * Description of Hebb
 *
 * @author rnest
 */
class Hebb extends ArtificialNeuron
{
    /*
     * w tej metodzie należy zaimplementować
     * właściwą funkcję aktywacji
     * fi = wynik z bloku sumującego
     * (metoda aggregateBox)
     */

    protected function activationFunction(callable $funct, $arg)
    {
        return $funct($arg);
    }

    protected function upgradeScales(Array $input, $sample)
    {

        $y = $this->getOutput();
        $cl = $this->getConstantLearning();
        $currentScales = $this->getScales();
        
        $middle = $cl * ($sample - $y);

        $middle_by_input = CoreMath::matrix_MultiplicationByScalar($input, $middle);

        $newScales = CoreMath::matrix_AdditionToMatrix($middle_by_input, $currentScales);
        $this->setScales($newScales);
        
//        desc($middle, 0, 'middle');
//        desc($middle_by_input, 0, 'middle by input');
//        desc($input, 0, 'input');
//        desc($y, 0, 'y=output');
//        desc($cl, 0, 'const. learn');
//        desc($currentScales, 0, 'curr. scales');
//        desc($sample, 0, 'sample');
//        desc($newScales, 0, 'new scales');
//        desc('========================================');
    }

    protected function signum($x)
    {
        if (!is_numeric($x)) {
            throw new Exception('Podany argument musi być liczbą.');
        }

        if ($x < 0) {
            return -1;
        }
        if ($x == 0) {
            return 0;
        }
        if ($x > 0) {
            return 1;
        }
    }

}
