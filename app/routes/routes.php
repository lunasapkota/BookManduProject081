<?php

use App\Controllers\AuthController;
use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\TestController;
use App\Core\Router;


Router::get('/',[HomeController::class,'getHome']); //for home
Router::get('/home',[HomeController::class,'getHome']);
Router::get('/contact',[HomeController::class,'getContact']);

Router::get('/login',[AuthController::class,'getLogin']); 
Router::post('/login',[AuthController::class,'login']);
//for login routing

Router::get('/register',[AuthController::class,'getRegister']);
Router::post('/register',[AuthController::class,'register']);

Router::get('/logout',[AuthController::class,'logout']);


Router::get('/test',[TestController::class,'index']);

//for register routing


//for book routing

Router::get('/addbook',[BookController::class,'getAddBook']);
Router::get('/books',[BookController::class,'getBooks']);
Router::post('/addbook',[BookController::class,'addBook']);

// Router::get('/viewbook',[BookController::class,'getBooks']);
// Router::post('/viewbook',[BookController::class,'viewbook']);

Router::get('/editbook/{id}',[BookController::class,'getEditBook']);
Router::post('/editbook',[BookController::class,'updateBook']);


Router::get('/deletebook/{id}',[BookController::class,'deleteBook']);


