<?php
require_once "./lib/helpers/requestHelpers.php";
require_once "./lib/content_types.php";
require_once "./api/router.php";
require_once __DIR__ . '/vendor/autoload.php';
require_once "./db/mysql.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header("X-Powered-By: ".$_ENV['X_POWERED_BY']);

// Set the appropriate headers for CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$request_details = getRequestDetails();

if(isset($request_details['is_service'])){
    setContentType('json');
    router($request_details);
} else {
    setResponseStatus(502);
    print_r(file_get_contents('./assets/not-allowed.php'));
}
