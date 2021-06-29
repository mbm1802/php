<!DOCTYPE html>
<html lang="en">
<LINK href="custom.css" rel="stylesheet" type="text/css" />
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Family Tree - Print</title>
</head>
<body>
<?php
include_once("database.php");
// $sql_fetch="SELECT * FROM `".tb_member."` ORDER BY `".cl_member_id."`;";
// $result = $dbObj->executeQuery($sql_fetch,"tree-fetch");
// $row = mysqli_fetch_array($result);
// print_r($row);

$sql = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id." IS NULL ORDER BY ".cl_parent_id.",".cl_member_id." ASC;";
//echo $sql;
$rs_topmost = $dbObj->executeQuery($sql,"addm-sel");

function submenu_v($member_id,$dbObj)
{
	$sqlChildren = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id."=$member_id ORDER BY ".cl_parent_id.", ".cl_member_id." ASC;";
	$rs_children = $dbObj->executeQuery($sqlChildren,"print-sqlChildren");
	
	if(mysqli_num_rows($rs_children)>0)
	{
		?><ul><?php
		while($rowChild=mysqli_fetch_array($rs_children))
		{
			?>			
        <li><?php echo $rowChild[cl_first_name]; echo (($rowChild[cl_spouse_name]!=NULL)? " & ".$rowChild[cl_spouse_name]:"");if(submenu_v($rowChild[cl_member_id],$dbObj)=="") {?></li><?php
          }
		}
		?></ul><?php
	}
}
?>

<!-- <div id="printRoot" style="border:1px solid #09F;border-radius:10px;font-family: Arial, Helvetica, sans-serif;font-size: 13px;"> -->
<div id="printRoot" class="tree">
<!-- <table class="tree"> -->
<!-- <tr><td> -->
<ul>
<?php
while($row_topmost = mysqli_fetch_array($rs_topmost))
{
	?>
    	<li><?php echo $row_topmost[cl_first_name];echo (($row_topmost[cl_spouse_name]!=NULL)? " & ".$row_topmost[cl_spouse_name]:"");if(submenu_v($row_topmost[cl_member_id],$dbObj)=="") {?></li>
			<?php
        }
}
?>
</ul>
</div>
<!-- </td></tr></table> -->
</body>
</html>