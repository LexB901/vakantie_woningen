<?php
session_start();

if(isset($_SESSION["loggedin"])){
} else {
    header("Location: ../Auth/login");
}

require_once "../config.php";

    GLOBAL $link;
    $object_id = $_GET['id'];
    $user_id = $_SESSION["id"];
    
    $sql = "SELECT * FROM object WHERE id = $object_id";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();
    
    $attribute = mysqli_query($link, "SELECT * FROM object_attribute INNER JOIN attribute ON object_attribute.attribute_id = id WHERE object_id = $object_id");
    if (mysqli_num_rows($attribute) > 0){
    $i = 0;
        while($data = mysqli_fetch_array($attribute)){
            $item = new stdClass();
            $item = $data['name'];
            $checkbox[$i] = $item;
            $i++;
        }
    }   
    $sql = "SELECT * FROM object_image WHERE object_id = $object_id";
    $result = $link->query($sql);
    $images = $result->fetch_assoc();


if(array_key_exists('editObject', $_POST)) {
    editObject();
}


function editObject() {
    GLOBAL $link;
    $object_id = $_GET['id'];
    $status = $_POST["status"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $size = $_POST["size"];
    $postalcode = $_POST["postalcode"];
    $city = $_POST["city"];
    $street = $_POST["street"];
    $housenumber = $_POST["housenumber"];

    $sql2 = "UPDATE object SET status = '$status', name = '$name', description = '$description', price = '$price', size = '$size', street = '$street', city = '$city', housenumber = '$housenumber', postalcode = '$postalcode' WHERE id = '$object_id'";
    mysqli_query($link, $sql2);

    $sql7 = "SELECT * FROM attribute";
    $result7 = $link->query($sql7);
    while($row = $result7->fetch_assoc()) {
        $attribute_id = $row["id"];
        $attribute_name = $row["name"];
        $sql8 = "UPDATE object_attribute SET object_id = $object_id, attribute_id = attribute_id, attribute_name = attribute_name, status = '0' WHERE object_id = $object_id";
        if ($link->query($sql8) === TRUE) {
        } else {
        echo "Error: " . $sql8 . "<br>" . $link->error;
        }
    }
    if(isset($_POST['attributes'])){
        $checkbox=$_POST['attributes'];  

        foreach($checkbox as $attribute_id) {
            
            $sql6 = "UPDATE object_attribute SET status = 1 WHERE object_id = $object_id AND attribute_id = $attribute_id";
            if ($link->query($sql6) === TRUE) {
            } else {
            echo "Error: " . $sql6 . "<br>" . $link->error;
            }
        }  
    }

    
    $sql = "SELECT * FROM object_image WHERE object_id = $object_id";
    $result = $link->query($sql);
    $images = $result->fetch_assoc();


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

    if(!empty($file1)){
        $f1 = "../assets/img/woningen/woning $object_id/".$newfilename1;
        $sqlImage = "UPDATE `object_image` SET hoofd_img='$f1' WHERE object_id=$object_id";
        mysqli_query($link, $sqlImage);

    }
    if(!empty($file2)){
        $f2 = "../assets/img/woningen/woning $object_id/".$newfilename2;
        $sqlImage = "UPDATE `object_image` SET img_1='$f2' WHERE object_id=$object_id";
        mysqli_query($link, $sqlImage);


    }
    if(!empty($file3)){
        $f3 = "../assets/img/woningen/woning $object_id/".$newfilename3;
        $sqlImage = "UPDATE `object_image` SET img_2='$f3' WHERE object_id=$object_id";
        mysqli_query($link, $sqlImage);

    }
    if(!empty($file4)){
        $f4 = "../assets/img/woningen/woning $object_id/".$newfilename4;
        $sqlImage = "UPDATE `object_image` SET img_3='$f4' WHERE object_id=$object_id";
        mysqli_query($link, $sqlImage);

    }
    if(!empty($file5)){
        $f5 = "../assets/img/woningen/woning $object_id/".$newfilename5;
        $sqlImage = "UPDATE `object_image` SET img_4='$f5' WHERE object_id=$object_id";
        mysqli_query($link, $sqlImage);

    }
    if(!empty($file1) || !empty($file2) || !empty($file3) || !empty($file4) ||!empty($file5)){
        if($link->query($sqlImage)) {
            if (!file_exists('../assets/img/woningen/woning ' . $object_id)) {
                mkdir('../assets/img/woningen/woning ' . $object_id, 0777, true);
            } else {}
            move_uploaded_file($_FILES["file1"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename1");
            move_uploaded_file($_FILES["file2"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename2");
            move_uploaded_file($_FILES["file3"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename3");
            move_uploaded_file($_FILES["file4"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename4");
            move_uploaded_file($_FILES["file5"]["tmp_name"], "../assets/img/woningen/woning $object_id/$newfilename5");
        } else {
            echo "Error: " . $sqlImage . "<br>" . $link->error;
        }
    }
    header('Location: adminpanel.php');
};

if(array_key_exists('deleteObject', $_POST)) {
    deleteObject();
}

function deleteObject() {
    GLOBAL $link;
    $object_id = $_GET['id'];
    $sqlDeleteObject = "DELETE FROM object WHERE id='$object_id'";

    if ($link->query($sqlDeleteObject) === TRUE) {
        header('Location: adminpanel');
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

        .marg-top-4rem {
            margin-top: 4rem;
        }

        .title-h3 {
            margin-bottom: 2rem; 
            text-align: center;
        }

        .form-div {
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

        .row{
            
            display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  background-color: #00A651;
  margin-bottom: 1.5rem;


        }
        .center{
            margin-left: 30
        }
        .resize{
            
            width:135px;
            height: 110px;
            MARGIN: 1PX;
        }
    </style>
    
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include "../assets/components/secondHeader.php"; 
    ?>
    <div class="marg-top-4rem">
        <h3 class="title-h3">edit woning</h3>
        <div class="form-div">
            <form class="form-attribute" method="post" action="" enctype="multipart/form-data">
                <label for="name">Status</label>
                <select class="form-input-slct" name="status" id="status">
                    <?php 
                        $currentStatus = $row['status'];
                        echo $currentStatus;
                        $sql5 = "SELECT * FROM object_status_type WHERE name='$currentStatus'";
                        $rs_result5 = mysqli_query($link, $sql5);  
                        while ($row5 = mysqli_fetch_array($rs_result5)) {  
                    ?>
                        <option name="status_old"><?php echo $row5["name"];?></option>
                        <?php
                        }
                        ?>
                    <?php
                        $sql9 = "SELECT * FROM object_status_type";
                        $rs_result9 = mysqli_query($link, $sql9);  
                        while ($row9 = mysqli_fetch_array($rs_result9)) {  
                    ?>
                        <option value="<?php echo $row9['name']; ?>"><?php echo $row9['name']; ?></option>
                    <?php
                        }
                    ?>
                    <script>
                        $("#status option[value='<?php echo $row["status"];?>']").each(function() {
                            $(this).remove();
                        });
                    </script>
                </select>
                <label for="name">Naam</label>
                <input class="form-input-txt" type="text" name="name" value="<?php echo $row["name"]?>">
                <label for="description">Omschrijving</label>
                <textarea style="height: 100px;" class="form-input-txt" type="text" name="description"><?php echo $row["description"] ?></textarea>
                <label for="price">Prijs</label>
                <input class="form-input-txt" type="text" name="price"  value="<?php echo $row["price"]?>">
                <label for="size">Oppervlakte</label>
                <input class="form-input-txt" type="text" name="size" value="<?php echo $row["size"]?>">
                <label for="postalcode">Postcode</label>
                <input class="form-input-txt" type="text" name="postalcode" value="<?php echo $row["postalcode"]?>">
                <label for="city">Plaats</label>
                <input class="form-input-txt" type="text" name="city" value="<?php echo $row["city"]?>">
                <label for="street">Straatnaam</label>
                <input class="form-input-txt" type="text" name="street" value="<?php echo $row["street"]?>">
                <label for="housenumber">Huisnummer</label>
                <input class="form-input-txt" type="text" name="housenumber" value="<?php echo $row["housenumber"]?>">
                <label for="housenumber">Eigenschappen</label>
                <div class="div-checkbox-attribute">
                    <?php 
                        $sql1 = "SELECT * FROM object_attribute WHERE object_id=$object_id";
                        $result1 = $link->query($sql1);
                        while($row1 = $result1->fetch_assoc()) {
                        ?>
                            <div>
                                <input type="checkbox" name="attributes[]" value="<?php echo $row1['attribute_id']; ?>"  <?php if (strpos($row1['status'],'1') !== false) echo 'checked="checked"'; ?>>
                                <label for="attributes"><?php echo $row1["attribute_name"]; ?></label>         
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
                <div class="row">
                    <img class="resize" src="<?php echo $images["hoofd_img"]?>" alt="pic1">
                    <img class="resize" src="<?php echo $images["img_1"]?>" alt="pic1">
                    <img class="resize" src="<?php echo $images["img_2"]?>" alt="pic1">
                    <img class="resize" src="<?php echo $images["img_3"]?>" alt="pic1">
                    <img   class="resize" src="<?php echo $images["img_4"]?>" alt="pic1">
                 </div>
            <input class="form-button" type="submit" name="editObject" value="Opslaan">
            <input style="margin-top: 1rem;" class="form-button-red" type="submit" name="deleteObject" value="Verwijder">

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