<?php 
class App{
    private static $app = null;
    private function __construct()
    {
        
    }
    public static function getInstance(){
        if(is_null(self::$app)) {
            self::$app = new App();
        }
        return self::$app;
    }

 }
?>