<?php 
    class State
    {
        static $constantStateNumber = 0; // Store unique number for State Identity
        
        public $stateNumber;    // State Identity
        public $stateParent;    // Store Parent State Identity
        public $value;          // Store State Value, whetever from it's own heuristic function or min-max
        public $box;            // mboh
        public $nextState;      // Store every next possible state
        public $limit;          // Check whetever the board state is full or the game is ended
        public $level;          // Store state tree level
        
        // Constructor
        public function __construct($box, $stateParent = 0, $level = 0){
            $this->$box = $box;
            $this->stateNumber = ++self::$constantStateNumber;
            $this->stateParent = $stateParent;
            $this->limit = $this->checkLimit();
            $this->level = $level;
        }

        // toString Function
        public function printState(){
            $html = "";
            $html .= "Number State: " . $this->stateNumber;
            $html .= "<br>";
            $html .= "Parent State: " . $this->stateParent;
            $html .= "<br>";
            if(!$this->emptyNextState()){
                $html .= "Child State: ";
                $html .= $this->printAllNextState();
                $html .= "<br>";
            }
            $html .= "Value: " . $this->value;
            $html .= "<br>";
            $html .= "Level: " . $this->level;
            $html .= "<br>";
            $html .= $this->Array[0] . $this->Array[1] . $this->Array[2];
            $html .= "<br>";
            $html .= $this->Array[3] . $this->Array[4] . $this->Array[5];
            $html .= "<br>";
            $html .= $this->Array[6] . $this->Array[7] . $this->Array[8];
            $html .= "<br>";$html .= "<br>";
            return $html;
        }

        // Print all nextState Identity
        public function printAllNextState(){
            $html = " ";
            if (!$this->emptyNextState()){
                foreach ($this->nextState as $data) {
                    $html .= "$data->stateNumber ";
                }
            }
            return $html;
        }

        // To get state difference from 2 distinct state
        public function diff($otherState){
            for ($i=0; $i < 9; $i++) { 
                if($this->Array[$i] != $otherState->Array[$i]){
                    return $i;
                }
            }
        }

        // Check if this state has no next state
        public function emptyNextState(){
            return empty($this->nextState);
        }

        // To check if this state is full
        public function checkLimit(){
            $flag = false;
            for ($i=0; $i < 9; $i++) { 
                if($this->box[$i] == 0){
                    $flag = true;
                    break;
                }
            }

            //cek vertical
            for ($i=0; $i < 3; $i++) { 
                if ($this->Array[$i] == $this->Array[$i+3] && $this->Array[$i] == $this->Array[$i+6] && $this->Array[$i] != 0){
                    return false;
                }
            }

            for ($i=0; $i <= 6; $i+=3) { 
                if ($this->Array[$i] == $this->Array[$i+1] && $this->Array[$i] == $this->Array[$i+2] && $this->Array[$i] != 0){
                    return false;
                }
            }

            return $flag;;
        }

        // Set heuristic value to this state
        public function setHeuristicValue(){
            $value = 0;
            //Dari segi AI (value bertambah kalau ada kemungkinan AI utk menang)
            //cek vertical AI
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($this->Array[$i+$j-1]==2) $cek++;
                    if($this->Array[$i+$j-1]==1) break;
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
                    if($this->Array[$i+$j-1]==2) $cek++;
                    if($this->Array[$i+$j-1]==1) break;
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
                if($this->Array[$i-1]==2) $cek++;
                if($this->Array[$i-1]==1) break;
                if($i==9){
                    if($cek==1) $value+=1;
                    else if($cek==2) $value+=10;
                    else if($cek==3) $value+=100;
                }
            }
            //cek diagonal2 AI
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($this->Array[$i-1]==2) $cek++;
                if($this->Array[$i-1]==1) break;
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
                    if($this->Array[$i+$j-1]==1) $cek++;
                    if($this->Array[$i+$j-1]==2) break;
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
                    if($this->Array[$i+$j-1]==1) $cek++;
                    if($this->Array[$i+$j-1]==2) break;
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
                if($this->Array[$i-1]==1) $cek++;
                if($this->Array[$i-1]==2) break;
                if($i==9){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                }
            }
            //cek diagonal2 PLAYER
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($this->Array[$i-1]==1) $cek++;
                if($this->Array[$i-1]==2) break;
                if($i==7){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                };
            }
            $this->value = $value;
        }
    }
?>