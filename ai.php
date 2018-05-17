<?php
    class State{
        public $value;
        public $upperState;
        public $box = [];
        public $nextState = [];

        public function __construct($box = [], $upperState = null){
            $tempObj = new ArrayObject($box);
            $this->box = $tempObj->getArrayCopy();
            $this->upperState = $upperState;
        }
    }
    
    class GameState{
        public $root;

        public function __construct($box = []){
            $this->root = new State($box);
            buildTree($box, $root, 2, true);
        }
        // 1 = AI, 2 = PLAYER
        public function buildTree($box = [], $currentState, $level = 2, $turn = true){
            if ($level != 0 && checkState($box)) {
                for ($i=1; $i < 10; $i++) { 
                    if($box[$i] === 0 && $turn){
                        $box[$i] = 1;
                        $currentState->nextState[] = new State($box, $currentState);
                        buildTree($box, end($currentState->nextState), $level--, false);
                    }
                    else if ($box[$i] === 0 && !$turn){
                        $box[$i] = 2;
                        $currentState->nextState = new State($box, $currentState);
                        buildTree($box, end($currentState->nextState), $level--, true);
                    }
                }
            }
            else{
                $currentState->value = heuristicFunction($box);
            }
        }

        public function checkState($box){
            for ($i=1; $i < 10; $i++) { 
                if($box[$i] == 0) return true;
            }
            return false;
        }

        //State function
        protected function hasNextState($state){
            if(empty($state->nextState)){
                return false;
            }
            else{
                return true;
            }
        }

        public function minFunction($currentState){
            if(!hasNextState($currentState)){
                return $currentState->value;
            }
            else{
                $currentState->value = 9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->value = min($currentState->value,maxFunction($nState));
                }
                return $currentState->value;
            }
        }

        public function maxFunction($currentState){
            if(!hasNextState($currentState)){
                return $currentState->value;
            }
            else{
                $currentState->value = -9999;
                foreach ($currentState->nextState as $nState) {
                    $currentState->value = max($$currentState->value,minFunction($nState));
                }
                return $currentState->value;
            }
        }
        
        public function getChoice(){
            $this->root->value = minFunction($this->root);
            foreach ($this->$root->nextState as $data) {
                if($this->root->value == $data->value) {
                    return $data;
                }
            }
        }

        protected function heuristicFunction($box){
            $value = 0;
            //cek vertical
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($box[$i+$j]==1) $cek=1;
                    if($box[$i+$j]==2) break;
                    if($j==6 && $cek==1) $value++;
                }
            }
            //cek horizontal
            for($i = 1; $i<=7; $i+=3){
                $cek=0;
                for($j = 0; $j <=2; $j++){
                    if($box[$i+$j]==1) $cek=1;
                    if($box[$i+$j]==2) break;
                    if($j==2 && $cek==1) $value++;
                }
            }
            //cek diagonal1
            for($i = 1; $i<=9; $i+=4){
                if($box[$i]==1) $cek=1;
                if($box[$i]==2) break;
                if($i==9 && $cek==1) $value++;
            }
            //cek diagonal2
            for($i = 3; $i<=7; $i+=2){
                if($box[$i]==1) $cek=1;
                if($box[$i]==2) break;
                if($i==7 && $cek==1) $value++;
            }
            return $value;
        }
        
    }
    
    for($i = 1; $i <=9; $i++){
        $box[$i] = $_POST["b$i"];
    }

    $gs = new Gamestate($box);
    $nextGameState = $gs->getChoice();

    $returnObject = array(
        'nextGameState' => $nextGameState
    );

    $JSON_Object = json_encode($returnObject);
    return $JSON_Object;


    //terima pake array yg indexnya "choice"
?>