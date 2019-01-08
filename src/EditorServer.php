<?php
/**
 * Simple WebSocket server to handle code collaboration.
 *
 * @author Rio Astamal <rio@rioastamal.net>
 * @link https://github.com/rioastamal-examples/collaborative-editor-websocket-php
 * @license MIT
 */
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class EditorServer implements MessageComponentInterface
{
    protected $tmpFile;
    protected $memoryContent = '';
    protected $prefix = 'SERVER: ';
    protected $clients = [];

    public function __construct($tmpFile)
    {
        $this->tmpFile = $tmpFile;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $data = [
            'id' => $conn->resourceId,
            'conn' => $conn
        ];
        $this->addClient($data);
        $this->debug('New connection -> ' . $conn->resourceId);

        $content = $this->readEditorContent();
        $conn->send($content);
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $this->writeEditorContent($from, $message);
        $this->broadcastContent();
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    protected function debug($message, $newline = "\n")
    {
        printf("%s %s%s", $this->prefix, $message, $newline);
    }

    protected function addClient($clientData)
    {
        if (array_key_exists($clientData['id'], $this->clients)) {
            return;
        }

        $this->clients[$clientData['id']] = $clientData;
    }

    protected function writeEditorContent($conn, $content)
    {
        $this->debug('Got message from ' . $conn->resourceId . ' | Message: ' . $content);
        if ($this->tmpFile === 'memory') {
            $this->memoryContent = $content;
            return;
        }

        file_put_contents($this->tmpFile, $content);
    }

    protected function readEditorContent()
    {
        if ($this->tmpFile === 'memory') {
            return $this->memoryContent;
        }

        if (! file_exists($this->tmpFile)) {
            return '';
        }

        return file_get_contents($this->tmpFile);
    }

    protected function broadcastContent()
    {
        $content = $this->readEditorContent();

        foreach ($this->clients as $client) {
            $client['conn']->send($content);
        }
    }
}