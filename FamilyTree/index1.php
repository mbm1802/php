<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php
include_once("database.php");
echo "";
$sql_fetch="SELECT * FROM ".tb_member." ORDER BY ".cl_member_id.";";
$result = $dbObj->executeQuery($sql_fetch,"tree-fetch");
$row = mysqli_fetch_array($result);
print_r($row);
?>
</body>
<ol>
  <li>Coffee</li>
  <li>Tea</li>
  <li>Milk</li>
</ol>
<ul>
  <li>Coffee</li>
  <li>Tea</li>
  <li>Milk</li>
</ul>
</html>