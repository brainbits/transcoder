<?php

error_reporting(-1);
date_default_timezone_set('Europe/Berlin');

if (file_exists(__DIR__ . '/../vendor/autoload.php'))
{
    require_once __DIR__ . '/../vendor/autoload.php';
}
else
{
    require_once __DIR__ . '/../../../autoload.php';
}