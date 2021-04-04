<?php

 namespace src\client\controllers\front;
use src\client\models\UserMode as UserModel;
use src\vendor\message\Message as Message;

//signin na potrebitel v system-ta
class SignInController{
    
    public  function index(){
        
         load_view('front', 'signin');
    }
    
    public function signin() {
            //if(User::isAuthenticated())        return redirect('index');

        //if(array_key_exists('tokken', $_POST)) return;
        //if(array_key_exists('tokken', $_POST) && $_POST['tokken'] != 1) return;

        //if(!isset($_POST['tokken']) && 
        //          $_POST['tokken'] != 1)   return;
        //$username = $_POST['username'];
        //$password = md5($_POST['password']); TODO UNCOMMENT!
        //$password = ($_POST['password']);    //md5($_POST['password']);
        
        
//        $userData = Database::fetchQuery("SELECT * FROM tb_users where username = '$username' AND password = '$password'");
        
        $userData = UserModel::getAllUsers(array(
            'username'  => $_POST['username'],
            'password'  => $_POST['password']
        ));
        //echo($userData);

        if(count($userData) == 1) {

            // QUERY builder for select statments
            $userId = $userData[0]['id'];
            $query = "  SELECT b.title 
                        FROM tm_users__user_role a, 
                                 tm_role b
                        WHERE a.user_id = $userId AND 
                                  a.role_id = b.id";

                $userRoleCollection = Database::fetchQuery($query);

             var_dump($userRoleCollection);


            User::auth($userData[0], $userRoleCollection);
            return redirect('index');
        }

        Message::set('sign_in_info_message', 'No user found');

    }
}
