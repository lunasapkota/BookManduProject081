<?php


namespace App\Config;
class Config{
public $host = "localhost";
public $database = "bookmandu";
public $username = "root";
public $password = "";


//for response layouts
public $renderLayoutByDefaults = True;
public $headerLayoutPath = "layouts/header";
public $footerLayoutPath = "layouts/footer";
public $allowedImageExtensions = [ 'jpg','jpeg', 'png','webp'];
public $imageUplaodDirectory = "./public/uploads/";


}