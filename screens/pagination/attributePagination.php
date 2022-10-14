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

$sqlCount = "SELECT * FROM attribute ORDER BY id DESC LIMIT $start_from, $limit";
$count_result = mysqli_query($link, $sqlCount);
$rows = mysqli_num_rows($count_result);
if($rows > 0){
    $sql = "SELECT * FROM attribute ORDER BY id DESC LIMIT $start_from, $limit";  
    $rs_result = mysqli_query($link, $sql);  


    ?>
    <div style="display: flex; justify-content: center; align-items: center; position: relative; width: 100%;">
        <h3 style="text-align: center;">Attributen</h3>
        <div style="position: absolute; right: 0;">
            <a href="add-attribute">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    width="25" height="25"
                    viewBox="0 0 48 48"
                    style=" fill:#000000;"><path fill="#000" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#fff" d="M21,14h6v20h-6V14z"></path><path fill="#fff" d="M14,21h20v6H14V21z"></path></svg>
            </a>
        </div>
    </div>
    <div class="table">
        <div class="table-head" style="text-align: center; border-bottom: 3px solid black; word-wrap: break-word;">
            <div class="td-class" style="width:50%;">Naam</div>
            <div class="td-class" style="width:50%;">Ligging/Eigenschap</div>
        </div>
    </div>
    <div class="table" style="border-bottom: 1px solid black; height: 16px;">

    <?php  
    while ($row = mysqli_fetch_array($rs_result)) {  
    ?>  
        <a class="table-row" href="edit-attribute?id=<?php echo $row['id']; ?>">
            <div style="width: 50%;" class="td-class"><?php echo $row["name"]; ?></div>
            <div style="width: 50%;" class="td-class">
                <?php
                    if ($row["property_id"] == 1) {
                        echo "Eigenschap";
                    } elseif ($row["property_id"] == 2) {
                        echo "Ligging";
                    }
                ?>
            </div>
        </a>
        
    <?php  
    };  
} else {
    echo "Er zijn geen attributen gevonden!";
}
?>
</div>

