<?php

session_start();

/**
 *  Check if user logged in
 *  
 * @return boolean
 */

function isLoggedIn(){
if(isset($_SESSION['user_id'])){
    return true;
    } else {
    return false;
    }
}
