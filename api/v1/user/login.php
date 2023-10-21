<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/user/loginController.php';

function APP_ROUTER($Controller, $Actions): void
{
    $response = $Actions['RESPONSE'];
    $request = $Actions['REQUEST'];
    $Controller([]);
}