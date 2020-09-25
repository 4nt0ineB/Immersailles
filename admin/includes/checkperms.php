<?php
session_start();

if (isset($_SESSION['logged'])){
  $id = $_SESSION['logged'];

  $select_user_info = $db->prepare("SELECT * FROM USERS WHERE id_user=:uid"); // Je séléctionne les paramètres de l'utilisateur
  $select_user_info->execute(array(":uid"=>$id));
  $row=$select_user_info->fetch(PDO::FETCH_ASSOC);
}

if(!isset($_SESSION["logged"])) // si l'user est pas log 
	  {
	    header("location:login.php"); // redirection
} 

?>