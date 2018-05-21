<?php 
    class State
    {
        static $constantStateNumber = 0;
        
        public $stateNumber;
        public $stateParent;
        public $heuristicValue;
        public $box;
        public $nextState;
        public $limit;
        public $level;
        
        public function __construct($box, $stateParent = 0, $level = 0){
            $this->$box = $box;
            $this->stateNumber = ++self::$constantStateNumber;
            $this->stateParent = $stateParent;
            $this->limit = $this->checkLimit();
            $this->level = $level;
        }

        public function printState(){
            echo "Number State: " . $this->stateNumber;
            echo "<br>";
            echo "Parent State: " . $this->stateParent;
            echo "<br>";
            echo "Child State: "; $this->printAllNextState();
            echo "<br>";
            echo "Heuristic Value: " . $this->heuristicValue;
            echo "<br>";
            echo "Level: " . $this->level;
            echo "<br>";
            echo $this->Array[0] . $this->Array[1] . $this->Array[2];
            echo "<br>";
            echo $this->Array[3] . $this->Array[4] . $this->Array[5];
            echo "<br>";
            echo $this->Array[6] . $this->Array[7] . $this->Array[8];
            echo "<br>";echo "<br>";
        }

        public function printAllNextState(){
            if (!$this->emptyNextState()){
                foreach ($this->nextState as $data) {
                    echo "$data->stateNumber ";
                }
            }
        }

        public function diff($otherState){
            for ($i=0; $i < 9; $i++) { 
                if($this->Array[$i] != $otherState->Array[$i]){
                    return $i;
                }
            }
        }

        public function emptyNextState(){
            return empty($this->nextState);
        }

        public function checkLimit(){
            $flag = false;
            for ($i=0; $i < 9; $i++) { 
                if($this->box[$i] == 0){
                    $flag = true;
                    break;
                }
            }
            return $flag;;
        }

        public function setHeuristicValue(){
            $value = 0;
            //Dari segi AI (value bertambah kalau ada kemungkinan AI utk menang)
            //cek vertical AI
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($this->Array[$i+$j-1]==1) $cek++;
                    if($this->Array[$i+$j-1]==2) break;
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
                    if($this->Array[$i+$j-1]==1) $cek++;
                    if($this->Array[$i+$j-1]==2) break;
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
                if($this->Array[$i-1]==1) $cek++;
                if($this->Array[$i-1]==2) break;
                if($i==9){
                    if($cek==1) $value+=1;
                    else if($cek==2) $value+=10;
                    else if($cek==3) $value+=100;
                }
            }
            //cek diagonal2 AI
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($this->Array[$i-1]==1) $cek++;
                if($this->Array[$i-1]==2) break;
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
                    if($this->Array[$i+$j-1]==2) $cek++;
                    if($this->Array[$i+$j-1]==1) break;
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
                    if($this->Array[$i+$j-1]==2) $cek++;
                    if($this->Array[$i+$j-1]==1) break;
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
                if($this->Array[$i-1]==2) $cek++;
                if($this->Array[$i-1]==1) break;
                if($i==9){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                }
            }
            //cek diagonal2 PLAYER
            $cek=0;
            for($i = 3; $i<=7; $i+=2){
                if($this->Array[$i-1]==2) $cek++;
                if($this->Array[$i-1]==1) break;
                if($i==7){
                    if($cek==1) $value-=1;
                    else if($cek==2) $value-=10;
                    else if($cek==3) $value-=100;
                };
            }
            $this->heuristicValue = $value;
        }
    }
?>