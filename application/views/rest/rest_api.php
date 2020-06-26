<?php
$user = json_decode(file_get_contents('http://192.168.43.117/hrsale/api/test/user/'));
echo '<pre>'; print_r($user);
?>