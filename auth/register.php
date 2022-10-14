<?php
session_start();
// Include config.php file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = $rol = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

$id = $_SESSION["id"];

$sql = "SELECT role_id FROM users WHERE id = $id";
$result = $link->query($sql);

while ($row = $result->fetch_assoc()) {
    if ($row["role_id"] == 3) {
        // niks 
    } elseif ($row["role_id"] == 2) {
        header("location: ../screens/welcome");
        exit;
    } elseif ($row["role_id"] == 1) {
        header("location: ../screens/welcome");
        exit;
    }
}


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $rol = $_POST["rollen"];

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "vul een gebruikersnaam in.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "De gebruikersnaam mag alleen letters, cijfers en lage streepjes bevatten.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "De ingevoerde gebruikersnaam is al bezet.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oeps! Er ging iets mis. Probeer het later nog eens.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Vul een wachtwoord in.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Het wachtwoord moet minimaal 6 characters lang zijn.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Bevestig je wachtwoord.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "De wachtwoorden komen niet overeen.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, role_id, password) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_rol, $param_password);

            // Set parameters
            $param_rol = $rol;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: ../screens/adminpanel");
            } else {
                echo "Oeps! Er ging iets mis. Probeer het later nog eens.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../assets/components/header-meta.php.php"; ?>
    <title>Vrij Wonen | Aanmelden</title>
    <style>
        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        .invalid-feedback {

            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        body {
            height: 100vh;
            font: 14px sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        label {
            display: inline-block;
            margin-bottom: .5rem;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + .75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(.375em + .1875rem) center;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem);
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }

        .logo {
            width: 100%;
        }

        select {
            word-wrap: normal;
            width: 100%;
            height: 40px;
        }

        .btn-primary {
            color: #fff;
            background-color: #00A651;
            border-color: #00A651;
        }

        input {
            margin: 0;
            font-family: inherit;
            overflow: visible;
        }

        .btn-secondary {
            margin-left: .5rem;
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <img class="logo" src="../assets/components/img/vrijwonen_makelaar.png" />
        <hr>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" autofocus>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Bevestig wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>rol</label>
                <select name="rollen" id="rollen">
                    <option value="1">Werknemer</option>
                    <option value="2">Admin</option>
                    <option value="3">Beheerder</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registreren">
                <input type="reset" class="btn btn-secondary" value="Reset">
            </div>
            <p>Terug naar <a href="../screens/adminpanel">admin panel</a>.</p>
        </form>
    </div>
</body>

</html>