<?php
require_once 'Test.php';
class Child extends Test{
    public $interest;

    public function __construct($accName, $balance, $type, $interest){
        parent::__construct($accName, $balance, $type);  //calling parent constructor like super()
        $this->interest= $interest;
    }

    public function setInterest($interest){
        $this->interest = $interest;
    }
    public function addInterest($interest){
        $total = $interest * $this->getBalance();
		echo $total." ";
        $this->deposit("vjon",$total);
    }
    public function withdraw($accName, $amount){
        $canWidraw = $this->getBalance() >= $amount && $amount>=0; 

        if($canWidraw) {
            parent:: withdraw($accName, $amount); // pre checking if amount can be withdrawn
            return true;                                           // if true then parent class's widraw method called
        }
        else {
            return false;
        }
    }
}

$cobj = new Child("dddd", 300, 2, 0.07); // derived class always
$cobj->deposit("vjon", 9999);
$cobj->addInterest(0.07);

echo $cobj->getBalance()." ".$cobj->accName;
?>