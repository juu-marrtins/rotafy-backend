<?php

require __DIR__ . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance(env('CLOUDINARY_URL'));