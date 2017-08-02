<?php

/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 02/08/17
 * Time: 8:36 PM
 */
namespace app {

    use app\service\Socket;
    use \bootphp\loader\Loader;

    include_once "lib/autoload.php";
    include_once 'config/config.php';

    class TestSocket extends Loader
    {

        public function invoke($options)
        {
            $client = new \WAMP\WAMPClient('http://localhost:8080');
            $sessionId = $client->connect();

            //publish an event
            $payload = array(
                "me" => "lalit"
            );

            //$payload can be scalar or array
            $exclude = [$sessionId]; //no sense in sending the payload to ourselves
            $eligible = []; //list of other clients ids that are eligible to receive this payload
            $client->publish('topic', $payload, $exclude, $eligible);

            $client->disconnect();
        }

    }

    (new TestSocket())->execute();
}