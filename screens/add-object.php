<?php
session_start();

if(isset($_SESSION["loggedin"])){
} else {
    header("Location: ../Auth/login");
}

require_once "../config.php";
GLOBAL $link;

$user_id = $_SESSION["id"];

if(array_key_exists('addObject', $_POST)) {
    addObject();
}

function addObject() {
    GLOBAL $link;

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $size = $_POST["size"];
    $postalcode = $_POST["postalcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $housenumber = $_POST["housenumber"];

    if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
    }

    $sql = "INSERT INTO object (status, name, description, price, size, street, city, housenumber, postalcode) VALUES ('Te Koop', '$name', '$description', '$price', '$size', '$street', '$city', '$housenumber', '$postalcode')";

    if ($link->query($sql) === TRUE) {
    } else {
    echo "Error: " . $sql . "<br>" . $link->error;
    }

    $sql3 = 'SELECT id FROM object WHERE name="'. $_POST["name"].'"';

    $result3 = $link->query($sql3);

    while($row = $result3->fetch_assoc()) {
        $object_id = $row["id"];
    }

    $sql7 = "SELECT * FROM attribute";
    $result7 = $link->query($sql7);
    while($row = $result7->fetch_assoc()) {
        $attribute_id = $row["id"];
        $attribute_name = $row["name"];
        $sql8 = "INSERT INTO object_attribute (object_id, attribute_id, attribute_name, status) VALUES ('$object_id', '$attribute_id', '$attribute_name', '0')";
        if ($link->query($sql8) === TRUE) {
        } else {
        echo "Error: " . $sql8 . "<br>" . $link->error;
        }
    }

    $checkbox=$_POST['attributes'];  

    foreach($checkbox as $attribute_id) {
        
        $sql6 = "UPDATE object_attribute SET status = 1 WHERE object_id = $object_id AND attribute_id = $attribute_id";
        if ($link->query($sql6) === TRUE) {
        } else {
        echo "Error: " . $sql6 . "<br>" . $link->error;
        }
    }  

    $file1 = $_FILES["file1"]["name"];
    $file2 = $_FILES["file2"]["name"];
    $file3 = $_FILES["file3"]["name"];
    $file4 = $_FILES["file4"]["name"];
    $file5 = $_FILES["file5"]["name"];

    $temp1 = explode(".", $file1);
    $newfilename1 = 'hoofd' . '.' . end($temp1);
    $temp2 = explode(".", $file2);
    $newfilename2 = '1' . '.' . end($temp2);
    $temp3 = explode(".", $file3);
    $newfilename3 = '2' . '.' . end($temp3);
    $temp4 = explode(".", $file4);
    $newfilename4 = '3' . '.' . end($temp4);
    $temp5 = explode(".", $file5);
    $newfilename5 = '4' . '.' . end($temp5);
    

    $f1 = "../assets/img/woningen/woning $object_id/".$newfilename1;
    $f2 = "../assets/img/woningen/woning $object_id/".$newfilename2;
    $f3 = "../assets/img/woningen/woning $object_id/".$newfilename3;
    $f4 = "../assets/img/woningen/woning $object_id/".$newfilename4;
    $f5 = "../assets/img/woningen/woning $object_id/".$newfilename5;

    $sql2 = "INSERT INTO object_image (object_id, hoofd_img, img_1, img_2, img_3, img_4) VALUES ('$object_id', '$f1', '$f2', '$f3', '$f4', '$f5')";
    if($link->query($sql2)) {
        if (!file_exists('../assets/img/woningen/woning ' . $object_id)) {
            mkdir('../assets/img/woningen/woning ' . $object_id, 0777, true);
        } else {}
        move_uploaded_file($_FILES["file1"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename1");
        move_uploaded_file($_FILES["file2"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename2");
        move_uploaded_file($_FILES["file3"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename3");
        move_uploaded_file($_FILES["file4"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename4");
        move_uploaded_file($_FILES["file5"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename5");
    } else {
        echo "Error: " . $sql2 . "<br>" . $link->error;
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
            border: 3px solid #00A651;
            border-radius: 0px;
            top: 25px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-input-txt:focus-visible {
            outline: none;
        }

        .form-input-slct {
            width: 100%;
            border: 3px solid #00A651;
            border-radius: 0px;
            top: 25px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
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

        .marg-top-4rem {
            margin-top: 4rem;
        }

        .title-h3 {
            margin-bottom: 2rem; 
            text-align: center;
        }

        .form-div {
            width: 100vw; 
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

        label {
            margin-bottom: 0;
        }

        .form-input-file {
            width: 100%;
            border-radius: 0px;
            top: 25px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        input[type=file]::file-selector-button {
            border: none;
            background-color: #00A651;
            color: white;
            margin: .2rem 0rem;
        }

        .div-checkbox-attribute {
            margin-bottom: 1.5rem;
        }
    </style>
    
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include "../assets/components/header.php"; 
    ?>
    <div class="marg-top-4rem">
        <h3 class="title-h3">Nieuwe woning</h3>
        <div class="form-div">
            <form class="form-attribute" method="post" action="" enctype="multipart/form-data">
                <label for="name">Naam</label>
                <input class="form-input-txt" type="text" name="name">
                <label for="description">Omschrijving</label>
                <textarea style="height: 100px;" class="form-input-txt" type="text" name="description"></textarea>
                <label for="price">Prijs</label>
                <input class="form-input-txt" type="text" name="price">
                <label for="size">Oppervlakte</label>
                <input class="form-input-txt" type="text" name="size">
                <label for="postalcode">Postcode</label>
                <input class="form-input-txt" type="text" name="postalcode">
                <label for="city">Plaats</label>
                <input class="form-input-txt" type="text" name="city">
                <label for="street">Straatnaam</label>
                <input class="form-input-txt" type="text" name="street">
                <label for="housenumber">Huisnummer</label>
                <input class="form-input-txt" type="text" name="housenumber">
                <label for="housenumber">Eigenschappen</label>
                <div class="div-checkbox-attribute">
                    <?php 
                        $sql4 = "SELECT * FROM attribute";
                        $result4 = $link->query($sql4);
                        while($row = $result4->fetch_assoc()) {
                        ?>
                            <div>
                                <input type="checkbox" name="attributes[]" value="<?php echo $row["id"]; ?>">
                                <label for="attributes"><?php echo $row["name"]; ?></label>   
                            </div>
                        <?php
                        }
                    ?>
                </div>
                <label for="file1">Hoofd afbeelding</label>
                <input class="file-button form-input-file" type="file" name="file1">
                <label for="file2">Afbeelding</label>
                <input class="file-button" type="file" name="file2">
                <input class="file-button" type="file" name="file3">
                <input class="file-button" type="file" name="file4">
                <input class="file-button form-input-file" type="file" name="file5">
                <input class="form-button" type="submit" name="addObject" value="Opslaan">
            </form>
        </div>
    </div>
    <?php
    ?>
    

    <?php include "../assets/components/footer.php"; ?>

 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>