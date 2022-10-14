<?php
session_start();
require_once "../config.php";
global $link;

$id = $_SESSION["id"];

$sql2 = "SELECT role_id FROM users WHERE id = $id";
$result = $link->query($sql2);

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


if (!isset($_GET['id'])) {
  die('Oops er is iets missgegaan!');
}


$Gebruiker_id = $_GET['id'];

$user_id = $_SESSION["id"];

$sql = "SELECT * FROM users WHERE id = $Gebruiker_id";
$result = $link->query($sql);



if (array_key_exists('UpdateUser', $_POST)) {
  UpdateUser();
}

function UpdateUser()
{
  global $link;

  $id = $_POST["id"];
  $name = $_POST["name"];
  $rol = $_POST["Rol"];

  if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
  }


  if ($rol == "Werknemer") {
    mysqli_query($link, "UPDATE users SET username = '$name', role_id= '1'WHERE id = $id;");
  } elseif ($rol == "admin") {
    mysqli_query($link, "UPDATE users SET username = '$name', role_id= '2'WHERE id = $id;");
  } elseif ($rol == "beheerder") {
    mysqli_query($link, "UPDATE users SET username = '$name', role_id= '3'WHERE id = $id;");
  }

  header('Location: adminpanel');
};

if(array_key_exists('deleteUser', $_POST)) {
  deleteUser();
}

function deleteUser() {
  GLOBAL $link;
  $Gebruiker_id = $_GET['id'];
  $sqlDeleteUser = "DELETE FROM users WHERE id='$Gebruiker_id'";

  if ($link->query($sqlDeleteUser) === TRUE) {
    header("Location: adminpanel");
  } else {

  }   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Vrij Wonen | Attributen</title>
  <?php include "../assets/components/header-meta.php"; ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">


  <style>
    .form-input-txt {
      width: 100%;
      height: 35px;
      border: 3px solid #00A651;
      border-radius: 0px;
      top: 25px;
      font-size: 1rem;
      margin-bottom: 1.5rem;
      height: 3rem;
    }

    .form-input-txt:focus-visible {
      outline: none;
    }

    .form-input-slct {
      width: 100%;
      height: 35px;
      border: 3px solid #00A651;
      border-radius: 0px;
      top: 25px;
      font-size: 1rem;
      margin-bottom: 1.5rem;
      height: 3rem;
    }

    .form-input-slct:focus-visible {
      outline: none;
    }

    option {
      border-radius: 0;
    }

    .form-button {
      bottom: 0px;
      width: 100%;
      height: 35px;
      padding: 0;
      top: 25px;
      border: none;
      background: #00A651;
      color: white;
    }

    .form-button-red {
            bottom: 0px;
            width: 100%;
            height: 35px;
            padding: 0;
            top: 25px;
            border: none;
            background: red;
            color: white;
        }

    .marg-top-10rem {
      margin-top: 10rem;
    }

    .title-h3 {
      margin-bottom: 2rem;
      text-align: center;
    }

    .form-div {
      width: 100vw;
      height: 17.4rem;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-attribute {
      display: flex;
      flex-direction: column;
      border: 5px solid #0C5E34;
      padding: 2rem;
      height: 100%;
      width: 20rem;
    }

    .input-div {
      position: relative;
      width: 246px;
    }
  </style>

</head>

<body class="d-flex flex-column min-vh-100">
  <?php
  // include "../assets/components/header.php"; 

  while ($row = $result->fetch_assoc()) {
  ?>

    <div class="marg-top-10rem">
      <h3 class="title-h3">Wijzig gebruiker</h3>
      <div class="form-div">
        <form class="form-attribute" method="post" action="">
          <input type="hidden" name="id" value="<?php echo $Gebruiker_id; ?>">
          <input class="form-input-txt" type="text" name="name" value="<?php echo $row['username']; ?>" autofocus>
          <select class="form-input-slct" name="Rol">
            <?php
            if ($row["role_id"] == 1) {
            ?>
              <option value="Werknemer">Werknemer</option>
              <option value="admin">admin</option>
              <option value="beheerder">beheerder</option>
            <?php
            } elseif ($row["role_id"] == 2) {
            ?>
              <option value="admin">admin</option>
              <option value="Werknemer">Werknemer</option>
              <option value="beheerder">beheerder</option>
            <?php
            } elseif ($row["role_id"] == 3) {
            ?>
              <option value="beheerder">beheerder</option>
              <option value="admin">admin</option>
              <option value="Werknemer">Werknemer</option>
            <?php
            }
            ?>
          </select>
          <div class="input-div">
            <input class="form-button" type="submit" name="UpdateUser" value="Opslaan">
          </div>
          <div style="margin-top: 1rem;" class="input-div">
            <input class="form-button-red" type="submit" name="deleteUser" value="Verwijder">
          </div>
        </form>
      </div>
    </div>
  <?php
  }
  ?>


  <?php include "../assets/components/footer.php"; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>