<?php
session_start();

if(!isset($_GET['id'])) {
    die('Oops er is iets missgegaan!');
}

if(isset($_SESSION["loggedin"])){
} else {
    header("Location: ../Auth/login");
}

require_once "../config.php";
GLOBAL $link;

$ticket_id = $_GET["id"];

$user_id = $_SESSION["id"];

$sql = "SELECT * FROM ticket WHERE id = $ticket_id";
$result = $link->query($sql);

if(array_key_exists('updateTicket', $_POST)) {
    updateTicket();
}

function updateTicket() {
    GLOBAL $link;

    $ticket_id = $_GET["id"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $user_id = $_SESSION["id"];

    if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
    }

    mysqli_query($link, "UPDATE ticket SET description='$description', status='$status', user='$user_id' WHERE id=$ticket_id");

    header('Location: adminpanel');
};

if(array_key_exists('deleteTicket', $_POST)) {
    deleteTicket();
}

function deleteTicket() {
    GLOBAL $link;
    $ticket_id = $_GET["id"];
    $sqlDeleteTicket = "DELETE FROM ticket WHERE id='$ticket_id'";

    if ($link->query($sqlDeleteTicket) === TRUE) {
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
    </style>
    
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include "../assets/components/header.php"; 
    
    while($row = $result->fetch_assoc()) {
    ?>

    <div class="marg-top-4rem">
        <h3 class="title-h3">Wijzig Attribuut</h3>
        <div class="form-div">
            <form class="form-attribute" method="post" action="">
                <input type="hidden" name="id" value="<?php echo $ticket_id; ?>">
                <label for="name">Naam</label>
                <p class="form-input-txt"><?php echo $row['name'];?></p>
                <label for="email">Email</label>
                <p class="form-input-txt"><?php echo $row['email'];?></p>
                <?php
                    $object_id = $row["object_id"];
                    $sql2 = "SELECT name FROM object WHERE id=$object_id";
                    $rs_result2 = mysqli_query($link, $sql2);  
                    while ($row2 = mysqli_fetch_array($rs_result2)) {  
                ?>
                <label for="object">Object</label>
                <p class="form-input-txt"><?php echo $row2['name'];?></p>
                <?php 
                    }
                ?>
                <label for="description">Omschrijving</label>
                <textarea style="height: 100px;" class="form-input-txt" type="text" name="description"><?php echo $row['description'];?></textarea>
                <label for="status">Status</label>
                <select class="form-input-slct" name="status" id="status">
                <?php 
                    $currentStatus = $row['status'];
                    $sql4 = "SELECT name FROM status_type WHERE id=$currentStatus";
                    $rs_result4 = mysqli_query($link, $sql4);  
                    while ($row4 = mysqli_fetch_array($rs_result4)) {  
                ?>
                    <option name="status_old"><?php echo $row4["name"];?></option>
                    <?php
                    }
                    ?>
                <?php
                    $sql3 = "SELECT * FROM status_type";
                    $rs_result3 = mysqli_query($link, $sql3);  
                    while ($row3 = mysqli_fetch_array($rs_result3)) {  
                ?>
                    <option value="<?php echo $row3['id']; ?>"><?php echo $row3['name']; ?></option>
                <?php
                    }
                ?>
                <script>
                    $("#status option[value='<?php echo $row["status"];?>']").each(function() {
                        $(this).remove();
                    });
                </script>
                
                </select>
                <label for="name">Werknemer</label>
                <?php
                    if (isset($row['user'])) {
                        $currentUser = $row['user'];
                        $sql5 = "SELECT username FROM users WHERE id=$currentUser";
                        $rs_result5 = mysqli_query($link, $sql5);  
                        while ($row5 = mysqli_fetch_array($rs_result5)) {  
                    ?>
                    <p style="height: 30px;" class="form-input-txt"><?php echo $row5['username'];?></p>
                    <?php
                        }
                    }
                ?>
                <p style="height: 30px;" class="form-input-txt"></p>
                    
                <input class="form-button" type="submit" name="updateTicket" value="Opslaan">
                <input style="margin-top: 1rem;" class="form-button-red" type="submit" name="deleteTicket" value="Verwijder">
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