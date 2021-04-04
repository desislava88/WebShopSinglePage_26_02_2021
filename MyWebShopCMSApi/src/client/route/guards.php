<?php
function redirectIfAuthenticated(){
    return User::isAuthenticated();
}

function preventSubmitBeforeTokkenValidation(){
    
}

function adminOnly(){
    return !User::hasRoleAdmin();
}
