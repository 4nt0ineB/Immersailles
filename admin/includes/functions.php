<?php
    function getRole($number){
        if ($number == 1){
            return "Administrateur";
        } else if ($number == 2){
            return "Contributeur";
        }
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /*
    function refresh_user_session(){
        $_SESSION["user"]->refreshSession();
    }
    */

?>