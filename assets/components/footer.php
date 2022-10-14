<footer class="flex-shrink-0 mt-auto p-4 text-black-50">
    <hr>
    <div class="container d-flex flex-row">
        <small>Copyright &copy; Vakantiewoningen makelaar Vrij Wonen</small>
        <div class="mr-auto"></div>

        <?php

        if (isset($_SESSION["loggedin"])) {
            echo '
                    <div><small><a href="adminpanel">adminpanel</a></small><small> | </small><small><a href="../auth/logout">uitloggen</a></small><small> | </small><small><a href="../auth/reset-password">reset wachtwoord</a></small></div>
                ';
        };

        if (!isset($_SESSION["loggedin"])) {
            echo '
                    <div><small><a href="../auth/login">inloggen</a></small></div>
                ';
        };
        ?>

    </div>
</footer>