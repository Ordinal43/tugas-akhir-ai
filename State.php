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
        
        public function __construct($box, $stateParent = 0){
            $this->$box = $box;
            $this->stateNumber = ++self::$constantStateNumber;
            $this->stateParent = $stateParent;
            $this->limit = $this->checkLimit();
        }

        public function printState(){
            echo "Number State: " . $this->stateNumber;
            echo "<br>";
            echo "Parent State: " . $this->stateParent;
            echo "<br>";
            echo "Heuristic Value: " . $this->heuristicValue;
            echo "<br>";
            echo $this->Array[0] . $this->Array[1] . $this->Array[2];
            echo "<br>";
            echo $this->Array[3] . $this->Array[4] . $this->Array[5];
            echo "<br>";
            echo $this->Array[6] . $this->Array[7] . $this->Array[8];
            echo "<br>";echo "<br>";
        }

        public function hasNextState(){
            return !empty($this->nextState);
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
            //cek vertical
            for($i = 1; $i <=3; $i++){
                $cek=0;
                for($j = 0; $j <=6; $j+=3){
                    if($Array[$i+$j]==1) $cek=1;
                    if($Array[$i+$j]==2) break;
                    if($j==6 && $cek==1) $value++;
                }
            }
            //cek horizontal
            for($i = 1; $i<=7; $i+=3){
                $cek=0;
                for($j = 0; $j <=2; $j++){
                    if($Array[$i+$j]==1) $cek=1;
                    if($Array[$i+$j]==2) break;
                    if($j==2 && $cek==1) $value++;
                }
            }
            //cek diagonal1
            for($i = 1; $i<=9; $i+=4){
                if($Array[$i]==1) $cek=1;
                if($Array[$i]==2) break;
                if($i==9 && $cek==1) $value++;
            }
            //cek diagonal2
            for($i = 3; $i<=7; $i+=2){
                if($Array[$i]==1) $cek=1;
                if($Array[$i]==2) break;
                if($i==7 && $cek==1) $value++;
            }

            $this->heuristicValue = $value;
        }
    }
?>