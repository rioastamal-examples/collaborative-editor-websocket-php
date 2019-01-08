<?php
/**
 * Script to start the WebSocket editor server.
 * The default port is 9191 and listen to all interfaces.
 */
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$port = isset($_SERVER['CHAT_SERVER_PORT']) ? $_SERVER['CHAT_SERVER_PORT'] : 9191;
$bindAddr = isset($_SERVER['CHAT_BIND_ADDR']) ? $_SERVER['CHAT_BIND_ADDR'] : '0.0.0.0';
// You can use __DIR__ . /some-file.tmp' for persistent storage instead of 'memory'
$file = 'memory';
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyApp\EditorServer($file)
        )
    ),
    $port, $bindAddr
);

printf("Websocket Editor server running on %s:%s.\n--\n", $bindAddr, $port);
$server->run();