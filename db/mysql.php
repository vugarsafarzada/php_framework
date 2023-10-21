<?php
require_once $_SERVER['DOCUMENT_ROOT']."/db/Database.php";

function DataBase(): ?Database
{
    try {
        return new Database();
    } catch (Exception $e) {
        return null;
    }
}
