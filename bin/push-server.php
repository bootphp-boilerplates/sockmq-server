<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 02/08/17
 * Time: 4:29 PM
 */

use app\server\PushServer;

require dirname(__DIR__) . '/lib/autoload.php';

$loop = React\EventLoop\Factory::create();
$pusher = new PushServer();

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server($loop);
$webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        )
    ),
    $webSock
);

$loop->run();