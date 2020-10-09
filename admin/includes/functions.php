<?php
    function getRole($number){
        if ($number == 1){
            return "Administrateur";
        } else if ($number == 2){
            return "Contributeur";
        }
    }

?>