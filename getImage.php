<?php
header("Access-Control-Allow-Origin: *");

if (isset($_GET['image'])) {
    $img = $_GET['image'];
    //$fp = fopen("images/$img", 'rb');
    $str = file_get_contents("images/$img", FILE_USE_INCLUDE_PATH);
    echo base64_encode($str);
    exit;
}else {
    die();
}

?>