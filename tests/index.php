<?php
setcookie("test_cookie", 1);

if (!empty($_GET['redirect'])) {
    header("Location:" . $_GET['redirect']);
}

$data = $_POST;
if ($data) {
    echo json_encode($data);
    exit;
}

if ($_GET) {
    echo json_encode($_GET);
}
