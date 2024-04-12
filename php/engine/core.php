<?php
use RedBeanPHP\R;
R::setup('mysql:host=localhost;dbname=center', 'center', 'a9AqVy7f?TdL');
if(!isset($_SESSION)){
    session_start();
}
$test = 6;