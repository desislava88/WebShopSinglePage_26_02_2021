<?php
//model kojto se griji za logikata za rabota s producti.
//kontrolera samo vika danni i vrushta dannite na view, a MODEL izpylnqva cqlata LOGIC i rabota

namespace src\client\models;        //okazvame putq do class-a
use \src\vendor\database\Database as Database;
use src\client\models\UserModel as UserModel;

class ProductModel {
    
     const PRODUCT_ID = "productId";
     const QUANTITY = "quantity";
     const USER_ID = "user_id";


    //vzemame vsichki danni ot DB table products
    public static function getAllProducts(){
        
        return Database::select('tb_products')::fetch();
    }
    
    public static function isProductAvailable($dataCollection){
        //echo 'Check product availability';
        
        //check if product quantity exist
        $fetchQuery =  Database::select('tb_products')::where (array(
            //'id'    => $this->productId
            'id'    => $dataCollection[self::PRODUCT_ID]
        )):: fetchSingle();
        
        //$fetchQuery = Database::fetch('tb_products');
        
        return $fetchQuery['quantity'] >= $dataCollection[self::QUANTITY];
    }
    
    // Insert data v tb user_product
    public static function  markProductToCustomer($dataCollection) {
        //promenliva, koqto sledi ima ili nqma zapis
        $productUserCollection = Database::select('tb_user_product')::where(array(
            'user_id'      => $dataCollection[self::USER_ID],       //User::getId(),
            'product_id'   => $dataCollection[self::PRODUCT_ID]      //$this->productId
            )):: fetch();
        
        //ako ima zapis update call function updateUserProduct()
          if(count($productUserCollection) > 0){
              
              //return $this->updateUserProduct();
              return self::updateUserProduct(array(
                  self::USER_ID      => $dataCollection[self::USER_ID],
                  self::PRODUCT_ID   =>  $dataCollection[self::PRODUCT_ID],
                  self::QUANTITY     =>  $dataCollection[self::QUANTITY]
              ));
          }  
           //ako nqma zapis insert - call function insertUserProduct() 
          //$this -> insertUserProduct();
          
          self::insertUserProduct(array(
              self::USER_ID      =>  $dataCollection[self::USER_ID],
              self::PRODUCT_ID   =>  $dataCollection[self::PRODUCT_ID],
              self::QUANTITY    =>  $dataCollection[self::QUANTITY]
          ));
    }
     
    //update user product
    
    //insert user product

    public static function insertUserProduct($dataCollection){
        
               //Insert new relation between user and product
         Database::insert('tb_user_product', array(
        'user_id'      =>  $dataCollection[self::USER_ID],
        'product_id'   =>  $dataCollection[self::PRODUCT_ID],        //$this-> productId,
        'quantity'     =>  $dataCollection[self::QUANTITY]         //$this->quantity
    ));
    }

    public static function updateUserProduct($dataCollection){
        
        $userProductEntity =  Database::select('tb_user_product')::where(array(
            'user_id'      => $dataCollection[self::USER_ID],
            'product_id'  => $dataCollection[self::PRODUCT_ID]          //$this-> productId
        ))::fetchSingle();

        //starata st-st koqto imame
        $userProductQuantity = $userProductEntity[self::QUANTITY];
        //starata st-st sybrana s novaat st-st
        $newUserProductQuantity = ($userProductQuantity + $dataCollection[self::QUANTITY]);   //$this->quantity);
        
         Database::update('tb_user_product', array (
            'quantity'  => $newUserProductQuantity
        ))::where(array(
            'user_id'      => User::getId(),
            'product_id'   => $dataCollection[self::PRODUCT_ID]  //$this-> productId
        ))::execute();
    }

    public static function updateProduct($dataCollection){
        //vzemamte za tekushtiq produkt quantity 
        $productEntity = Database::select('tb_products')::where(array(
            'id'        => $dataCollection[self::PRODUCT_ID]               //$this->productId
        ))::fetchSingle();
        
        //ot tekushtiq product  vadim quantity na zaqvkata koqto sme napravili
        $productQuantity = $productEntity[self::QUANTITY];
        $newProductQuantity = $productQuantity - $dataCollection[self::QUANTITY];  //$this->quantity;
        
         Database::update('tb_products', array(
            'quantity'  => $newProductQuantity   
        ))::where(array(
             'id'   => $dataCollection[self::PRODUCT_ID]     // $this->productId
        ))::execute();
    }
}


