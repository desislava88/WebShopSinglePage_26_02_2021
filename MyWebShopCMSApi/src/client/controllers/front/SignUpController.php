<?php
 namespace src\client\controllers\front;
 use src\vendor\message\Message     as Message;
 use \src\client\models\UserModel   as UserModel;
 
 
 //Register new user in the sysytem-ta 
class SignUpController{
    
    public  function index(){
         load_view('front', 'signup');
    }
    
    public function signup(){
        //if(User::isAuthenticated())        return redirect('index');

        //ako tokken ne syshtestvuva - vrushtaj i dali izptareniq tokken e 1
        //if(array_key_exists('tokken', $_POST))    return;

        //if(array_key_exists('tokken', $_POST) && $_POST['tokken'] != 1 )    return;

        //if(!isset($_POST['tokken']) && $_POST['tokken'] != 1)   return;

        //

           //echo('REGISTER'); 
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];
        $email          = $_POST['email'];

        //echo('$username'.$username); 

         if($username != null)
         {

        if(!Validator::hasMinLength($username, 5)) {
            return Message::set('sign_up_info_message', "Username length is below than 5 characters");
        }

        if(!Validator::hasMinLength($password, 5)) {
            return Message::set('sign_up_info_message', "Password length is below than 5 characters");
        }

        if(!Validator::hasMinLength($email, 5)) {
            return Message::set('sign_up_info_message', "E-mail length is below than 5 characters");
        }    

        if(!Validator::isRepeatPasswordValid($password, $repeatPassword)) {
            return Message::set('sign_up_info_message', "Original and repeat password does not match");
        }
        //echo('before insert'); 
        // TODO : process based on transaction 
        UserModel::cerateNewUser(array(
            'username'  => $username,
            'password'  => $password,
            'mail'     => $email
        ));

        //echo("end");
         }
        
    }
}
