<?php include("../includes/mysql.php"); ?>
<?php include("includes/checkperms.php"); ?>
<?php include("includes/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Se connecter</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="../style/style.css" />
    <style>
    #row {
      width: 100%;
      text-align: center;
    }
 
    table {
      margin: 0 auto;
      width: 100%;
      table-layout: fixed;
    }

    td {
        width: 33.3%;
        padding-right: 17px;
    }


</style>


</head>

<body class="d-flex flex-column min-vh-100">
    <!--Navbar-->
    <?php include("includes/navbar.php"); ?>
    <!--Fin navbar -->

    <div class="container change-section">

        <div class="row h-100 align-self-center">

            <div class="col-md-12 text-center">

                <h2 id="title-current-place" style="padding: 10px;">Panel de gestion</h2>


                <div id="box">
                <h3>Bienvenue <?php echo $row["name"]; ?></h3>
                  <div class="container">

                    <div class="row text-left">
                      <div class="col card_recap mr-3"><div class="text_recap">Utilisateurs<br><span>Nombre total d'utilisateurs</span></div> 
                      <div class="align-middle text_right">
                      <?php    
                        echo $db->query("SELECT COUNT(*) FROM USERS GROUP BY id_user")->rowCount();
                      ?>
                      </div>
                      
                      </div>
                      <div class="col card_recap mr-3" style="background-image: radial-gradient(circle 248px at center, #5f5f5f 0%, #505050 47%, #3e3e3e 100%) !important;"> 
                        <div class="text_recap">Marqueurs<br><span>Nombre total de marqueurs</span></div> <div class="text_right">20</div>
                      </div>
                      <div class="col card_recap" style="background-image: linear-gradient(to bottom, #C8AD7F 0%, #af8132 100%) !important">
                      <div class="text_recap">Plans<br><span>Nombre total de plans disponibles</span></div> <div class="text_right">3</div></div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-lg-12" >
                        <a href="manage_users.php" class="btn btn-dark">Gestion des utilisateurs</a>
                        <a href="#" class="btn btn-dark">Gestion des marqueurs</a>
                        <a href="#" class="btn btn-dark">Gestion des plans</a>
                        </div>
                    </div>
                    <div class="row content-justify-center" style="margin-top: 10px;">
                      <div class="col-lg-12 content-justify-center">
                        <a class="text-center" href="logout.php">Se déconnecter</a>

                      </div>
                    </div>

  </div>
                </div>

            </div>

        </div>

    </div>


    </div>





    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>