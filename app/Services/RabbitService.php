<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitService
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $host = env('RABBITMQ_HOST');
        $port = env('RABBITMQ_PORT');
        $user = env('RABBITMQ_USER');
        $password = env('RABBITMQ_PASSWORD');

        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, '/');
        $this->channel = $this->connection->channel();
    }

    public function publishMessage($message, $queue = 'user_events'): void
    {
        $this->channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

        $this->channel->basic_publish($msg, '', $queue);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
