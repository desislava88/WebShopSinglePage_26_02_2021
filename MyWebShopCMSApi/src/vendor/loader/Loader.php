<?php

class Loader {
    
    //define na pravila 
    private static $viewMapping = array(
        'home'      => array(
            //'view'          => 'view/front/home.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'HomeController'),
                                //'src/client/controllers/front/HomeController.php'
            'method'        => 'index'
        ),
        //TO DO TO HTTP POST / GET methods
        'signin'            => array(
            //'view'          => 'view/front/signin.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'SignInController'),
                                    //'src/client/controllers/front/SignInController.php',
            'guard_rules'   => ['redirectIfAuthenticated'],
            'method'        => 'index'
        ),
        'signup'            => array(
            //'view'          => 'view/front/signup.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'SignUpController')
                                //'src/client/controllers/front/SignUpController.php'
         ),
        'logout'            => array(
            //'view'          => NULL,
            'controller'    => (FRONT_CONTROLLER_LOCATION .'LogoutController'),
                                //'src/client/controllers/front/LogoutController.php'
            'method'        => 'logout'
        ),
        
//        'teller'            => array(
//            'view'          => 'view/front/teller.php',
//            'controller'    => FRONT_CONTROLLER_LOCATION . 'TellerController.php'
//        ),

        'teller'            => array(
             //'view'          => 'view/front/teller.php',
            //'controller'    => (FRONT_CONTROLLER_LOCATION . 'TellerController.php' ),
            //'models'        => [(MODEL_LOCATION . 'ProductModel.php' )],
            'controller' => (FRONT_CONTROLLER_LOCATION . 'TellerController'),
            'method'        => 'index'
        ),
  
        'teller/mark'      => array(
            //'view'          => 'view/front/teller.php',
            //'controller'        => (FRONT_CONTROLLER_LOCATION . 'TellerController.php' ),
            'controller'   => (FRONT_CONTROLLER_LOCATION . 'TellerController'),
            //'models'        => [(MODEL_LOCATION . 'ProductModel.php' )],
            'method'        => 'markProductForBuy'
        ),        
        
//        'teller/mark/{id}'       => array(
//            //'view'          => 'view/front/teller.php',
//            'controller'    => (FRONT_CONTROLLER_LOCATION . 'TellerController.php'),
//            'models'        => [(MODEL_LOCATION .'ProductModel.php')],
//            'method'        => 'markProductForBuy'
//        ),
  
        'product'                   => array(
            'controller'            => (ADMIN_CONTROLLER_LOCATION .'ProductController'),
            //predvaritelno difinrani methods
            'methodRequestMapping'  =>[
                'GET'               => 'index',
                'POST'              => 'createProduct',
                'PUT'               => 'updateProduct',
                'DELETE'            => 'deleteProduct'
            ]       
        ),
        /*
        'product/create'    => array(
            //'view'          => 'view/admin/product.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'ProductController'),
                                //'src/client/controllers/admin/ProductController.php',
            //'guard_rules'  => ['adminOnly'],
            //admin only
            'method'        => 'createProduct'
        ),
        'product/update'    => array(
            //'view'          => 'view/admin/product.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'ProductController'),
                                //'src/client/controllers/admin/ProductController.php',
            //'guard_rules'  => ['adminOnly'],
            //admin only
            'method'        => 'updateProduct'
        ),
        
        'product/delete'    => array(
            //'view'          => 'view/admin/product.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'ProductController'),
                                //'src/client/controllers/admin/ProductController.php',
            //'guard_rules'  => ['adminOnly'],
            //admin only
            'method'        => 'deleteProduct'
        ),
        
        'create_category'   => array (
            //'view'          => 'view/admin/category.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'CategoryController'),
                                //'src/client/controllers/admin/CategoryController.php',
            //'guard_rules'  => ['adminOnly'],
             //admin only
              'method'        => 'index'
        )
         */
    );

    private static $viewMapping404 = array(
        'page_not_found'    => array(
            //'view'  => 'view/layout/page_404.php',
            'controller' => (SYSTEM_CONTROLLER_LOCATION. 'Page404Controller.php')
                                //'src/client/controllers/system/Page404Controller.php'
        )
    );
    
    private static $DEFAULT_CONTROLLER = 'home';
    
    private static function isGuarded($controller) {
        
        if(!array_key_exists('guard_rules', self::getControllerConfig($controller))){
            return false;
        }
        $guardCollection = self::getControllerConfig($controller)['guard_rules'];
        
        foreach ($guardCollection as $guardRule) {
            if($guardRule()) return true;
        }
        return false;
    }


//    public static function getView($controller) {
//        return self::getControllerConfig($controller)['view'];
//    }
    
//    public static function getController($controller) {
//        return self::getControllerConfig($controller)['controller'];     
//    }  
    
//    private static function getControllerClass($controller) {
//        return self::getControllerConfig($controller)['controller'];
//    } 
//    
//    private static function getControllerMethod($controller) {
//        return self::getControllerConfig($controller)['method'];     
//    }

//  public static function getModelCollection($controller) {
//        return self::getControllerConfig($controller)['models'];
//    }
//    
    private static function getControllerIndex() {

        if(!array_key_exists('PATH_INFO', $_SERVER)) {
            return self::$DEFAULT_CONTROLLER;
        }

        $pageIndexCollection = explode('/', $_SERVER['PATH_INFO']);
        
        array_shift($pageIndexCollection);
        
//        echo'<pre>';
//        var_dump(implode('/', $pageIndexCollection));
//        echo'</pre>';

        //return $pageIndexCollection[0];
        
        return implode('/', $pageIndexCollection);
    }
    
    private static function getControllerConfig($controller) {

        if(array_key_exists($controller, self::$viewMapping)) {
            return self::$viewMapping[$controller];
        }

        return self::$viewMapping404['page_not_found'];
    }        
    
    public static function loadController(){
        $controller         = Loader::getControllerIndex();    ///za vzemane na controller classa
        //$viewPath        = Loader::getView($controllerIndex);
        //$controllerPath  = Loader::getController($controllerIndex);
        $controllerClass        = self::getControllerConfig($controller)['controller'];  //TellerController
        $controllerMethod       = null;
        
        if(array_key_exists('method', self::getControllerConfig($controller))){
             $controllerMethod       = self::getControllerConfig($controller)['method'];
        }
        //$modelCollection = Loader::getModelCollection($controllerIndex);
        
        if(array_key_exists('methodRequestMapping', self::getControllerConfig($controller))){
            
            $methodRequestMapping   = self::getControllerConfig($controller)['methodRequestMapping'];
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $controllerMethod       = $methodRequestMapping[$requestMethod];
        }
       
        
        //durji info za zaqvkata
        //var_dump[$_SERVER]['REQUEST_METHOD'];


//dynamic release  Function - izpylnenie na dinamichna function, podavajki imeto i samo kato text, ako tq sushtestvuva nqkyde v sistemata!
//function dynamicExecute   
//    echo "Hello world from dynamic function";
//}
//'dynamicExecute'();

    if(Loader::isGuarded($controller)) {
    redirect('home');
}

//*load baseview
//include basecontext('view/layout/header.php');

//*load model
//foreach ($modelCollection as $modelClass) {
//    include basecontext($modelClass);
//}

//*load controller
//include basecontext($controllerPath);

//$instance = new $controllerClass();
////vikame method, kojto e definiran kato promenliva
//$instance->{$controllerMethod}();


(new $controllerClass())->{$controllerMethod}();


//*load VIEW
//if(!is_null($viewPath)){
//    include basecontext($viewPath);
//}

//*load base view
//include basecontext('view/layout/footer.php');
    }
} 

