<?php

class NewClass{

    public $info = "This is public info<br>";
    protected $info1 = "protected info<br>";
    private $info2 = "private info<br>";
}

class NewClass2 extends NewClass{

    public function displayName()
    {
        echo $this->info.$this->info1;
    
    }

}

$object = new NewClass2;

$object->displayName();

?>

