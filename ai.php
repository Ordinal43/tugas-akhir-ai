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

        protected function heuristicFunction($box){
            $value = 0;

            //insert your fucking heuristic function here...
            
            return $value;
        }
    }

    class GameState{
        public $value = -1;
        public $root;

        public function __construct($box = []){
            $this->root = new State($box);
        }

        public function buildTree($box = [], $currentNode, $level = 2, $turn = true){
            if ($level != 0) {
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
        }

        public function getChoice(){

            //insert minmax function

            return $choice;
        }

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

    $returnObject->answer = $choice;
    $JSON_Object = json_encode($returnObject);
    return $JSON_Object;


    //terima pake array yg indexnya "choice"
?>