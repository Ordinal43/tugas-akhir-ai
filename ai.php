<?php
    $staticNumber = 0;
    class State{
        public $numberState;
        public $value;
        public $box;
        public $nextState;
        public $parentState;

        public function __construct($box, $parentState = 0){
            $this->box = $box;
            $this->nextState = Array();
            $this->numberState = $staticNumber;
            $this->parentState = $parentState;
        }

        public function printState(){
            echo "Number State: " . $this->numberState;
            echo "<br>";
            echo "Parent State: " . $this->parentState;
            echo "<br>";
            echo "Heuristic Value: " . $this->value;
            echo "<br>";
            echo $this->box[0] . $this->box[1] . $this->box[2];
            echo "<br>";
            echo $this->box[3] . $this->box[4] . $this->box[5];
            echo "<br>";
            echo $this->box[6] . $this->box[7] . $this->box[8];
            echo "<br>";echo "<br>";
        }

        // public function addState($box){
        //     $temp = new State($box);
        //     $this->nextState[] = $temp;
        // }
    }
    
    class GameState{
        public $root;
        // 1 = AI, 2 = PLAYER
        
        public function __construct($box){
            $this->root = new State($box);
            $this->buildTree($box, $this->root, 1, true);
        }
        
        // '1' => 1,
        // '2' => 0,
        // '3' => 0,
        // '4' => 2,
        // '5' => 0,
        // '6' => 0,
        // '7' => 0,
        // '8' => 0,
        // '9' => 0,
        // level: 2
        // turn: true
        // currentState: root
        
        public function buildTree($box, $currentState, $level, $turn){
            if ($level > 0 && $this->checkState($box)) {
                $tempBox = $box;
                for ($i=1; $i < 10; $i++) { 
                    if($tempBox[$i] == 0 && $turn){
                        $tempBox[$i] = 1;
                        // $currentState->addState($tempBox);
                        $currentState->nextState[] = new State($box, $currentState->numberState);
                        $this->buildTree($tempBox, end($currentState->nextState), $level--, false);
                    }
                    else if ($tempBox[$i] == 0 && !$turn){
                        $tempBox[$i] = 2;
                        $currentState->nextState[] = new State($box, $currentState->numberState);
                        $this->buildTree($tempBox, end($currentState->nextState), $level--, true);
                    }
                }
            }
            else{
                // debug_print_backtrace();
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
            $this->root->value = $this->maxFunction($this->root);
            foreach($this->root->nextState as $data){
                if($data->value == $this->root->value){
                    return $data->box;
                }
            }
        }
        
        protected function heuristicFunction($box){
            $value = 0;
            //Dari segi AI (value bertambah kalau ada kemungkinan AI utk menang)
            //cek vertical AI
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($box[$i+$j]==1) $cek++;
                    if($box[$i+$j]==2) break;
                    if($j==6){
                        if($cek==1) $value+=1;
                        else if($cek==2) $value+=10;
                        else if($cek==3) $value+=100;
                    }
                }
            }
            //cek horizontal AI
            for($i = 1; $i<=7; $i+=3){
                $cek=0;
                for($j = 0; $j <=2; $j++){
                    if($box[$i+$j]==1) $cek++;
                    if($box[$i+$j]==2) break;
                    if($j==2){
                        if($cek==1) $value+=1;
                        else if($cek==2) $value+=10;
                        else if($cek==3) $value+=100;
                    }
                }
            }
            //cek diagonal1 AI
            $cek=0;
            for($i = 1; $i<=9; $i+=4){
                if($box[$i]==1) $cek++;
                if($box[$i]==2) break;
                if($i==9){
                    if($cek==1) $value+=1;
                    else if($cek==2) $value+=10;
                    else if($cek==3) $value+=100;
                }
            }
            //cek diagonal2 AI
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($box[$i]==1) $cek++;
                if($box[$i]==2) break;
                if($i==7){
                    if($cek==1) $value+=1;
                    else if($cek==2) $value+=10;
                    else if($cek==3) $value+=100;
                };
            }

            //Dari segi PLAYER (value berkurang kalau ada kemungkinan PLAYER utk menang)
            //cek vertical PLAYER
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($box[$i+$j]==2) $cek++;
                    if($box[$i+$j]==1) break;
                    if($j==6){
                        if($cek==1) $value-=1;
                        else if($cek==2) $value-=10;
                        else if($cek==3) $value-=100;
                    }
                }
            }
            //cek horizontal PLAYER
            for($i = 1; $i<=7; $i+=3){
                $cek=0;
                for($j = 0; $j <=2; $j++){
                    if($box[$i+$j]==2) $cek++;
                    if($box[$i+$j]==1) break;
                    if($j==2){
                        if($cek==1) $value-=1;
                        else if($cek==2) $value-=10;
                        else if($cek==3) $value-=100;
                    }
                }
            }
            //cek diagonal1 PLAYER
            $cek=0;
            for($i = 1; $i<=9; $i+=4){
                if($box[$i]==2) $cek++;
                if($box[$i]==1) break;
                if($i==9){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                }
            }
            //cek diagonal2 PLAYER
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($box[$i]==2) $cek++;
                if($box[$i]==1) break;
                if($i==7){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                };
            }
            return $value;
        }

        public function printGameState($state){
            $state->printState();
            foreach ($state->nextState as $data) {
                $this->printGameState($data);
            }
        }
        
    }
    
    // for($i = 1; $i <=9; $i++){
    //     $box[$i] = $_POST["b$i"];
    // }
    
    $box = Array(
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 2,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0,
        '9' => 0,
    );
    
    $gs = new Gamestate($box);
    $nextGameState = $gs->getChoice();
    
    $returnObject = array(
        'choice' => $nextGameState
    );
    
    
    $JSON_Object = json_encode($returnObject);
    // print_r($gs->root);
    // var_dump($gs->root);
    $gs->printGameState($gs->root);
    
    // echo $JSON_Object;
    //terima pake array yg indexnya "choice"






?>