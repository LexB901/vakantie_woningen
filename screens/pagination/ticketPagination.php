<?php
include('../../config.php');
GLOBAL $link;
$limit = 5;  

if (isset($_GET["page"])) { 
    $page = $_GET["page"]; 
} else { 
    $page=1; 
};  
$start_from = ($page-1) * $limit;  
  

$sqlCount = "SELECT * FROM ticket ORDER BY updated_at DESC LIMIT $start_from, $limit";
$count_result = mysqli_query($link, $sqlCount);
$rows = mysqli_num_rows($count_result);
if($rows > 0){
    $sql = "SELECT * FROM ticket ORDER BY updated_at DESC LIMIT $start_from, $limit"; 
    $rs_result = mysqli_query($link, $sql);  
?>
    <div style="display: flex; justify-content: center; align-items: center; position: relative; width: 100%;">
        <h3 style="text-align: center;">Ticket</h3>
    </div>
    <div class="table">
        <div class="table-head" style="text-align: center; border-bottom: 3px solid black; word-wrap: break-word;">
            <div class="td-class" style="width:10%;">Naam</div>
            <div class="td-class" style="width:15%;">Email</div>
            <div class="td-class" style="width:15%;">Object</div>
            <div class="td-class" style="width:30%;">Omschrijving</div>
            <div class="td-class" style="width:10%;">Status</div>
            <div class="td-class" style="width:10%;">User</div>
            <div class="td-class" style="width:10%;">Bijgewerkt</div>
        </div>
    </div>
    <div class="table" style="border-bottom: 1px solid black; height: 16px;">

    <?php  
    while ($row = mysqli_fetch_array($rs_result)) {  
    ?>  
        <a class="table-row" href="edit-ticket?id=<?php echo $row['id']; ?>">
            <div style="width: 10%;" class="td-class"><?php echo $row["name"]; ?></div>
            <div style="width: 15%;" class="td-class"><?php echo $row["email"]; ?></div>
            <?php
                $object_id = $row["object_id"];
                $sql2 = "SELECT name FROM object WHERE id=$object_id";
                $rs_result2 = mysqli_query($link, $sql2);  
                while ($row2 = mysqli_fetch_array($rs_result2)) {  
            ?>
            <div style="width: 15%;" class="td-class"><?php echo $row2["name"]; ?></div>
            <?php 
                }
            ?>
            <div style="width: 30%;" class="td-class"><?php echo $row["description"]; ?></div>
            <?php
                $status_id = $row["status"];
                $sql3 = "SELECT name FROM status_type WHERE id=$status_id";
                $rs_result3 = mysqli_query($link, $sql3);  
                while ($row3 = mysqli_fetch_array($rs_result3)) {  
            ?>
            <div style="width: 10%;" class="td-class"><?php echo $row3["name"]; ?></div>
            <?php 
                }
                if (isset($row['user'])) {
                    $user_id = $row['user'];
                    $sql4 = "SELECT username FROM users WHERE id=$user_id";
                    $rs_result4 = mysqli_query($link, $sql4);  
                    while ($row4 = mysqli_fetch_array($rs_result4)) {  
                ?>
            <div style="width: 10%;" class="td-class"><?php echo $row4["username"]; ?></div>
                <?php
                    }
            
                } else {
                    ?>
            <div style="width: 10%;" class="td-class"></div>

                    <?php
                }
                ?>
            <div style="width: 10%;" class="td-class"><?php echo $row["updated_at"]; ?></div>
        </a> 
    <?php  
    };  
} else {
    echo "Er zijn geen tickets gevonden!";
}
?>
</div>

