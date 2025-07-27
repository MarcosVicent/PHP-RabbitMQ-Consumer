<?php

namespace App;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    private ?AMQPStreamConnection $connection = null;
    private ?AMQPChannel $channel = null;
    private string $queueName;
    private MessageProcessor $messageProcessor;

    public function __construct(MessageProcessor $processor)
    {
        $this->messageProcessor = $processor;
        $this->queueName = Config::get('RABBITMQ_QUEUE_NAME', 'my_queue');
    }

    private function connect(): void
    {
        try {
            $this->connection = new AMQPStreamConnection(
                Config::get('RABBITMQ_HOST', 'localhost'),
                Config::get('RABBITMQ_PORT', 5672),
                Config::get('RABBITMQ_USER', 'guest'),
                Config::get('RABBITMQ_PASS', 'guest'),
                Config::get('RABBITMQ_VHOST', '/')
            );
            $this->channel = $this->connection->channel();
            $this->channel->queue_declare(
                $this->queueName,
                false,
                true,
                false,
                false 
            );
            echo " [*] Connected to RabbitMQ and declared queue '{$this->queueName}'." . PHP_EOL;
        } catch (\Exception $e) {
            die(" [x] Error connecting to RabbitMQ: " . $e->getMessage() . PHP_EOL);
        }
    }

    public function processMessage(AMQPMessage $msg): void
    {
        $messageBody = $msg->getBody();
        echo " [x] Received '" . $messageBody . "'" . PHP_EOL;

        try {
            if ($this->messageProcessor->process($messageBody)) {
                $msg->ack();
                echo " [x] Message ACKed." . PHP_EOL;
            } else {
                $msg->nack(false, true);
                echo " [x] Message NACKed and re-queued." . PHP_EOL;
            }
        } catch (\Exception $e) {
            echo " [!] Error during message processing: " . $e->getMessage() . PHP_EOL;
            $msg->nack(false, true);
        }
    }

    public function startConsuming(): void
    {
        $this->connect();

        echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;

        $this->channel->basic_consume(
            $this->queueName,
            '',
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        try {
            while ($this->channel->is_consuming()) {
                $this->channel->wait();
            }
        } catch (\Exception $e) {
            echo " [!] Consumer stopped due to error: " . $e->getMessage() . PHP_EOL;
        } finally {
            $this->close();
        }
    }

    public function close(): void
    {
        if ($this->channel) {
            $this->channel->close();
        }
        if ($this->connection) {
            $this->connection->close();
        }
        echo " [.] Connection closed." . PHP_EOL;
    }
}