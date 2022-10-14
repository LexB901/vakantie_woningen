<?php
session_start();

require_once "../config.php";
GLOBAL $link;

if(isset($_SESSION["loggedin"])){
} else {
    header("Location: ../Auth/login");
}

$id = $_SESSION["id"];

$sql = "SELECT role_id FROM users WHERE id = $id";
$result = $link->query($sql);
$limit = 5;    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vrij Wonen | Adminpaneel</title>
    <?php include "../assets/components/header-meta.php"; ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .form-delete {
            width: 100%; 
            height: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center;
        }

        .form-delete-btn {

        }
        .table a {
            color: black;
        }

        .table a:hover {
            color: black;
            text-decoration: none;
        }
        td {
            line-height: 20px;
        }
        .td-class {
            text-align: center; 
            padding: 10px 0;
            line-height: 16px;
            display: table-cell;
        }

        .table { 
            display: table; 
            margin-bottom: 0;
        }

        .table-head { 
            display:table-row;
            background-color: white;
            font-weight: bold;
        }

        .table-row { 
            display: table-row;
        }

        .table-div {
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            margin: 2rem; width: auto; 
            align-items: center;
        }

        .text-wrap {
            width: 100%;
            word-wrap: break-word;
            overflow: hidden;
        }

        .items {   
            display: inline-block;   
        }   
        .items a {     
            color: black;   
            float: left;   
            padding: 0px 8px;   
            text-decoration: none;   
            border:1px solid black;  
            margin: 2px; 
        }   
        .items a.active {   
            background-color: rgb(255, 193, 7,.5);
        }
        .items a.active:hover {   
            background-color: rgb(255, 193, 7,.9);
        }   
        .items a:hover:not(.active) {  
            background-color: rgb(255, 193, 7,.9);
        }

        .showMore {

        }

        .showMore:hover {
            cursor: pointer;
        }
        
        .showLess {
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .showLess:hover {
            cursor: pointer;
        }

        .display-none {
            display: none;
        }

        .flex-row {
            position: relative;
            display: flex;
            flex-direction: row;
        }
        
        .height-18 {
            height: 18px;
        }

        .height-auto {
            height: auto;
        }

        tr:nth-child(odd) {
            background-color: #0C5E34;
        }

        tr:nth-child(even) {
            background: #00A651;
        }

        .table-row:nth-child(odd) {
            background-color: #0C5E34;
        }

        .table-row:nth-child(even) {
            background: #00A651;
        }

        .clearfix {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
        }

        .page-link {
            color: black;
        }

        .pagination>.active10>a,.pagination>.active10>a:focus,.pagination>.active10>a:hover,.pagination>.active10>span,.pagination>.active10>span:focus,.pagination>.active10>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .pagination>.active11>a,.pagination>.active11>a:focus,.pagination>.active11>a:hover,.pagination>.active11>span,.pagination>.active11>span:focus,.pagination>.active11>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .pagination>.active12>a,.pagination>.active12>a:focus,.pagination>.active12>a:hover,.pagination>.active12>span,.pagination>.active12>span:focus,.pagination>.active12>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .pagination>.active13>a,.pagination>.active13>a:focus,.pagination>.active13>a:hover,.pagination>.active13>span,.pagination>.active13>span:focus,.pagination>.active13>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

     

    </style>
    <script>
    </script>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
    include "../assets/components/secondHeader.php"; 


    while($row = $result->fetch_assoc()) {
    $roleId = $row["role_id"];
    if ($roleId == 3) {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <?php
        $sql10 = "SELECT COUNT(id) FROM object";  
        $rs_result10 = mysqli_query($link, $sql10);  
        $row = mysqli_fetch_row($rs_result10);  
        $total_records10 = $row[0];  
        $total_pages10 = ceil($total_records10 / $limit); 
        ?>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
         <div class="table-div" id="objecten">
             <div class="table">
                 <div id="target-content10">loading...</div>
                 <div class="clearfix">
                     <ul class="pagination">
                         <?php 
                         if(!empty($total_pages10)){
                             for($i=1; $i<=$total_pages10; $i++){
                                 if($i == 1){
                                     ?>
                                 <li class="pageitem10 active10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" data-dd="<?php echo $i;?>" class="page-link10" ><?php echo $i;?></a></li>
                                     <?php 
                                 } else {
                                     ?>
                                 <li class="pageitem10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" class="page-link10" data-dd="<?php echo $i;?>"><?php echo $i;?></a></li>
                                     <?php
                                 }
                             }
                         }
                         ?>
                     </ul>
                 </div>
             </div>
         </div>
         <script>
             $(document).ready(function() {
                 $("#target-content10").load("pagination/objectPagination?page=1");
                 $(".page-link10").click(function(){
                     var id = $(this).attr("data-dd");
                     var select_id = $(this).parent().attr("id");
                     $.ajax({
                         url: "pagination/objectPagination",
                         type: "GET",
                         data: {
                             page : id
                         },
                         cache: false,
                         success: function(dataResult){
                             $("#target-content10").html(dataResult);
                             $(".pageitem10").removeClass("active10");
                             $("#"+select_id).addClass("active10");
                            
                         }
                     });
                 });
             });
         </script>           

        <?php
        $sql11 = "SELECT COUNT(id) FROM attribute";  
        $rs_result11 = mysqli_query($link, $sql11);  
        $row = mysqli_fetch_row($rs_result11);  
        $total_records11 = $row[0];  
        $total_pages11 = ceil($total_records11 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="attributen">
            <div class="table">
                <div id="target-content11">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages11)){
                            for($x=1; $x<=$total_pages11; $x++){
                                if($x == 1){
                                    ?>
                                <li class="pageitem11 active11" id="num2<?php echo $x;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $x;?>" class="page-link11" ><?php echo $x;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem11" id="num2<?php echo $x;?>"><a href="JavaScript:Void(0);" class="page-link11" data-id="<?php echo $x;?>"><?php echo $x;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content11").load("pagination/attributePagination?page=1");
                $(".page-link11").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/attributePagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content11").html(dataResult);
                            $(".pageitem11").removeClass("active11");
                            $("#"+select_id).addClass("active11");
                            
                        }
                    });
                });
            });
        </script>


        <?php
        $sql12 = "SELECT COUNT(id) FROM users";  
        $rs_result12 = mysqli_query($link, $sql12);  
        $row = mysqli_fetch_row($rs_result12);  
        $total_records12 = $row[0];  
        $total_pages12 = ceil($total_records12 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="users">
            <div class="table">
                <div id="target-content12">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages12)){
                            for($y=1; $y<=$total_pages12; $y++){
                                if($y == 1){
                                    ?>
                                <li class="pageitem12 active12" id="num3<?php echo $y;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $y;?>" class="page-link12" ><?php echo $y;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem12" id="num3<?php echo $y;?>"><a href="JavaScript:Void(0);" class="page-link12" data-id="<?php echo $y;?>"><?php echo $y;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content12").load("pagination/userPagination?page=1");
                $(".page-link12").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/userPagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content12").html(dataResult);
                            $(".pageitem12").removeClass("active12");
                            $("#"+select_id).addClass("active12");
                            
                        }
                    });
                });
            });
        </script>

        <?php
        $sql13 = "SELECT COUNT(id) FROM ticket";  
        $rs_result13 = mysqli_query($link, $sql13);  
        $row = mysqli_fetch_row($rs_result13);  
        $total_records13 = $row[0];  
        $total_pages13 = ceil($total_records13 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="users">
            <div class="table">
                <div id="target-content13">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages13)){
                            for($n=1; $n<=$total_pages13; $n++){
                                if($n == 1){
                                    ?>
                                <li class="pageitem13 active13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $n;?>" class="page-link13" ><?php echo $n;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" class="page-link13" data-id="<?php echo $n;?>"><?php echo $n;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content13").load("pagination/ticketPagination?page=1");
                $(".page-link13").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/ticketPagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content13").html(dataResult);
                            $(".pageitem13").removeClass("active13");
                            $("#"+select_id).addClass("active13");
                            
                        }
                    });
                });
            });
        </script>
    <?php
    } elseif ($roleId == 2) {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <?php
        $sql10 = "SELECT COUNT(id) FROM object";  
        $rs_result10 = mysqli_query($link, $sql10);  
        $row = mysqli_fetch_row($rs_result10);  
        $total_records10 = $row[0];  
        $total_pages10 = ceil($total_records10 / $limit); 
        ?>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
         <div class="table-div" id="objecten">
             <div class="table">
                 <div id="target-content10">loading...</div>
                 <div class="clearfix">
                     <ul class="pagination">
                         <?php 
                         if(!empty($total_pages10)){
                             for($i=1; $i<=$total_pages10; $i++){
                                 if($i == 1){
                                     ?>
                                 <li class="pageitem10 active10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" data-dd="<?php echo $i;?>" class="page-link10" ><?php echo $i;?></a></li>
                                     <?php 
                                 } else {
                                     ?>
                                 <li class="pageitem10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" class="page-link10" data-dd="<?php echo $i;?>"><?php echo $i;?></a></li>
                                     <?php
                                 }
                             }
                         }
                         ?>
                     </ul>
                 </div>
             </div>
         </div>
         <script>
             $(document).ready(function() {
                 $("#target-content10").load("pagination/objectPagination?page=1");
                 $(".page-link10").click(function(){
                     var id = $(this).attr("data-dd");
                     var select_id = $(this).parent().attr("id");
                     $.ajax({
                         url: "pagination/objectPagination",
                         type: "GET",
                         data: {
                             page : id
                         },
                         cache: false,
                         success: function(dataResult){
                             $("#target-content10").html(dataResult);
                             $(".pageitem10").removeClass("active10");
                             $("#"+select_id).addClass("active10");
                            
                         }
                     });
                 });
             });
         </script>   
         <?php
        $sql11 = "SELECT COUNT(id) FROM attribute";  
        $rs_result11 = mysqli_query($link, $sql11);  
        $row = mysqli_fetch_row($rs_result11);  
        $total_records11 = $row[0];  
        $total_pages11 = ceil($total_records11 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="attributen">
            <div class="table">
                <div id="target-content11">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages11)){
                            for($x=1; $x<=$total_pages11; $x++){
                                if($x == 1){
                                    ?>
                                <li class="pageitem11 active11" id="num2<?php echo $x;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $x;?>" class="page-link11" ><?php echo $x;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem11" id="num2<?php echo $x;?>"><a href="JavaScript:Void(0);" class="page-link11" data-id="<?php echo $x;?>"><?php echo $x;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content11").load("pagination/attributePagination?page=1");
                $(".page-link11").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/attributePagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content11").html(dataResult);
                            $(".pageitem11").removeClass("active11");
                            $("#"+select_id).addClass("active11");
                            
                        }
                    });
                });
            });
        </script> 
         <?php
        $sql13 = "SELECT COUNT(id) FROM ticket";  
        $rs_result13 = mysqli_query($link, $sql13);  
        $row = mysqli_fetch_row($rs_result13);  
        $total_records13 = $row[0];  
        $total_pages13 = ceil($total_records13 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="users">
            <div class="table">
                <div id="target-content13">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages13)){
                            for($n=1; $n<=$total_pages13; $n++){
                                if($n == 1){
                                    ?>
                                <li class="pageitem13 active13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $n;?>" class="page-link13" ><?php echo $n;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" class="page-link13" data-id="<?php echo $n;?>"><?php echo $n;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content13").load("pagination/ticketPagination?page=1");
                $(".page-link13").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/ticketPagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content13").html(dataResult);
                            $(".pageitem13").removeClass("active13");
                            $("#"+select_id).addClass("active13");
                            
                        }
                    });
                });
            });
        </script>       

         <?php
    } elseif ($roleId == 1) {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <?php
        $sql10 = "SELECT COUNT(id) FROM object";  
        $rs_result10 = mysqli_query($link, $sql10);  
        $row = mysqli_fetch_row($rs_result10);  
        $total_records10 = $row[0];  
        $total_pages10 = ceil($total_records10 / $limit); 
        ?>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
         <div class="table-div" id="objecten">
             <div class="table">
                 <div id="target-content10">loading...</div>
                 <div class="clearfix">
                     <ul class="pagination">
                         <?php 
                         if(!empty($total_pages10)){
                             for($i=1; $i<=$total_pages10; $i++){
                                 if($i == 1){
                                     ?>
                                 <li class="pageitem10 active10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" data-dd="<?php echo $i;?>" class="page-link10" ><?php echo $i;?></a></li>
                                     <?php 
                                 } else {
                                     ?>
                                 <li class="pageitem10" id="num<?php echo $i;?>"><a href="JavaScript:Void(0);" class="page-link10" data-dd="<?php echo $i;?>"><?php echo $i;?></a></li>
                                     <?php
                                 }
                             }
                         }
                         ?>
                     </ul>
                 </div>
             </div>
         </div>
         <script>
             $(document).ready(function() {
                 $("#target-content10").load("pagination/objectPagination?page=1");
                 $(".page-link10").click(function(){
                     var id = $(this).attr("data-dd");
                     var select_id = $(this).parent().attr("id");
                     $.ajax({
                         url: "pagination/objectPagination",
                         type: "GET",
                         data: {
                             page : id
                         },
                         cache: false,
                         success: function(dataResult){
                             $("#target-content10").html(dataResult);
                             $(".pageitem10").removeClass("active10");
                             $("#"+select_id).addClass("active10");
                            
                         }
                     });
                 });
             });
         </script>    
         <?php
        $sql13 = "SELECT COUNT(id) FROM ticket";  
        $rs_result13 = mysqli_query($link, $sql13);  
        $row = mysqli_fetch_row($rs_result13);  
        $total_records13 = $row[0];  
        $total_pages13 = ceil($total_records13 / $limit); 
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <div class="table-div" id="users">
            <div class="table">
                <div id="target-content13">loading...</div>
                <div class="clearfix">
                    <ul class="pagination">
                        <?php 
                        if(!empty($total_pages13)){
                            for($n=1; $n<=$total_pages13; $n++){
                                if($n == 1){
                                    ?>
                                <li class="pageitem13 active13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" data-id="<?php echo $n;?>" class="page-link13" ><?php echo $n;?></a></li>
                                    <?php 
                                } else {
                                    ?>
                                <li class="pageitem13" id="num4<?php echo $n;?>"><a href="JavaScript:Void(0);" class="page-link13" data-id="<?php echo $n;?>"><?php echo $n;?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#target-content13").load("pagination/ticketPagination?page=1");
                $(".page-link13").click(function(){
                    var id = $(this).attr("data-id");
                    var select_id = $(this).parent().attr("id");
                    $.ajax({
                        url: "pagination/ticketPagination",
                        type: "GET",
                        data: {
                            page : id
                        },
                        cache: false,
                        success: function(dataResult){
                            $("#target-content13").html(dataResult);
                            $(".pageitem13").removeClass("active13");
                            $("#"+select_id).addClass("active13");
                            
                        }
                    });
                });
            });
        </script>  
        <?php
    }
}
    

    include "../assets/components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
       
    </script>
</body>
</html>