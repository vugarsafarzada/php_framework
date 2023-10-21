<?php
function POST_METHOD($req, $res): void
{
    $database = new Database();
    $body = $req['payload'];
    $result = $database->insert('users',[
        "firstname" => $body['firstname'],
        "lastname"  => $body['lastname'],
        "email"     => $body['email'],
        "reg_date"  => date("Y-m-d H:i:s")
    ]);
    $res($result);
}