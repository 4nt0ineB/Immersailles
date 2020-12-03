<?php
session_start();

if (isset($_SESSION['user'])) {
  $_SESSION["user"]->refreshSession(); // on check la validité de la session user
  if (!$_SESSION['user']->checkPageAutorisation()) { // check de l'autorisation d'accès à la page selon le rôle
    header("location: index.php");
  }

  $id = $_SESSION['user']->getId();

  $select_user_info = $db->prepare("SELECT * FROM USERS WHERE id_user=:uid"); // Je séléctionne les paramètres de l'utilisateur
  $select_user_info->execute(array(":uid" => $id));
  $row = $select_user_info->fetch(PDO::FETCH_ASSOC);
}

if (!isset($_SESSION["user"])) // si l'user est pas log 
{
  header("location:login.php"); // redirection
}

// TO DO: vérifier l'accès des utilisateurs selon les pages 