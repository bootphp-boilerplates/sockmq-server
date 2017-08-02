<?php

/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 02/08/17
 * Time: 8:36 PM
 */
namespace app {

    use app\service\Socker;
    use \bootphp\loader\Loader;

    include_once "lib/autoload.php";
    include_once 'config/config.php';

    class TestSocket extends Loader
    {
        public function invoke($options)
        {
            Socker::wamp_send("myuniquetopic", array(
                "name" => "Lalit",
                "purpose" => "Testing"
            ));
        }

    }

    (new TestSocket())->execute();
}