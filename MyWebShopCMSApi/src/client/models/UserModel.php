<?php
namespace src\client\models;  //okazvame putq do class User;
use src\vendor\database\Database as Database;
class UserModel {
    
    const USERNAME = 'username';
    const USERPASS = 'password';
    const EMAIL = 'mail';
    
    public static function getId() {
        //return $_SESSION['user_data']['id'];
        return 1;
    }
    
    public static function auth($userData, $userRoleCollection) {
        
        $_SESSION['user_data']      = array(
            'id'    => $userData['id']
        );
        
        
        $_SESSION['user_role']      = $userRoleCollection;
        
        $_SESSION['is_loged_in']    = true;        
    }
    
    
    public static function isAuthenticated() {
        return isset($_SESSION['is_loged_in']) && 
               $_SESSION['is_loged_in'] == true;
    }
    
    public static function isGuest() {
        return !self::isAuthenticated();
    }
    
    public static function hasRoleUser() {
        return self::getRole() == 'USER';
    }
    
    public static function hasRoleModerator() {
        return self::getRole() == 'MODERATOR';
    }    
    
    public static function hasRoleAdmin() {
        return self::getRole() == 'ADMIN';
    }        
    
    /**
     * 
     * @return type
     */
    private static function getRole() {

        if(array_key_exists('user_role', $_SESSION)) {
//            return ($_SESSION['user_role'][0]['title']);
            return "user";
        }
    }
   
    public static function cerateNewUser($dataCollection){
        
         Database::insert('tb_users', array(
            'username'  => Database::str($dataCollection[self::USERNAME]),
            'password'  => Database::str ($dataCollection[self::USERPASS]),//(md5($password)),
            'mail'      => Database::str($dataCollection[self::EMAIL])
        ));
        //echo('insert'.insert); 

        Database::insert('tm_users__user_role', array(
            'user_id'   => Database::getLastInsertedId(),
            'role_id'   => 1 // TODO : Think about something better
        ));
    }
    
    public static function getAllUsers(){
            
        return Database::select('tb_users')::where(array(
            'username'      => $dataCollection[self::USERNAME],       //User::getId(),
            'password'   => $dataCollection[self::USERPASS]      //$this->productId
            )):: fetch();
        
    }
}
