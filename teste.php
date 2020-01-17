

<?php

class Base {

    public function sayHello() {

        echo 'Geez ';

    }

}


trait SayWorld {

    public function sayHello() {

        parent::sayHello();

        echo 'Morty! ';

    }

}



class MyHelloWorld extends Base {

    use SayWorld;

}



$o = new MyHelloWorld();

$o->sayHello();

?>
