<?php require_once("../includes/mysql.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/checkperms.php"); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des années</title>
    <?php require_once("includes/head.html"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <script src="../scripts/js/datatable.js"></script>

    <style>
        #btnsupp {
            background-color: #ae918b;
            border-color: #ae918b;
            transition: color .15s ease-in-out,
                background-color .15s ease-in-out,
                border-color .15s ease-in-out,
                box-shadow .15s ease-in-out;
        }

        #btnsupp:hover {
            background-color: #99807b;
            border-color: #99807b;
            transition: color .15s ease-in-out,
                background-color .15s ease-in-out,
                border-color .15s ease-in-out,
                box-shadow .15s ease-in-out;
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
                    <h3>Gestion des années</h3>
                    <br>
                    <?php
                    if (isset($_POST['subdelete'])) {
                        if (YEAR::deleteYear($_POST['year_id'])) {
                    ?>
                            <div class="alert alert-success" role="alert">
                                L'année a bien été supprimé.
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                Une erreur s'est produite, l'année n'a pas pu être supprimée.
                            </div>
                    <?php

                        }
                        header("refresh:1; manage_years.php");
                    }
                    ?>
                    <div class="row float-right" style="margin: 10px auto;"><a href="create_year.php" class="btn btn-dark">Créer une nouvelle année</a></div>
                    <br>
                    <table id="datatable" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Année</th>
                                <th>Libellé</th>
                                <th>Nb. cartes associées</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $years = $db->query("SELECT * FROM YEARS");
                            while ($y = $years->fetch()) {
                                $year = $y["year"];
                                $countMapWithYear = $db->query("SELECT * FROM MAPS,YEARS WHERE MAPS.id_year=YEARS.id_year AND YEARS.year=$year")->rowCount();
                                echo '<tr>
                                    <td>' . $y["id_year"] . '</td>
                                    <td>' . $year . '</td>
                                    <td>' . $y["label"] . '</td>
                                    <td>' . $countMapWithYear . '</td>';
                                echo '<td>
                                        <a href="create_year.php?mod=' . $y['id_year'] . '" class="btn btn-primary" style="margin-right: 20px;">
                                            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                        <a id="btnsupp" data-toggle="modal" data-id="' . $y['id_year'] . '" title="Add this item" class="open-AddBookDialog btn btn-primary" href="#addBookDialog">
                                            <svg width="1.4em" height="1.4em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="black" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                            </svg>
                                        </a>
                                    </td>';



                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <a href="index.php" class="btn btn-dark">Retour à l'accueil</a>
                </div>

            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="addBookDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Suppression</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Attention l'année sera définitivement supprimée, ainsi que les cartes et objets qui lui sont associées.</p>
                        <br>
                        <p>Souhaitez-vous continuer ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <form method="post" action="">
                            <input type="hidden" name="year_id" id="year_id" value="">
                            <button type="submit" name="subdelete" class="btn btn-primary">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).on("click", ".open-AddBookDialog", function() {
                var myBookId = $(this).data('id');
                $(".modal-footer #year_id").val(myBookId);
            });
        </script>

    </div>

    <!-- Footer -->
    <?php include("../includes/footer.php"); ?>
    <!-- Footer -->
</body>

</html>