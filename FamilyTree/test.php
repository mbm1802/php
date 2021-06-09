<?php
Class ClassA{

    public $Something = 'hello';
        private $a = "aaaa";
        public function get_a()
        {
                echo "classA_private a = ".$this->a;
				echo "<br/>";
        }

}

Class ClassB extends classA{

    function out(){

        echo "classB_out = ".$this->Something;
		echo "<br/>";

    }

}

$classB = new ClassB;

$classB->out();

$classB->get_a();
?>