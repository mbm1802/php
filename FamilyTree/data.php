<?php
include_once("database.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$sql_fetch="SELECT * FROM ".tb_member." ORDER BY ".cl_member_id.";";
$result = $dbObj->executeQuery($sql_fetch,"tree-fetch");
$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"memberId":"'  . $rs["member_id"] . '",';
    $outp .= '"parentId":"'   . $rs["parent_id"] . '",';
    $outp .= '"first_name":"'   . $rs["first_name"] . '",';
    $outp .= '"last_name":"'   . $rs["last_name"] . '",';
    $outp .= '"member_img":"'. $rs["member_img"]  . '"}'; 
}
$outp .="]";

// $conn->close();

echo($outp);
?>
