<?php
include './src/vendor/util/utils.php';
include basecontext ('src/client/route/paths.php');
//include basecontext('src/vendor/database/Database.php'    );     
//include basecontext('src/vendor/validation/Validator.php' );  
//include basecontext('src/vendor/message/Message.php'      );       
//include basecontext('src/vendor/user/User.php'            );        

//include basecontext('src/client/components/dropdown.php');
include basecontext('src/client/route/guards.php');

include basecontext('src/vendor/loader/Loader.php'        ); 


spl_autoload_register(function ($class){
    //include file i pravim instanciq
    //var_dump(basecontext($class . '.php'));
    include basecontext($class . '.php');
   
});

//include na Loader i vikame f-q loadController
Loader::loadController();