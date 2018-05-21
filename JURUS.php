<?php 
    require_once "GameState.php";
    require_once "State.php";
    //1 = Player, 2 = AI
    
    
    // Configuration section for Minimax Algorithm
    /*
        Variable:
            - $boundaryDepth    = Determine how deep the Gamestate will build the tree
            - $input            = Default state if user do not specify how the current state is
    */
    $boundaryDepth = 2;

    $input = [
        '0' => 0,
        '1' => 1,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0
    ];
    


    //End of Configuration Section




    /*
        DUDE PLEASE FUCKING DON'T FUCKING TOUCH OR FUCKING EDIT THIS FUCKING SECTION
    */
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $input = [
            '0' => $_POST['b1'],
            '1' => $_POST['b2'],
            '2' => $_POST['b3'],
            '3' => $_POST['b4'],
            '4' => $_POST['b5'],
            '5' => $_POST['b6'],
            '6' => $_POST['b7'],
            '7' => $_POST['b8'],
            '8' => $_POST['b9']
        ];
    }

    $gs = new GameState($input,$boundaryDepth);
    $state = $gs->getState();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $out = Array(
            "choice" => b.($gs->getChoice($state)+1)
        );
        //Deployment Function
        header('Content-Type: application/json');
        $json = json_encode($out);
        echo $json;

    }
    else{
        //Debugging Function
        $gs->printGameState($gs->root);
    }
?>