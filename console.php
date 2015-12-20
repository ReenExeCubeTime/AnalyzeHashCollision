<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use ReenExe\AnalyzeHashCollision\AnalyzeCommand;

$application = new Application();
$application->add(new AnalyzeCommand());
$application->run();