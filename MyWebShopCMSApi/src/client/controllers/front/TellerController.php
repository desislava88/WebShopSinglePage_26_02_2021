<?php

namespace src\client\controllers\front;

use src\client\models\ProductModel as ProductModel;   
use  src\client\models\UserModel          as User;  

class TellerController {
    
    private $action;
    private $productId;
    private $quantity;
    
    private  $modelDataCollection = array();

    public function __construct() {

        $this->modelDataCollection = array(
        ProductModel::PRODUCT_ID    => ((array_key_exists('id', $_GET))        ? $_GET['id'] : null),
        ProductModel::QUANTITY      => ((array_key_exists('quantity', $_GET))   ? $_GET['id'] : 1),
        ProductModel::USER_ID       => User::getId()
        );
    }

    public function index(){

        //var_dump (ProductModel::getAllProducts());    //return array
        //var_dump(ProductModel::getAllProducts());
        echo json_encode(ProductModel::getAllProducts());
        //echo (json_encode(ProductModel::getAllProducts()));        //return string ot json
        //TO DO transform into request - responce proces
//        load_view('front', 'teller', [
//            'productCollection' =>   ProductModel::getAllProducts()
//        ]);
    }

    public function  markProductForBuy() {
 
        $isProductAvailable =  ProductModel::isProductAvailable($this->modelDataCollection);
        
        if($isProductAvailable){

             ProductModel::markProductToCustomer($this->modelDataCollection);

             ProductModel::updateProduct($this->modelDataCollection);

             //TO DO  remove redirect
            redirect('teller');

        }
    }
}
