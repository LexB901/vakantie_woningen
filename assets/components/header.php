<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
.navbarFirst {
  overflow: hidden;
  background-color: #0C5E34;
  height: 80px;

}

.navDropdown-content label{
  margin-bottom: 0;
  display: inline;
  margin-left: 4px;
}

.navbarFirst a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}
.navContain{
  display: flex;
  height: 80px;
}
.navSearchBtn{
width: 100px;
height: 35px;
margin: 10px;
margin-top: 22px;
top: 25px;
border : none;
background: #00A651;
color: white;
}
#navSubmitFilter{
  background: #00A651;
  border : none;
  padding: 5px;

}
.navCategories {
  justify-content: center;
  display: flex;
}
#navFilterMenu button{
  border: none;
  padding: 5px;
}

#navFilterMenu select{
  width: 80%;
  padding: 5px;
}

 
.navSearchInput{
  width: 30%;
  margin: 10px;
  margin-left: 20%;
  margin-top: 22px;
  height: 35px;
  border: none;
  top: 25px;
  font-size:8pt;
}
#navSubmitFilter{
  width: 40%;
}



.size{
  height: 100%;
  width:100%
}
.logo{
 height: 100%; 
}

@media screen and (max-width: 600px) {
  .navDropdown-content {
    padding: 0px;
  }
  .column{
    display: flex;
    flex-direction: column;
    padding: 1px;
  }
  .navDropdown-content input{
    width: 8px;
  }
  .navDropdown-content {

  right: 10px;
  padding: 5px;
    font-size: 7px;

  }


 #navSubmitFilter{
  width :35px;
  height:20px;
  font-size: 8px;
  }
  

}

@media screen and (max-width: 800px) {
    .navSearchBtn{
    width: 20%;
    height: 30px;
    font-size: 10px;
    max-width: 80px;
    cursor: pointer;

  }
  .navDropdown-content{

  right: 10px;

  }
  .logo{
 height: 100%; 
 width: 35%;
  }
}


.navSearchInput{
  width: 50%;
  margin-left: 15%;
  height: 30px;
}



#navFilterMenu{
width: 50%;
height: 90%;
padding: 10px;
border:  black 1px solid;

background-color: #0C5E34;

}


#navFilterHeader{
  text-align: center;
}




.center{
  text-align: center;
}


.line{
 width: 100%;
 height : 1px;
 background-color: grey;

}








.navDropdown {

    font-size: 85%;

  float: left;

  height: 3px;
  margin: 10px;
  margin-top: 22px;
  border:none;
}

.navDropbtn {

  cursor: pointer;
  font-size: 16px; 
  border: none;
  width: 30px;
  height: 30px;
  outline: none;
  color: white;
  background: #00A651;
  font-family: inherit;
  margin: 0;  
}



.navDropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  MAX-width: 21%;
    MIN-WIDTH: 10%;
  padding: 10px;

}



.dropdown-content a:hover {
  background-color: #ddd;
}

.show {
  display: block;
}
.column{
  display: flex;
  flex-direction: column;
  padding: 2%;
}


</style>
<?php

require_once "../config.php";


$dataListEigenschapen = mysqli_query($link, "SELECT * FROM `attribute` where property_id=1");
$dataListliggingen = mysqli_query($link, "SELECT * FROM `attribute` where property_id=2");



if (mysqli_num_rows($dataListEigenschapen) > 0){
  $i = 0;

  while($data = mysqli_fetch_array($dataListEigenschapen)){
      $item = new stdClass();
      $item->id = $data['id'];
      $item->name = $data['name'];

      $checkboxFiltersE[$i] = $item;
      $i++;
  }
}   

if (mysqli_num_rows($dataListliggingen) > 0){
  $i = 0;

  while($data = mysqli_fetch_array($dataListliggingen)){
      $item = new stdClass();
      $item->id = $data['id'];
      $item->name = $data['name'];

      $checkboxFiltersL[$i] = $item;
      $i++;
  }
}   


?>
<div class="navbarFirst" id="mynavbar">

  <div class="navContain">
    <img class="logo" src="../assets/components/img/vrijwonen_makelaar.png"/>
    <input class="navSearchInput" type="text" placeholder="Type hier om specifiek te zoeken...">
    <div class="navDropdown">
      <button id="navFilterBtn" class="navDropbtn" onclick=""><img class="size" src="../assets/components/img/settings.png"  /></button>
      <div class="navDropdown-content" id="myDropdown">
        <div class="center">
        <div class="huis_naam">
        <?php
            
                ?>

        </div>

        </div>
        <div class="line"></div>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div class="ligging column">
        <label>ligging</label>
        <?php
          foreach($checkboxFiltersL as $checkboxFilter) {?>
            <span><input type="checkbox" id="<?php echo $checkboxFilter->id ?>" <?php if(isset($_POST[$checkboxFilter->id])) echo "checked='checked'"; ?> name="<?php echo $checkboxFilter->id ?>" value="<?php echo $checkboxFilter->id ?>"><label for="<?php echo $checkboxFilter->id ?>"> <?php echo $checkboxFilter->name ?> </label> </span>
          <?php }?>
      </div>
      <div class="eigenschapen column">
        <label>eigenschapen</label>
        <?php
          foreach($checkboxFiltersE as $checkboxFilter) { ?>
            <span><input type="checkbox" id="<?php echo $checkboxFilter->id ?>" <?php if(isset($_POST[$checkboxFilter->id])) echo "checked='checked'"; ?> name="<?php echo $checkboxFilter->id ?>" value="<?php echo $checkboxFilter->id ?>"><label for="<?php echo $checkboxFilter->id ?>"> <?php echo $checkboxFilter->name ?> </label> </span>
          <?php } ?>
      </div>

      </div>
    </div>
    <button class="navSearchBtn">search</button>
    </form>

  </div>

</div>

<script>
var filterBtn = document.getElementById("navFilterBtn");
filterBtn.addEventListener("click", function(){
  document.getElementById("myDropdown").classList.toggle("show");
});



</script>














