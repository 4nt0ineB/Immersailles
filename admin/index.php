<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/checkperms.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Se connecter</title>
  <?php require_once("includes/head.html") ?>
  <script src="../scripts/js/inactivity.js"></script>

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

    /* Promoted links */
    .promoted-link {
      border: px black solid;
      border-radius: 10px;
      position: relative;
      overflow: hidden;
      margin-top: 10px;
      box-shadow: 10px 10px 10px rgba(209, 209, 209, 1);

    }

    .promoted-link>img {
      width: 100%;
    }

    .promoted-link>.description {
      background-color: rgb(0, 0, 0, 0.75);
      position: absolute;
      top: 75%;
      width: 100%;
      height: 100%;
      transition: all 0.3s ease-in-out;
      color: white;
      padding-left: 10px;
    }

    .promoted-link>.description>.title {
      font-weight: 550;
    }


    .promoted-link>.description>.detail {
      color: #C8AD7F;
      margin-top: -25px;
    }

    .promoted-link:hover .description {

      transition: all 0.3s ease-in-out;
      top: 10%;
      background-color: rgb(0, 0, 0, 0.75);
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
          <h3>Bienvenue <?php echo $row["surname"]; ?></h3>
          <div class="container">

            <div class="row text-left">
              <div class="col card_recap mr-3">
                <div class="text_recap">Utilisateurs<br><span>Nombre total d'utilisateurs connectés</span></div>
                <div class="align-middle text_right">
                  <?php
                  echo User::numberConnectedUsers();
                  ?>
                </div>

              </div>
              <div class="col card_recap mr-3" style="background-image: radial-gradient(circle 248px at center, #5f5f5f 0%, #505050 47%, #3e3e3e 100%) !important;">
                <div class="text_recap">Marqueurs<br><span>Nombre total de marqueurs</span></div>
                <div class="text_right"><?php
                                        echo $db->query("SELECT * FROM MARKERS")->rowCount();
                                        ?></div>
              </div>
              <div class="col card_recap" style="background-image: linear-gradient(to bottom, #C8AD7F 0%, #af8132 100%) !important">
                <div class="text_recap">Plans<br><span>Nombre total de plans disponibles</span></div>
                <div class="text_right">3</div>
              </div>
            </div>

            <div class="row" style="margin-top: 10px;">
              <div class="col-lg-12">

              </div>
            </div>
            <div class="row content-justify-center" style="margin-top: 10px;">
              <div class="col-lg-2 offset-lg-2 content-justify-center">
                <a class="text-left" href="manage_users.php">
                  <div class="promoted-link">
                    <img src="../img/musketeer.png">
                    <div class="description">
                      <div class="title">Utilisateurs</div>
                      <br>
                      <div class="detail">Gérer les utilisateurs</div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-lg-2 content-justify-center">
                <a class="text-left" href="manage_markers.php">
                  <div class="promoted-link">
                    <img src="../img/markerpromote.png">
                    <div class=" description">
                      <div class="title">Marqueurs</div>
                      <br>
                      <div class="detail">Gérer les marqueurs</div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-lg-2 content-justify-center">
                <a class="text-left" href="manage_maps.php">
                  <div class="promoted-link">
                    <img src="../img/planpromote.png">
                    <div class="description">
                      <div class="title">Plans</div>
                      <br>
                      <div class="detail">Gérer les plans</div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-lg-2 content-justify-center">
                <a class="text-left" href="manage_objects.php">
                  <div class="promoted-link">
                    <img src="../img/objetpromote.png">
                    <div class="description">
                      <div class="title">Objets</div>
                      <br>
                      <div class="detail">Gérer les objets</div>
                    </div>
                  </div>
                </a>
              </div>

            </div>
            <div class="row content-justify-center" style="margin-top: 10px;">
              <div class="col-lg-12 content-justify-center">
                <a class="text-center" href="./logout.php">Se déconnecter</a>
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