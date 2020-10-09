<?php
session_start();
if (!isset($_SESSION["user"])) // si la session n'est pas lancée
{
  header("location:login.php"); // si la personne n'est pas connecté redirection sur une page avec message d'erreur
} else {
  header("location:login.php"); // sinon redirection sur index
  $_SESSION = array();
  session_destroy(); // et destruction de la session en cours.
}
