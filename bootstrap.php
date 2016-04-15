<?php

const BASE_PATH = __DIR__;

$loader = require_once __DIR__."/vendor/autoload.php";

return new \JournalMedia\Pharbiter\Application($loader);
