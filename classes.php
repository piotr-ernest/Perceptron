<?php

require 'lib/Hebb.php';

$totals = null;
$error_numbers = false;

if (isset($_POST['number_indexes']) && isset($_POST['number_x'])) {
    
    $number_indexes = (int) $_POST['number_indexes'];
    $number_x = (int) $_POST['number_x'];
    
}

if (isset($_POST['vectors'])) {
    
    unset($_POST['vectors']);
    $const_learn = (float) str_replace(',', '.', $_POST['const_learn']);
    unset($_POST['const_learn']);
    $count = $_POST['count'];
    unset($_POST['count']);
    $x0 = (float) str_replace(',', '.', $_POST['x0']);
    unset($_POST['x0']);
    $function = $_POST['function'];
    unset($_POST['function']);
    
    $samples = array();
    
    while($e = each($_POST)){
        if(preg_match('/^d[0-9]+$/', $e['key'])){
            //$samples[$e['key']] = $e['value'];
            $samples[] = (float) str_replace(',', '.', $e['value']);
            unset($_POST[$e['key']]);
        }
    }
    
    $rowData = array_map(function($elem){
        $res = htmlspecialchars(trim($elem));
        return (float) str_replace(',', '.', $res);
    }, $_POST);
    
    $arrays = array_chunk($rowData, $count, true);
    
    $hebb = new Hebb();
    
    $hebb->setSamples($samples);
    $hebb->setFunctionType($function);
    
    if (!empty($const_learn)) {
        $hebb->setConstantLearning(str_replace(',', '.', $const_learn));
    }

    if (!empty($x0)) {
        $hebb->setTresholdValue(str_replace(',', '.', $x0));
    }

    $hebb->setScales(array_values($arrays[0]));

    unset($arrays[0]);

    $inputArray = array();

    foreach($arrays as $key => $val){
        while($v = each($val)){
            $inputArray[$key][] = $v['value'];
        }
    }

    $hebb->setInput(array_values($inputArray));
    $learningResult = $hebb->doLearning();
    
    $rowTotals = Hebb::getSummarize();
    
    $totals = '';
    
    while($row = each($rowTotals)){
        $totals .= 'Wartości wektora wag W' . $row['key'] . ': ' . implode(', ', $row['value']['W'. $row['key']]) . '</br>';
        $totals .= 'Wartość NET' . $row['key'] . ': ' . $row['value']['NET'. $row['key']] . '</br>';
        $totals .= 'Wartość na wyjściu Y' . $row['key'] . ': ' . $row['value']['Y'. $row['key']] . '</br>';
        $totals .= 'Wartość próbki D' . $row['key'] . ': ' . $row['value']['D'. $row['key']] . '</br><hr>';
    }
    
}

function desc($data, $exit = false, $title = '', $out = false)
{

    if ($out) {
        return print_r($data, $out);
    }

    echo '<div style="background: #ff6600; color: #003333; padding: 10px; overflow-x: auto; z-index: 9999;'
    . 'border-radius: 10px; margin: 10px;">';
    echo '<h4>' . $title . '</h4>';
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    echo '</div>';

    if ($exit) {
        exit;
    }
}
