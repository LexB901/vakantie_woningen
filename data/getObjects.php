<?php

    // Include config.php file
    require_once "../config.php";

    $dataList = mysqli_query($link, "SELECT * FROM `object`");


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

            $object[$i] = $item;
            $i++;
        }
        echo json_encode($object);
    }

?>