<?php
session_start();
if(!isset($_SESSION["logged"])) // si la session n'est pas lancée
  {
    header("location:index.php"); // si la personne n'est pas connecté redirection sur une page avec message d'erreur
  } else{
    header("location:index.php"); // sinon redirection sur index

    session_destroy(); // et destruction de la session en cours.
  }
?>