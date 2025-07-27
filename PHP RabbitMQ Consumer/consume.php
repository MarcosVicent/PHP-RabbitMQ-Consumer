<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Config;
use App\Consumer;
use App\DemoMessageProcessor;

Config::load();

$processor = new DemoMessageProcessor();

$consumer = new Consumer($processor);

$consumer->startConsuming();