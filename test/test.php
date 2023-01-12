<?php

include "../user.php";

session_start();

$rim = new User();
$rim->register("rim","rim@gmail.com","rim","rim","moghlali");
var_dump($rim);

?>