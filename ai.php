<?php
    class State{
        public $value;
        public $box;
        public $nextState;

        public function __construct($box = []){
            $tempObj = new ArrayObject($box);
            $this->box = $tempObj->getArrayCopy();
            $this->nextState = Array();
        }

        public function addState($box){
            $temp = new State($box);
            array_push($this->nextState, $temp);
        }
    }
    
    class GameState{
        public $root;
        // 1 = AI, 2 = PLAYER
        
        public function __construct($box = []){
            $this->root = new State($box);
            $this->buildTree($box, $this->root, 2, true);
        }
        
        public function buildTree($box = [], $currentState, $level = 2, $turn = true){
            if ($level != 0 && $this->checkState($box)) {
                for ($i=1; $i < 10; $i++) { 
                    if($box[$i] === 0 && $turn){
                        $box[$i] = 1;
                        $currentState->addState($box);
                        $this->buildTree($box, end($currentState->nextState), $level--, false);
                    }
                    else if ($box[$i] === 0 && !$turn){
                        $box[$i] = 2;
                        $currentState->addState($box);
                        $this->buildTree($box, end($currentState->nextState), $level--, true);
                    }
                }
            }
            else{
                $currentState->value = $this->heuristicFunction($box);
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
            if(!$this->hasNextState($currentState)){
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

        public function maxFunction($currentState){
            if(!$this->hasNextState($currentState)){
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
        
        public function getChoice(){
            $this->root->value = $this->minFunction($this->root);
            foreach($this->root->nextState as $data){
                if($data->value === $this->root->value){
                    return $data->box;
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

    // $box = Array(
    //     '1' => 0,
    //     '2' => 1,
    //     '3' => 0,
    //     '4' => 0,
    //     '5' => 0,
    //     '6' => 0,
    //     '7' => 0,
    //     '8' => 0,
    //     '9' => 0,
    // );

    $gs = new Gamestate($box);
    // p    rint_r($gs);
    $nextGameState = $gs->getChoice();

    $returnObject = array(
        'nextGameState' => $nextGameState
    );


    $JSON_Object = json_encode($returnObject);
    // print_r($JSON_Object);
    return $JSON_Object;


    //terima pake array yg indexnya "choice"
?>