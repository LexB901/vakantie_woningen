<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
a:hover {
  color: white;
}
.topnav {
  overflow: hidden;
  background-color: #0C5E34;
  
  height: 80px;
  color: black;
}
.topnav:hover{
  color: black;

}

.topnav a:hover {
  cursor: pointer;
 
}
.topnav a {
  float: right;
  height: 80px;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 30px 20px;
  text-decoration: none;
  font-size: 17px;
}
.backBtn{
    border: none;
    color: white;
    float: right;
}
.backBtn:hover{
  background: #00A651;
  cursor: pointer;

}

.logo{
 height: 100%; 
}

.logo-a{
  float: left !important;
  padding: 0 !important;
}



@media screen and (max-width: 800px) {
    .navSearchBtn{
    width: 20%;
    height: 30px;
    font-size: 10px;
    max-width: 80px;
      
  }
  .logo{
 height: 100%; 
}


}
</style>

<div class="topnav" id="myTopnav">
  <a class="logo-a" href="../screens/welcome">
    <img class="logo" src="../assets/components/img/vrijwonen_makelaar.png"/>
  </a>
  <a class="backBtn" onclick='history.back()' >terug</a>
</div>


