<?php 
    require_once "State.php";

    class GameState
    {
        public $root;   // Store root state

        // Constructor
        public function __construct($box, $depthBoundary = 2){
            $this->root = new State($box);
            $this->buildTree($box, $this->root, $depthBoundary, true);
        }

        // Tree Builder
        public function buildTree($box, &$currentState, $level, $turn){
            $nodeLevel = $currentState->level + 1;
            if($level > 0 && $currentState->limit){
                if($turn){
                    for ($i=0; $i < 9; $i++) { 
                        if($box[$i] == 0){
                            $tempBox = $box;
                            $tempBox[$i] = 2;
                            $currentState->nextState[] = new State($tempBox,$currentState->stateNumber, $nodeLevel);
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
                            $currentState->nextState[] = new State($tempBox,$currentState->stateNumber, $nodeLevel);
                            $tempPointer = end($currentState->nextState);
                            $this->buildTree($tempBox, $tempPointer, $level - 1, true);
                        }
                    }
                }
            }
            else{
                $currentState->setHeuristicValue();
            }
        }

        // MINIMAX FUNCTION
        // minFunction and maxFunction will be called recursively

        // To get minimum value from state's nextState
        protected function minFunction($currentState){
            if($currentState->emptyNextState()){
                return $currentState->value;
            }
            else{
                $currentState->value = 9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->value = min($currentState->value,$this->maxFunction($nState));
                }
                return $currentState->value;
            }
        }
        
        // To get maximum value from state's nextState
        protected function maxFunction($currentState){
            if($currentState->emptyNextState()){
                return $currentState->value;
            }
            else{
                $currentState->value = -9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->value = max($currentState->value,$this->minFunction($nState));
                }
                return $currentState->value;
            }
        }

        // To get a state that has same value with root from root's nextState 
        public function getState(){
            $this->root->value = $this->maxFunction($this->root);
            foreach($this->root->nextState as $data){
                if($data->value == $this->root->value){
                    return $data;
                }
            }
        }

        // To get optimal index choice
        public function getChoice($otherState){
            for ($i=0; $i < 9; $i++) { 
                if($this->root->Array[$i] != $otherState->Array[$i]){
                    return $i;
                }
            }
        }

        // toString function
        public function printGameState($state){
            $html = "<div>";
            $html .= $this->printGameStateHidden($state);
            $html .= "</div>";
            return $html;
        }

        private function printGameStateHidden($state){
            $html = "";
            $html .= $state->printState();
            if(!$state->emptyNextState()){
                foreach ($state->nextState as $data) {
                    $html .= $this->printGameState($data);
                }
            }
            return $html;
        }
    }
?>