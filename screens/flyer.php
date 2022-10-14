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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Flyer Vakantiewoningen</title>
</head>
<script>
    window.addEventListener('load', function() {
        print();
    })
</script>
<style>
    body {
    font-family: sans-serif;
}

ul {
    /* list-style-type: none; */
    padding: 15px;
  }

.container {
    width: 1050px;
    /* background-color: red; */
    margin: auto;
}

.container_top {
    display: flex;
    justify-content: space-between;
}

.container_mid {
    display: flex;
    justify-content: space-between;
}

.img_head {
    height:590.63px;
    width:1050px;
}

.container_smallimg {
    display: inline-flex;
    flex-wrap: wrap;
}

.img_small {
    height: 172px;
    width: 258px;
    margin-right: 6px;
}

.last_img {
    margin-right: 0px;
}

.beschrijving {
    font-size: 18px;
}

</style>
<body>
    <div class="container">

        <div class="container_top">
            <div class="logo">
                <img src="../assets/components/img/vrijwonen_makelaar.png" width="303" height="166" alt="">
            </div>
            <div class="adres">
                <p class="bedrijfsnaam"><b>Vakantiewoningmakelaar Vrij Wonen</b></p>
                <p class="adres">Disketteweg 2</p>
                <p class="postcode">3815 AV Amersfoort</p>
                <p class="email">info@vrijwonen.nl</p>
                <p class="telnr">033-1122334</p>
            </div>
        </div>
        <div class="container_mid">
            <h1 class="titel"><b><?php echo($item->name) ?></b></h1>
            <h1 class="prijs"><b>€ <?php echo(number_format( $item->price, 0, '', '.' )) ?></b></h1>
        </div>
        <div class="container_img">
            <img src="<?php echo $item->hoofd_img ?>" class="img_head" alt="">
        </div>
        <div class="container_smallimg">
            <img src="<?php echo $item->img_1 ?>" class="img_small" alt="">
            <img src="<?php echo $item->img_2 ?>" class="img_small" alt="">
            <img src="<?php echo $item->img_3 ?>" class="img_small" alt="">
            <img src="<?php echo $item->img_4 ?>" class="img_small last_img" alt="">
        </div>
        <div class="container_desc">
            <p class="beschrijving"><?php echo("$item->description") ?></p>
        </div>
        <div class="container_details">
            <div class="eigenschappen">
                <p class="eigenschappen_titel"><b>Kenmerken</b></p>
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
            <!-- <div class="ligging">
                <p class="ligging_titel"><b>Ligging</b></p>
                <ul>
                    <li>In het bos</li>
                    <li>Dicht bij een stad</li>
                </ul>
            </div> -->
        </div>
    </div>

</body>
</html>