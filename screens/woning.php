<?php
// Initialize the session
require_once "../config.php";

session_start();
$id = $_GET['id'];

$dataList = mysqli_query($link, "SELECT * FROM `object` LEFT JOIN `object_image` ON `object`.`id` = `object_image`.`object_id` WHERE object.id = $id;");
$dataListAttribute = mysqli_query($link, "SELECT * FROM `object_attribute` WHERE object_id = $id AND `status` = 1;");

    if (mysqli_num_rows($dataList) > 0){
        $i = 0;

        while($data = mysqli_fetch_array($dataList)){
            $item = new stdClass();
            $item->id = $data['id'];
            $item->name = $data['name'];
            $item->description = $data['description'];
            $item->size = $data['size'];
            $item->price = $data['price'];
            $item->street = $data['street'];
            $item->city = $data['city'];
            $item->housenumber = $data['housenumber'];
            $item->postalcode = $data['postalcode'];
            $item->hoofd_img = $data['hoofd_img'];
            $item->img_1 = $data['img_1'];
            $item->img_2 = $data['img_2'];
            $item->img_3 = $data['img_3'];
            $item->img_4 = $data['img_4'];

            $i++;
        }

    }

    if (mysqli_num_rows($dataListAttribute) > 0){
        $i = 0;
        while($dataAttribute = mysqli_fetch_array($dataListAttribute)){
            $object_id = $dataAttribute['attribute_id'];
            $dataListAttributeName = mysqli_query($link, "SELECT * FROM `attribute` WHERE id = $object_id");
            $itemAttribute = new stdClass();
            $itemAttribute->attributeId = $dataAttribute['attribute_id'];
            $itemAttribute->object_id = $dataAttribute['object_id'];
            while($dataAttributeName = mysqli_fetch_array($dataListAttributeName)){
                $itemAttribute->attributeName = $dataAttributeName["name"];
            }


            $objects[$i] = $itemAttribute;
            

            $i++;
        }
    }

if(array_key_exists('newTicket', $_POST)) {
    newTicket();
}

function newTicket() {
    GLOBAL $link;

    $name = $_POST["fname"];
    $email = $_POST["email"];
    $object_id = $_GET["id"];

    $sql = "INSERT INTO ticket (object_id, name, email, status) VALUES ('$object_id', '$name', '$email', '1')";

    if ($link->query($sql) === TRUE) {
    } else {
        echo "Versturen van de data is mislukt!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../assets/components/header-meta.php"; ?>
    <title>Vrij Wonen | Objecten</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
</head>

<style>

/* Styling */

ul {
    padding-left: 20px;
}

.container_imgs {
    margin: 0 auto;
    margin-top: 7.5rem;
    display: grid;
    grid-template-areas:
    'big_img big_img big_img small_img small_img small_img'
    'big_img big_img big_img small_img small_img small_img'
    'big_img big_img big_img small_img small_img small_img';
    border-bottom: 2px solid rgba(0, 0, 0, 0.2);
    padding-bottom: 50px;
    margin-bottom: 15px;
}

.small_imgs {

}

.img_big {
    grid-area: big_img;
    margin-right: 5px;
}

.img_small {
    grid-area: small_img;
    margin-bottom: 5px;
}

.container_details {
    display: flex;
    margin: 0 auto;
    gap: 350px;
}

.container_brochure {
    border: 1px solid #C4C4C4;
    height: 375px;
    width: 300px;
    /* border-radius: 5px; */
    text-align:center;
}

.huis_naam {
    font-size: 20px;
    font-weight: 500;
}

.huis_plaats {
    font-weight: 300;
}

.huis_gegevens {
    display: flex;
    gap: 10px;
}

.container_omschrijving {
    margin-top: 20px;
}

.omschrijving_tekst {
    width:450px;
}

.container_kenmerken {
    margin-top: 20px;
}

.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 7.5px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.brochure_titel {
    padding-top: 7.5px;
    padding-bottom: 7.5px;
    background-color: #C4C4C4;
    /* border-radius: 4px 4px 0px 0px; */
    margin-bottom: 30px;
}

.formLabel {
    margin: 0;
}


</style>

<body class="d-flex flex-column min-vh-100">
    <?php include "../assets/components/secondHeader.php"; ?>

    <!-- content -->
    <div class="container_imgs">
        <img src="<?php echo $item->hoofd_img ?>" class="img_big" width="700" height="394">
        <div class="small_imgs">
            <img src="<?php echo $item->img_1 ?>" class="img_small" width="291.5" height="194.33">
            <img src="<?php echo $item->img_2 ?>" class="img_small" width="291.5" height="194.33">
            <br>
            <img src="<?php echo $item->img_3 ?>" class="img_small" width="291.5" height="194.33">
            <img src="<?php echo $item->img_4 ?>" class="img_small" width="291.5" height="194.33">
        </div>
    </div>

    <div class="container_details">
        <div class="container_gegevens">
            <div class="huis_naam"><?php echo($item->name) ?></div>
            <div class="huis_plaats"><?php echo("$item->street $item->housenumber, $item->postalcode $item->city") ?></div>
            <div class="huis_gegevens">
                <div class="huis_oppervlakte"><span title="wonen" data-test-kenmerken-highlighted-icon="" class="fd-color-dark-3 fd-m-right-2xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" role="img" viewBox="0 0 48 48"><path d="M38.5 32.25v-16.5a5 5 0 10-6.25-6.25h-16.5a5 5 0 10-6.25 6.25v16.5a5 5 0 106.25 6.25h16.5a5 5 0 106.25-6.25zm-6.25 3.25h-16.5a5 5 0 00-3.25-3.25v-16.5a5 5 0 003.25-3.25h16.5a5 5 0 003.25 3.25v16.5a5 5 0 00-3.25 3.25zM37 9a2 2 0 11-2 2 2 2 0 012-2zM11 9a2 2 0 11-2 2 2 2 0 012-2zm0 30a2 2 0 112-2 2 2 0 01-2 2zm26 0a2 2 0 112-2 2 2 0 01-2 2z"></path></svg></span><?php echo("$item->size") ?> m²</div>
                <!-- <div class="huis_bedden"><span title="slaapkamers" data-test-kenmerken-highlighted-icon="" class="fd-color-dark-3 fd-m-right-2xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" role="img" viewBox="0 0 48 48"><path d="M11 20l-3.999 5.999h33.998L37 20h3l3.999 5.999L44 26v9.5a1.5 1.5 0 01-1.5 1.5H39v1.5a1.5 1.5 0 01-3 0V37H12v1.5a1.5 1.5 0 01-3 0V37H5.5A1.5 1.5 0 014 35.5V26l.001-.001L8 20h3zm30 9H7v5h34v-5zM38.5 8A1.5 1.5 0 0140 9.5V20l-9-.001V21.5a1.5 1.5 0 01-1.5 1.5h-11a1.5 1.5 0 01-1.5-1.5v-1.501L8 20V9.5A1.5 1.5 0 019.5 8h29zM28 17h-8v3h8v-3zm9-6H11v5.999h6V15.5a1.5 1.5 0 011.5-1.5h11a1.5 1.5 0 011.5 1.5v1.499h6V11z"></path></svg></span> 3 slaapkamers</div> -->
                <div class="huis_prijs">€ <?php echo(number_format( $item->price, 0, '', '.' ));?></div>
            </div>
            <div class="container_omschrijving">
                <h5>Omschrijving</h5>
                <div class="omschrijving_tekst"><?php echo("$item->description") ?></div>
            </div>
            <div class="container_kenmerken">
                <h5>Kenmerken</h5>
                <ul>
                    <?php if (!empty($objects)) {?>
                        <?php foreach($objects as $object) {?>
                            <li><?php echo($object->attributeName);?></li>
                        <?php }?>
                    <?php } else {?>
                        <li>Geen informatie beschikbaar</li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="container_brochure">
            <h5 class="brochure_titel">Vakantiewoningen BV</h5>
            <a href="../screens/flyer?id=<?php echo("$id") ?>" target="_blank" class="button">Vraag brochure</a>
            <h6>Bezichtigen of een vraag?</h6>
            <form action="" method="post">
                <p class="formLabel">Naam:</p>
                <input type="text" id="fname" name="fname"><br><br>
                <p class="formLabel">Email:</p>
                <input type="email" id="email" name="email"><br><br>
                <input type="submit" class="button2" name="newTicket" value="Versturen">
            </form>
        </div>
    </div>

    <?php include "../assets/components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>