<?php

//Подключение к БД

require 'config.php';


global $link;

if(empty($link)){
    $link=mysqli_connect('localhost','root','root','personalsite');
    mysqli_set_charset($link,'utf8');
    print_r(mysqli_query($link,'SELECT COUNT(*) FROM users'));
}