<?php

    function heuristicFunction(){

    }

    for($i = 1; $i <=9; $i++){
        $name = "\$_POST[\'b".$i."\']";

        $box[$i] = $$name;
    }

    for($i = 1; $i <= 9; $i++){
        if($box[$i] == 0){
            $available[$i] = $box[$i];
        }
    }
    
    $maxPoint = -1;
    $choice = -1;
    foreach ($available as $key => $value) {
        $heuristicPoint[$value] = heuristicFunction();
        if ($maxPoint < $heuristicPoint[$value]){
            $choice = $key;
            $maxPoint = $heuristicPoint[$value];
        }
    }

    $returnObject->answer = $choice;
    $JSON_Object = json_encode($returnObject);
    return $JSON_Object;
?>