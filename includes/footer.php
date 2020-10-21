<footer class="page-footer mt-auto font-small white">
    <!-- Copyright -->
    <div class="container">
        <table style="width: 100%;text-align: center;padding-top:10px;">
            <tbody>
                <tr>
                    <td><span class="label-info">Lorem</span><br>ifhuiosfhio</td>
                    <td><span class="label-info">Lorem</span><br>ifhuiosfhio</td>
                    <td><span class="label-info">Lorem</span><br>ifhuiosfhio</td>
                    <?php
                    if (!isset($_SESSION["user"])) {
                    ?>
                        <td><span class="label-info">CRCV</span><br><a href="admin">Connexion</a></td>
                    <?php
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        <div id="footp" class="footer-copyright text-center py-3">
            Copyright © 2020 x Inc. Tous droit réservés
        </div>
    </div>
    <!-- Copyright -->
</footer>