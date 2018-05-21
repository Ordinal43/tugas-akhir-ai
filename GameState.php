<?php 
    require_once "State.php";

    class GameState
    {
        public $root;

        public function __construct($box){
            $this->root = new State($box);
            $this->buildTree($box, $this->root, 2, true);
        }
        public function buildTree($box, &$currentState, $level, $turn){
            $currentState->printState();
            if($level > 0 && $currentState->limit){
                if($turn){
                    for ($i=0; $i < 9; $i++) { 
                        if($box[$i] == 0){
                            $tempBox = $box;
                            $tempBox[$i] = 2;
                            $currentState->nextState[] = new State($tempBox,$currentState->stateNumber);
                            $tempPointer = end($currentState->nextState);
                            $this->buildTree($tempBox, $tempPointer, $level - 1, false);
                        }
                    }
                }
                else{
                    for ($i=0; $i < 9; $i++) { 
                        if($box[$i] == 0){
                            $tempBox = $box;
                            $tempBox[$i] = 1;
                            $currentState->nextState[] = new State($tempBox,$currentState->stateNumber);
                            $tempPointer = end($currentState->nextState);
                            $this->buildTree($tempBox, $tempPointer, $tempLevel - 1, true);
                        }
                    }
                }
            }
            else{
                $currentState->setHeuristicValue();
            }
        }
    }
?>