<?php
// core/Helpers.php
function redirect($url) {
header('Location: ' . $url);
exit;
}


function auth_check() {
session_start();
return isset($_SESSION['user']);
}