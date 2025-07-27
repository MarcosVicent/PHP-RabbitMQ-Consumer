<?php

namespace App;

interface MessageProcessor
{
    /**
     * @param string
     * @return bool
     */
    public function process(string $messageBody): bool;
}

class DemoMessageProcessor implements MessageProcessor
{
    public function process(string $messageBody): bool
    {
        echo '[' . date('Y-m-d H:i:s') . '] Processing message: ' . $messageBody . PHP_EOL;

        if (str_contains($messageBody, 'fail')) {
            echo "  -> Failed to process message (simulated failure)." . PHP_EOL;
            return false;
        }

        sleep(2);

        echo "  -> Message processed successfully." . PHP_EOL;
        return true;
    }
}