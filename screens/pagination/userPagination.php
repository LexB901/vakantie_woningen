<?php
include('../../config.php');
global $link;
$limit = 5;

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

$sql = "SELECT * FROM users ORDER BY id ASC LIMIT $start_from, $limit";
$rs_result = mysqli_query($link, $sql);
?>
<div style="display: flex; justify-content: center; align-items: center; position: relative; width: 100%;">
    <h3 style="text-align: center;">Gebruikers</h3>
    <div style="position: absolute; right: 0;">
        <a href="../auth/register">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48" style=" fill:#000000;">
                <path fill="#000" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
                <path fill="#fff" d="M21,14h6v20h-6V14z"></path>
                <path fill="#fff" d="M14,21h20v6H14V21z"></path>
            </svg>
        </a>
    </div>
</div>
<div class="table">
    <div class="table-head" style="text-align: center; border-bottom: 3px solid black; word-wrap: break-word;">
        <div class="td-class" style="width:50%;">Gebruikersnaam</div>
        <div class="td-class" style="width:50%;">Rol</div>
    </div>
</div>
<div class="table" style="border-bottom: 1px solid black; height: 16px;">

    <?php
    while ($row = mysqli_fetch_array($rs_result)) {
    ?>
        <a class="table-row" href="edit-user?id=<?php echo $row['id']; ?>">
            <div style="width: 45%;" class="td-class"><?php echo $row["username"]; ?></div>
            <div style="width: 45%;" class="td-class">
                <?php
                if ($row["role_id"] == 3) {
                    echo "Beheerder";
                } elseif ($row["role_id"] == 2) {
                    echo "Admin";
                } elseif ($row["role_id"] == 1) {
                    echo "Werknemer";
                }
                ?>
            </div>
        </a>
    <?php
    };
    ?>
</div>