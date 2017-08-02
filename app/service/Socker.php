<?php

namespace app\service;

/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 02/08/17
 * Time: 8:24 PM
 */

class Socker
{

    public static function wamp_send($topic, $payload)
    {
        $client = new \WAMP\WAMPClient('http://localhost:8080');
        $sessionId = $client->connect();

        //$payload can be scalar or array
        $exclude = [$sessionId]; //no sense in sending the payload to ourselves
        $eligible = []; //list of other clients ids that are eligible to receive this payload
        $client->publish($topic, $payload, $exclude, $eligible);

        $client->disconnect();
    }

    public static function mq_send($topic, $payload)
    {

    }

}