<?php
function getRequestDetails(): array
{
    $server = $_SERVER;
    $request = $server['REQUEST_URI'];
    $splitLink = explode("/", $request);
    array_shift($splitLink);
    $request_details = [
        'is_service' => $splitLink[0] === 'api',
    ];
    if ($request_details['is_service']) {
        $request_details['version'] = $splitLink[1];
        $request_details['method'] = $server['REQUEST_METHOD'];;
        array_shift($splitLink);
        if (isset($request_details['version'])) {
            array_shift($splitLink);
            $request_details['route'] = "/" . implode("/", $splitLink);
        }
        $request_details['payload'] = $_REQUEST;

        //$request_details['details'] = $server;
        return $request_details;
    }
    return [];
}

function setResponseStatus($code): void
{
    $status_codes = [
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        204 => "HTTP/1.1 204 No Content",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        // ... you can continue to add more as needed
    ];

    if (isset($status_codes[$code])) {
        header($status_codes[$code]);
    } else {
        // Default to 500 if the status code isn't recognized.
        header("HTTP/1.1 500 Internal Server Error");
    }
}

function setContentType($type): void
{
    $content_types = [
        'html' => "Content-Type: text/html; charset=UTF-8",
        'json' => "Content-Type: application/json; charset=UTF-8",
        'xml' => "Content-Type: text/xml; charset=UTF-8",
        'plain' => "Content-Type: text/plain; charset=UTF-8",
        'pdf' => "Content-Type: application/pdf",
        'csv' => "Content-Type: text/csv; charset=UTF-8",
        'javascript' => "Content-Type: application/javascript; charset=UTF-8",
        'css' => "Content-Type: text/css; charset=UTF-8",
        'octet' => "Content-Type: application/octet-stream",
        'png' => "Content-Type: image/png",
        'jpeg' => "Content-Type: image/jpeg",
        'gif' => "Content-Type: image/gif",
        'webp' => "Content-Type: image/webp",
        'mp3' => "Content-Type: audio/mpeg",
        'mp4' => "Content-Type: video/mp4",
        'zip' => "Content-Type: application/zip",
    ];
    if (isset($content_types[$type])) {
        header($content_types[$type]);
    } else {
        // Default to plain text if the content type isn't recognized.
        header("Content-Type: text/plain; charset=UTF-8");
    }
}

function setControllerPath($request): string
{
    $request['route'] = explode("?", $request['route'])[0];
    return $_SERVER['DOCUMENT_ROOT'] . '/api/' . $request['version'] . $request['route'] . '.php';
}

function redirectNotAllowedPage(): void
{
    setResponseStatus(502);
    setContentType('html');
    print_r(file_get_contents('./assets/not-allowed.php'));
}

function RouteController($path, $request): void
{
    require_once $path;
    $METHOD = $request['method'];
    unset($request['version']);
    unset($request['is_service']);
    unset($request['method']);
    $response = function ($response_body = [], $response_details = ['status' => null, 'content_type' => null]) {
        if (!isset($response_details['status'])) {
            $response_details['status'] = 200;
        }
        if (!isset($response_details['content_type'])) {
            $response_details['content_type'] = 'json';
        }
        setResponseStatus($response_details['status']);
        setContentType($response_details['content_type']);
        print_r(json_encode($response_body));
    };
    APP_ROUTER(
        function ($details) use ($METHOD, $response, $request) {
            switch ($METHOD) {
                case 'GET':
                    GET_METHOD($request, $response, $details);
                    break;
                case 'POST':
                    POST_METHOD($request, $response, $details);
                    break;
                case 'PUT':
                    PUT_METHOD($request, $response, $details);
                    break;
                case 'PATCH':
                    PATCH_METHOD($request, $response, $details);
                    break;
                case 'DELETE':
                    DELETE_METHOD($request, $response, $details);
                    break;
                case 'HEAD':
                    HEAD_METHOD($request, $response, $details);
                    break;
                case 'OPTIONS':
                    OPTIONS_METHOD($request, $response, $details);
                    break;
                default:
                    redirectNotAllowedPage();
            }
        },
        [
            "REQUEST" => $request,
            "RESPONSE" => $response,
        ],
    );
}