<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class AuthController{

    public function getLogin($req,Response $res){
        if($req->isLogin()){
            return $res->redirect('/');
        }
         return  $res->disableLayouts(true)->render("auth/login");
    }//

    public function login(Request $request,Response $response){
        $email = $request->email;
        $password = $request->password;
        
        if( !$email || !$password  || strlen($email)<6 || strlen($password)<6){
            return $response->disableLayouts(true)->render('auth/login',['error'=>'Please provide proper details']);
        }
        

        $db = $request->getDatabase();
        $hashedPassword = hash('sha256',$password);
        // echo $email.$password;
        $user = $db->fetchOne('users',['email'=>$email,'password'=>$hashedPassword]);
        // print_r($user);
        if($user){
            $request->setUser($user);
            return $response->redirect('/');
        }
        //if not found this show this error below

        return $response->disableLayouts(true)->render('auth/login',['error'=>'Invalid Credentials']);


    }//login

    public function getRegister(Request $req,Response $res){
        if($req->isLogin()){
            return $res->redirect('/');
        }
        return $res->disableLayouts(true)->render('auth/register');
    }

    public function register(Request $req,Response $res){
        $email = $req->email;
        $password = $req->password;
        $confirm_password = $req->confirm_password;
        $name = $req->name;
        $phone = $req->phone;

        $errors = [];

        if(!$email || strlen($email)<6 ){
            $errors['email'] = 'Email must be greater than 6 chars';
        }//email
        if(!$password || strlen($password)<8 ){
            $errors['password'] = 'Password must be greater than 8 chars';
        }//password
        if(!$confirm_password==$password ){
            $errors['confirm_password'] = 'Confirm Password not matched';
        }//confirm_password
        if(!$name || strlen($name)<3 ){
            $errors['name'] = 'Name must be greater than 6 chars';
        }//name
        if(!$phone || strlen($phone)<10 ){
            $errors['phone'] = 'Phone must be greater than or equal to  10 chars';
        }//phone

        if( count($errors) > 0){
            return $res->disableLayouts(true)->render('auth/register',$errors);
        }

        $db = $req->getDatabase();
        $user = $db->fetchOne('users',['email'=>$email]);
        if($user){
            return $res->disableLayouts(true)->render("auth/register",['error'=>'This email is already exists']);
        }
        $hashedPassword = hash('sha256', $password);
        $id = $db->insert('users',['email'=>$email,'password'=>$hashedPassword,'name'=>$name,'phone'=>$phone]);
        if(!$id){
            return $res->disableLayouts(true)->render("auth/register",['error'=>'Something went wrong']);
        }
        return $res->redirect('/login');

    }//regisetr

    public function logout(Request $req){
        $req->logout();
    }


}