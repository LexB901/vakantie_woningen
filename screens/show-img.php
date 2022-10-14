<?php
include('../config.php');
GLOBAL $link;


  
$sql = "SELECT * FROM object_image ";  
$rs_result = mysqli_query($link, $sql);  
?>



<?php  
while ($row = mysqli_fetch_array($rs_result)) {  
?>  
    <img src="<?php echo $row["object_id"];?>">
    <img src="<?php echo $row["hoofd_img"];?>">
    <img src="<?php echo $row["img_1"];?>">
    <img src="<?php echo $row["img_2"];?>">
    <img src="<?php echo $row["img_3"];?>">
    <img src="<?php echo $row["img_4"];?>">
<?php  
};  
?>
</div>

