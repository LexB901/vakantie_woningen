<?php
    // Initialize the session
    session_start();


    // Include config.php file
    require_once "../config.php";

    $dataList = mysqli_query($link, "SELECT * FROM `object_image` LEFT JOIN `object` ON `object_image`.`object_id` = `object`.`id`;");


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

            $objects[$i] = $item;
            $objectsFilterList[$i] = $item;
            $i++;
        }
    }

    function substrwords($text, $maxchar, $end='...') {
        if (strlen($text) > $maxchar || $text == '') {
            $words = preg_split('/\s/', $text);      
            $output = '';
            $i      = 0;
            while (1) {
                $length = strlen($output)+strlen($words[$i]);
                if ($length > $maxchar) {
                    break;
                } 
                else {
                    $output .= " " . $words[$i];
                    ++$i;
                }
            }
            $output .= $end;
        } 
        else {
            $output = $text;
        }
        return $output;
    }

    // Filtersysteem
    $filterList = mysqli_query($link, "SELECT * FROM `attribute`");
    $filterNumbers = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        while($dataFilter = mysqli_fetch_array($filterList)){
            if (isset($_POST[$dataFilter["id"]])) {
                $objects = [];

                $attributeId = $dataFilter["id"];
                array_push($filterNumbers, $attributeId);
            } else {
            // echo "Uit";
            }
        }
        if (count($filterNumbers) > 0) {
            $List = implode(', ', $filterNumbers);
            foreach($objectsFilterList as $objectFilter) {
                $dataFilterAttributeList = mysqli_query($link, "SELECT *, COUNT(`attribute_id`) AS NumberOfFilters FROM object_attribute WHERE object_id = $objectFilter->id AND `status` = 1 AND attribute_id in ($List);");
                while($dataFilterAttribute = mysqli_fetch_array($dataFilterAttributeList)){
                    if (count($filterNumbers) == $dataFilterAttribute["NumberOfFilters"]) {
                        $dataList = mysqli_query($link, "SELECT * FROM `object_image` LEFT JOIN `object` ON `object_image`.`object_id` = `object`.`id`;");
                        while($data = mysqli_fetch_array($dataList)){
                            if ($data["id"] === $dataFilterAttribute["object_id"]) {
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
                    
                                $objects[$i] = $item;
                                $i++;
                            }
                        }
    
                    }
                }
               
            }
        }
        
        

    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepagina</title>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
  </head>

    <script>
        function volgende() {
            let bericht = document.querySelectorAll('#objects>#items');
            for (let i = 0; i < bericht.length; i++) {
                if (bericht[i].style.display != 'none') {
                    bericht[i].style.display = 'none';
                    if (i == bericht.length - 1) {
                        bericht[0].style.display = 'block';
                    } else {
                        bericht[i + 1].style.display = 'block';
                    }
                    break;
                }
            }      
        }

        function vorige() {
            let bericht = document.querySelectorAll('#objects>#items');
            for (let i = 0; i < bericht.length; i++) {
                if (bericht[i].style.display != 'none') {
                    bericht[i].style.display = 'none';
                    if (i == 0) {
                        bericht[bericht.length - 1].style.display = 'block';
                    } else {
                        bericht[i - 1].style.display = 'block';
                    }
                    break;
                }
            }      
        }
    </script>

  <body class="d-flex flex-column min-vh-100">
    <?php include_once "../assets/components/header.php" ?>
    <div class="main">
        <div id="objects" class="objects">
<!-- 
            <script>

                const xhttp = new XMLHttpRequest();
                xhttp.onload = function() {
                    data = this.responseText;

                    data = JSON.parse(data);

                    // document.write('<div class="item"><div class="item-afbeelding"><img src="../assets/img/woningen/woning 1/hoofd.jpg"></div><div class="item-info"><div class="item-top"><div class="item-title">Roompot Vakanties Bungalowpark Schin op Geul</div><div class="item-adres">Walem 1, 6342 PA Walem</div></div><div class="item-beschrijving">Beeld je alvast eens in: het kalmerende geluid van watervogels, in de verte tikt een lijn tegen een mast, de ondergaande zon die nog even over het water voor je tuinterras schijnt. Vanaf het terras zie je dat je sloep of zeilboot tevreden aan je eigen steiger ligt; morgen is er weer een dag.</div><div class="item-bottom"><div class="item-prijs">€ 550.000</div><div class="item-link">Interesse? Klik hier!</div></div></div></div>');
                    document.write('<div class="item">');
                        document.write('<div class="item-afbeelding"><img src="../assets/img/woningen/woning 1/hoofd.jpg"></div>');
                        document.write('<div class="item-info">');
                            document.write('<div class="item-top">');
                                document.write('<div class="item-title">Roompot Vakanties Bungalowpark Schin op Geul</div>');
                                document.write('<div class="item-adres">Walem 1, 6342 PA Walem</div>');
                            document.write('</div>');
                            document.write('<div class="item-beschrijving">Beeld je alvast eens in</div>');
                            document.write('<div class="item-bottom">');
                                document.write('<div class="item-prijs">€ 550.000</div>');
                                document.write('<div class="item-link">Interesse? Klik hier!</div>');
                            document.write('</div>');
                        document.write('</div>');
                    document.write('</div>');
                    
                }
                xhttp.open("GET", "/data/getObjects");
                xhttp.send();

            </script> -->

            <div id="items">

                <?php
                    if (count($objects) > 0) {
                        foreach($objects as $object) {
                            echo '
                            <div class="item">
                                <div class="item-afbeelding"><img src="'. $object->hoofd_img .'"></div>
                                <div class="item-info">
                                    <div class="item-top">
                                        <div class="item-title">'. $object->name .'</div>
                                        <div class="item-adres">'. $object->street . ' ' . $object->housenumber . ', ' . $object->postalcode . ' ' . $object->city .'</div>
                                    </div>
                                    <div class="item-beschrijving">'. substrwords($object->description,300) .'</div>
                                    <div class="item-bottom">
                                        <div class="item-prijs">€ '. number_format( $object->price, 0, '', '.' ) .'</div>
                                        <a href="woning?id='. $object->id .'" class="item-link">Interesse? Klik hier!</a>
                                    </div>
                                </div>
                            </div>
                            ';
                          }
                    } else {
                        echo '<p style="text-align:center;">Geen resultaten beschikbaar.</p>';
                    }
                    
                ?>
            </div>

            <!-- <div id="items" style="display:none;">
                <div class="item">
                    <div class="item-afbeelding"><img src="assets/img/woningen/woning 2/hoofd.jpg"></div>
                    <div class="item-info">
                        <div class="item-top">
                            <div class="item-title">Roompot Vakanties Bungalowpark Schin op Geul</div>
                            <div class="item-adres">Walem 1, 6342 PA Walem</div>
                        </div>
                        <div class="item-beschrijving">Beeld je alvast eens in: het kalmerende geluid van watervogels, in de verte tikt een lijn tegen een mast, de ondergaande zon die nog even over het water voor je tuinterras schijnt. Vanaf het terras zie je dat je sloep of zeilboot tevreden aan je eigen steiger ligt; morgen is er weer een dag.</div>
                        <div class="item-bottom">
                            <div class="item-prijs">€ 550.000</div>
                            <div class="item-link">Interesse? Klik hier!</div>
                        </div>
                    </div>
                </div>
    
                <div class="item">
                    <div class="item-afbeelding"><img src="assets/img/woningen/woning 1/hoofd.jpg"></div>
                    <div class="item-info">
                        <div class="item-top">
                            <div class="item-title">Roompot Vakanties Bungalowpark Schin op Geul</div>
                            <div class="item-adres">Walem 1, 6342 PA Walem</div>
                        </div>
                        <div class="item-beschrijving">Beeld je alvast eens in: het kalmerende geluid van watervogels, in de verte tikt een lijn tegen een mast, de ondergaande zon die nog even over het water voor je tuinterras schijnt. Vanaf het terras zie je dat je sloep of zeilboot tevreden aan je eigen steiger ligt; morgen is er weer een dag.</div>
                        <div class="item-bottom">
                            <div class="item-prijs">€ 550.000</div>
                            <div class="item-link">Interesse? Klik hier!</div>
                        </div>
                    </div>
                </div>
    
                <div class="item">
                    <div class="item-afbeelding"><img src="assets/img/woningen/woning 4/hoofd.jpg"></div>
                    <div class="item-info">
                        <div class="item-top">
                            <div class="item-title">Roompot Vakanties Bungalowpark Schin op Geul</div>
                            <div class="item-adres">Walem 1, 6342 PA Walem</div>
                        </div>
                        <div class="item-beschrijving">Beeld je alvast eens in: het kalmerende geluid van watervogels, in de verte tikt een lijn tegen een mast, de ondergaande zon die nog even over het water voor je tuinterras schijnt. Vanaf het terras zie je dat je sloep of zeilboot tevreden aan je eigen steiger ligt; morgen is er weer een dag.</div>
                        <div class="item-bottom">
                            <div class="item-prijs">€ 550.000</div>
                            <div class="item-link">Interesse? Klik hier!</div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
        <!-- <div class="paging">
            <div class="arrow arrow-left" onclick="vorige()"><</div>
            <div class="page page-first"></div>
            <div class="page page-second"></div>
            <div class="page page-third"></div>
            <div class="arrow arrow-right" onclick="volgende()">></div>
        </div> -->
    </div>
    <?php include_once "../assets/components/footer.php" ?>
	<script src="index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".navSearchInput").keyup(function(){
        
                // Retrieve the input field text and reset the count to zero
                var filter = $(this).val(), count = 0;
        
                // Loop through the comment list
                $("#items .item").each(function(){
        
                    // If the list item does not contain the text phrase fade it out
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
        
                    // Show the list item if the phrase matches and increase the count by 1
                    } else {
                        $(this).show();
                        count++;
                    }
                });
        
                // Update the count
                // var numberItems = count;
                // $("#filter-count").text("Number of Comments = "+count);
            });
        });
    </script>
  </body>
</html>