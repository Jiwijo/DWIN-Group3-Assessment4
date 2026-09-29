<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !cookbook_csrf_is_valid()) {
    http_response_code(400);
    exit('Invalid logout request.');
}

$_SESSION = [];
session_destroy();
header('Location: index.php');
exit;