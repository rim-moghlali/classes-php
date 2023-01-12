<?php

session_start();
include "user.php";

$rim = new User();
$rim->register("rim","rim@gmail.com","rim","rim","moghlali");
var_dump($rim);

?>