<?php

    class State{
        public $value;
        public $box = [];
        public $nextState = [];

        public function __construct($box = []){
            $tempObj = new ArrayObject($box);
            $this->box = $tempObj->getArrayCopy();
            $this->value = heuristicFunction($box);
        }

    }
    
    class GameState{
        public $value = -1;
        public $root;
        
        public function __construct($box = []){
            $this->root = new State($box);
            buildTree($box, $root, 2, true);
        }
        // 1 = AI, 2 = PLAYER
        public function buildTree($box = [], $currentNode, $level = 2, $turn = true){
            if ($level != 0 && checkState($box)) {
                for ($i=1; $i < 10; $i++) { 
                    if($box[$i] === 0 && $turn){
                        $box[$i] = 1;
                        $currentNode->nextState[] = new State($box);
                        buildTree($box, end($currentNode->nextState), $level--, false);
                    }
                    else if ($box[$i] === 0 && !$turn){
                        $box[$i] = 2;
                        $currentNode->nextState = new State($box);
                        buildTree($box, end($currentNode->nextState), $level--, true);
                    }
                }
            }
            else{
                $currentNode->value = heuristicFunction(box);
            }
        }

        public function checkState($box){
            for ($i=1; $i < 10; $i++) { 
                if($box[$i] == 0) return true;
            }
            return false;
        }
        
        public function getChoice(){
            
            return $choice;
        }

        protected function heuristicFunction($box){
            $value = 0;
    
            //insert your fucking heuristic function here...
            
            return $value;
        }
        
    }
    
    for($i = 1; $i <=9; $i++){
        $box[$i] = $_POST["b$i"];
    }

    for($i = 1; $i <= 9; $i++){
        if($box[$i] == 0){
            $available[$i] = $box[$i];
        }
    }

    $returnObject = array(
        answer => $answer
    );
    
    $JSON_Object = json_encode($returnObject);
    return $JSON_Object;


    //terima pake array yg indexnya "choice"
?>