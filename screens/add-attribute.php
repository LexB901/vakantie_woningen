<?php
session_start();

require_once "../config.php";
GLOBAL $link;

$user_id = $_SESSION["id"];

if(array_key_exists('addAttribute', $_POST)) {
    addAttribute();
}

function addAttribute() {
    GLOBAL $link;

    $name = $_POST["name"];
    $property = $_POST["property"];

    if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
    }

    if ($property == "Eigenschap") {
        mysqli_query($link, "INSERT INTO attribute (name, property_id) VALUES ('$name', '1')");
    } elseif ($property == "Ligging") {
        mysqli_query($link, "INSERT INTO attribute (name, property_id) VALUES ('$name', '2')");
    }

    $sql4 = "SELECT id FROM attribute WHERE name = '$name'";
    $result4 = $link->query($sql4);

    $sql3 = "SELECT id FROM object";
    $result3 = $link->query($sql3);

    while($row4 = $result4->fetch_assoc()) {
        $attribute_id = $row4["id"];
        while($row3 = $result3->fetch_assoc()) {
            $object_id = $row3["id"];
            mysqli_query($link, $sql5 = "INSERT INTO object_attribute (object_id, attribute_id, attribute_name, status) VALUES ('$object_id', '$attribute_id', '$name', '0')");
        }
    }
    header('Location: adminpanel');
};

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
            position: absolute;
            bottom: 0px;
            width: 100%;
            height: 35px;
            padding: 0;
            top: 25px;
            border: none;
            background: #00A651;
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
    include "../assets/components/secondHeader.php"; 
    
    ?>
    <div class="marg-top-10rem">
        <h3 class="title-h3">Nieuw Attribuut</h3>
        <div class="form-div">
            <form class="form-attribute" method="post" action="">
                <input class="form-input-txt" type="text" name="name" placeholder="Naam attribute" autofocus>
                <select class="form-input-slct" name="property">
                    <option selected="true" disabled="disabled">Selecteer soort attribuut</option>    
                    <option value="Eigenschap">Eigenschap</option>
                    <option value="Ligging">Ligging</option>
                </select>
                <div class="input-div">
                    <input class="form-button" type="submit" name="addAttribute" value="Toevoegen">
                </div>
            </form>
        </div>
    </div>
    
    <?php include "../assets/components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>