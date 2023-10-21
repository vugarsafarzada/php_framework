<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/user/registerController.php';

function APP_ROUTER($Controller, $Action): void
{
    $Controller(null);
}
