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
            if($level > 0 && $currentState->limit){
                // $currentState->printState();
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
                            $this->buildTree($tempBox, $tempPointer, $level - 1, true);
                        }
                    }
                }
            }
            else{
                $currentState->setHeuristicValue();
                // $currentState->printState();
            }
        }

        protected function minFunction($currentState){
            if($currentState->emptyNextState()){
                return $currentState->heuristicValue;
            }
            else{
                $currentState->heuristicValue = 9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->heuristicValue = min($currentState->heuristicValue,$this->maxFunction($nState));
                }
                return $currentState->heuristicValue;
            }
        }
        
        protected function maxFunction($currentState){
            if($currentState->emptyNextState()){
                return $currentState->heuristicValue;
            }
            else{
                $currentState->heuristicValue = -9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->heuristicValue = max($currentState->heuristicValue,$this->minFunction($nState));
                }
                return $currentState->heuristicValue;
            }
        }

        public function getState(){
            $this->root->heuristicValue = $this->maxFunction($this->root);
            foreach($this->root->nextState as $data){
                if($data->heuristicValue == $this->root->heuristicValue){
                    return $data;
                }
            }
        }

        public function getChoice($otherState){
            for ($i=0; $i < 9; $i++) { 
                if($this->root->Array[$i] != $otherState->Array[$i]){
                    return $i;
                }
            }
        }
    }
?>