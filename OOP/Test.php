<?php

class Test
{
    public readonly int $id;  //can initialized only once within class or function. reaonly must use with typed variable. 
    public string $comment;  // typed variable is uninitialized while by default php variable is null
    public function __construct(public $accName, public $balance, $type) // accName & balance also defined as class
    {                                                                    // properties but type is not.
    }                                                                  
    public function deposit($accName, $amount)
    {
        $this->balance += $amount;
        $this->accName = $accName;  //this refer local variable in class

        return $this; // return the current object
    }
    public function withdraw($accName, $amount)
    {
        if($this->balance >= $amount && $amount>=0){
        $this->balance -= $amount;
        $this->accName = $accName;
         return true;
        }
        return false;
    }
    public function getBalance()
    {
        return $this->balance;
    }

}


$obj = new Test("jhon", 1000, 1);


$obj->deposit("jhon", 200)     //we can use here 'Method Chaining' because here 
    ->withdraw("jhon", 300)    // method return current object($this)/
    ->withdraw("rhon", 150);

echo "Acc holder $obj->accName have $obj->balance Taka";
var_dump(($obj)); // return defination of $obj

?>