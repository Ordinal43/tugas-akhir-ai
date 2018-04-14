<?php

class Node
{
    public $name;
    public $stack;

    public function __construct($name)
    {
        $this->name = $name;
        $this->stack = array();
    }

    public function connectTo(Node $node, $flag = true)
    {
        if ( !$this->stack($node) ) 
            $this->stack[] = $node;
        
        if ( $flag ) 
            $node->connectTo($this, false);
    }

    private function stack(Node $node)
    {
        foreach ( $this->stack as $i ) {
            if ( $i->name == $node->name ) 
                return true; 
        }
        
        return false;
    }

    public function getVisitedNode($node)
    {
        $output = array();
        foreach ( $this->stack as $i ) {
            if ( !in_array($i->name, $node) ) 
                $output[] = $i;
        }
        return $output;
    }
}

function dfs (Node $node, Node $goal, $output = array(), $visited = array()){
    $visited[] = $node->name;
    $notVisited = $node->getVisitedNode($visited);

    if ( $node == $goal ){
        return $output;
    }
    else if ( empty($notVisited) ){
        return;
    }
    
    array_push( $output, $node );
    foreach ( $notVisited as $i ){
        dfs( $i, $goal, $output, $visited);
    }
}

$JSON = json_encode(dfs($root));

echo $JSON;

?>