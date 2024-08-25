<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;



class BookController{
    public function getAddBook(Request $request,Response $response){
        if(!$request->isLogin()) return $response->redirect('/login');
        $categories = $request->getDatabase()->fetchAll('categories',[]);
        $data = [
            'categories'=>$categories
        ];
        return $response->disableLayouts(true)->render('book/addbook',$data);
    } //addbook

    public function getEditBook(Request $request,Response $response,$params){
        if(!$request->isLogin()) return $response->redirect('/login');
        $book_id = $params->id;
        $user_id = $request->getUser()->id;

        $db = $request->getDatabase();
        // $books = $db->fetchAllSql('select books.*, categories.name as category_name from books join categories on books.category_id = categories.id where user_id = ?',[$request->getUser()->id]);

        $book = $db->fetchOne('books',['id'=>$book_id,'user_id'=>$user_id]);
        $categories = $db->fetchAll('categories',[]);

        $data = [
            'book'=>$book,
            'categories'=>$categories
        ];
        // print_r($data);
        
        // category_id = 2
        //fetch all categories 

        // $book = $db->fetch('select * from books where id = ? and user_id = ?',[$book_id,$user_id]);
        if(!$book){
            echo "This book is not found";
            return;
        }//

        $response->disableLayouts(true)->render('book/editBook',$data);

    } //editbook

    public function deleteBook(Request $request,Response $response,$params){
        if(!$request->isLogin()) return $response->redirect('/login');
        $user_id = $request->getUser()->id;
        $book_id = $params->id;
        
        $db = $request->getDatabase();
        $id = $db->delete('books',['user_id'=>$user_id,'id'=>$book_id]);

        if(!$id){
            echo "Something went wrong deleting the book";
            return;
        }
        $response->redirect("/books");

        // return $response->disableLayouts(false)->render('book/addbook');
    }//deletebook


    public function getBooks(Request $request,Response $response){
        if(!$request->isLogin()) return $response->redirect('/login');

        $db = $request->getDatabase();
        // $books = $db->fetchAll('books',['user_id'=>$request->getUser()->id]);
        
        $books = $db->fetchAllSql('select books.*, categories.name as category_name from books join categories on books.category_id = categories.id where user_id = ?',[$request->getUser()->id]);
        // print_r($books);
        $data = [ 'books'=>$books ];
        return $response->withHeader('layouts/book_header')->disableLayouts(true)->render('book/viewbook', $data);
    }//


    public function addBook(Request $request,Response $response){
        if(!$request->isLogin()) return $response->redirect('/login');

        $name = $request->name;
        $author = $request->author;
        $publication_year = $request->publication_year;
        $description = $request->description;
        $user_id = $request->getUser()->id;
        $category_id = $request->category;
        $quality = $request->quality;
        $city = $request->city;
        $price = $request->price;

        // print_r($image);



        // echo $hashedName;
        print_r($_POST);

        // print_r(count($image));

        $errors =[];

        $db = $request->getDatabase();
        $category = $db->fetchOne('categories',['id'=>$category_id]);

        if(!$category) $errors['category'] = "Category is invalid";

        // $category_id = $category["id"];

        if(!$name || !$author || !$publication_year || !$description || !$quality || !$city || !$price ){
            $errors["error"] = "Error occured in the data";
        }

        // if(!$name || strlen($name)<3){
        //     $errors["error"] = "Error occured in the name data";
        // }//name
        // if(!$author || strlen($author)<3){
        //     $errors["error"] = "Error occured in the author data";
        // }//author
        // if(!$publication_year){
        //     $errors["error"] = "Error occured in publication year";
        // }//publication year
        // if(!$description || strlen($description)<500){
        //     $errors["error"] = "Error occured in description";
        // }//description
        // if(!$quality){
        //     $errors["error"] = "Error occured in quality";
        // }//quality
        // if(!$city){
        //     $errors["error"] = "Error occured in city";
        // }//city
        // if(!$price ){
        //     $errors["error"] = "Error occured in price";

        // }//price


        if(count($errors)>0  ){
            echo "Something went wrong"; //render the same page and pass the errors
            return;
        }

        
        if(!$request->hasFile('image')){
            echo "Please upload Image";
            return;
        }

        $isImage = $request->isImageSupported('image');
        if(!$isImage){
            echo "Image is not supported or corrupted";
            return;
        }

       $imgPath =  $request->uploadImage('image'); //image is uploading
       if(!$imgPath){
        echo "Something went wrong uploading image";
        return;
       }


        $id = $db->insert('books',['name'=>$name,'author'=>$author,'publication_year'=>$publication_year,'description'=>$description,'user_id'=>$user_id,'category_id'=>$category_id,'quality'=>$quality,'city'=>$city,'price'=>$price,'image_url'=>$imgPath]);
        if(!$id){
            echo "Something went wrong";
            return;
        }

        $response->redirect('/books');


        
    }//


    public function updateBook(Request $request,Response $response){
        if(!$request->isLogin()) return $response->redirect('/login');
        $id = $request->id;
        $name = $request->name;
        $author = $request->author;
        $publication_year = $request->publication_year;
        $description = $request->description;
        $user_id = $request->getUser()->id;
        $category_id = $request->category;
        $quality = $request->quality;
        $city = $request->city;
        $price = $request->price;
        $image = $request->image;

        $errors =[];

        $db = $request->getDatabase();
        $category = $db->fetchOne('categories',['id'=>$category_id]);

        if(!$category) $errors['category'] = "Category is invalid";

        // $category_id = $category["id"];
        // print_r($request);
        if( !$id || !$name || !$author || !$publication_year || !$description || !$quality  || !$city || ((int)$price)<10 ){
            $errors["error"] = "Error occured in the data";
        }

        // if(count($errors)>0  ){
        //     echo "Something went wrong"; //render the same page and pass the errors
        //     print_r($errors);
        //     return;
        // }
        $imgPath =  $request->uploadImage('image'); //image is uploading
       if(!$imgPath){
        echo "Something went wrong uploading image";
        return;
       }

        $id = $db->update('books',['name'=>$name,'author'=>$author,'publication_year'=>$publication_year,'description'=>$description,'category_id'=>$category_id,'quality'=>$quality,'city'=>$city,'price'=>$price,'image_url'=>$imgPath],['id'=>$id,'user_id'=>$user_id]);
        
        // print_r($id);
        if(!$id){
            echo "Something went wrong";
            return;
        }

        $response->redirect('/books');


        
    }//
}