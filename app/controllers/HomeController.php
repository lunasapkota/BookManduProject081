<?php

namespace App\Controllers;
use App\Core\Request;
use App\Core\Response;


class HomeController{
    public function getHome(Request $request,Response $response){
       

         $response->render("home/home");
    }//index

    public function getContact(Request $request,Response $response){
        return $response->render("home/contact");
    }

   


}