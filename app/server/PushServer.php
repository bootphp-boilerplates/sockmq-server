<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 02/08/17
 * Time: 5:20 PM
 */

namespace app\server;


use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;

class PushServer implements WampServerInterface
{
    /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();

    public function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->log("Pusher : onSubscribe " . $topic->getId() . "  " . $topic);
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function publishTopicToAllUser($topic, $payload)
    {
        $this->log("Pusher : publishTopicToAllUser:".$topic);

        // If the lookup topic object isn't set there is no one to publish to
        if (!array_key_exists($topic, $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics[$topic];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($payload);
    }

    /* The rest of our methods were as they were, omitted from docs to save space */

    public function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->log("Pusher : onUnSubscribe");
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->log("Pusher : onOpen");
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->log("Pusher : onClose");
    }

    public function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $this->log("Pusher : onCall :  let me sleeeeppp");

        $this->publishTopicToAllUser($topic->getId(),$params);

        // In this application if clients send data it's because the user hacked around in console
        //$conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $this->log("Pusher : onPublish :  let me sleeeeppp");
        print_r(array($topic, $event, $exclude, $eligible));
        sleep(5);
        $this->log("Pusher : onPublish : gud mornign");
        // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {

        $this->log("Pusher : onError");
    }

    public function log($msg)
    {
        echo "\n" . $msg;
    }
}