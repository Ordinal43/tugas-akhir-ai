<?php 
    require_once "GameState.php";
    require_once "State.php";

    $input = [
        '0' => 0,
        '1' => 0,
        '2' => 0,
        '3' => 1,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0
    ];

    $gs = new GameState($input);
    // var_dump($gs);
    // print_r($gs);
    // var_dump($gs->root);
    // $gs->root->printState();



?>

$value = 0;
            //cek vertical
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($Array[$i+$j]==1) $cek=1;
                    if($Array[$i+$j]==2) break;
                    if($j==6 && $cek==1) $value++;
                }
            }
            //cek horizontal
            for($i = 1; $i<=7; $i+=3){
                $cek=0;
                for($j = 0; $j <=2; $j++){
                    if($Array[$i+$j]==1) $cek=1;
                    if($Array[$i+$j]==2) break;
                    if($j==2 && $cek==1) $value++;
                }
            }
            //cek diagonal1
            for($i = 1; $i<=9; $i+=4){
                if($Array[$i]==1) $cek=1;
                if($Array[$i]==2) break;
                if($i==9 && $cek==1) $value++;
            }
            //cek diagonal2
            for($i = 3; $i<=7; $i+=2){
                if($Array[$i]==1) $cek=1;
                if($Array[$i]==2) break;
                if($i==7 && $cek==1) $value++;
            }