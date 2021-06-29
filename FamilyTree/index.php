<html>
<link rel="stylesheet" type="text/css" href="ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="ddsmoothmenu-v.css" />
<link rel="stylesheet" type="text/css" href="custom.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="ddsmoothmenu.js"></script>

<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	customtheme: ["#1c5a80", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	customtheme: ["#804000", "#1c5a80"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>
<?php
// error_reporting(1);
include_once("database.php");
$sql = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_parent_id.",".cl_spouse_name." FROM ".tb_member." WHERE ".cl_parent_id." IS NULL ORDER BY ".cl_parent_id.",".cl_member_id." ASC;";
$items_m = $dbObj->executeQuery($sql,"index-fetch");
// $items_v = executeQuery($sql,"index-fetchV");
// echo "Parent=".mysqli_num_rows($items_m);

function submenu_h($member_id,$dbObj)
{
	$sql_submh = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id."=$member_id ORDER BY ".cl_parent_id.",".cl_member_id." ASC;";
	$rs_submh = $dbObj->executeQuery($sql_submh,"index-submh");
	// echo $sql_submh;
	// echo mysqli_num_rows($rs_submh);
	if(mysqli_num_rows($rs_submh)>0)
	{
		?><ul><?php
		while($row_submh=mysqli_fetch_array($rs_submh))
		{
			// print_r($row_submh);
			?>			
            	<li>
                	 <a href="update.php?m_id=<?php echo $row_submh[cl_member_id]; ?>"><?php echo $row_submh[cl_first_name]." & ".$row_submh[cl_spouse_name];?></a>
                    <?php
					if(submenu_h($row_submh[cl_member_id],$dbObj)=="")
					{
						?></li><?php
					}
				?>                         
			<?php
		}
		?></ul><?php
	}
}

/* function submenu_v($member_id,$dbObj)
{
	$sql_2 = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id."=$member_id ORDER BY ".cl_parent_id.",".cl_member_id." ASC;";
	$items_2 = $dbObj->executeQuery($sql_2,"index-submv");
	
	if(mysqli_num_rows($items_2)>0)
	{
		?><ul><?php
		while($row_2=mysqli_fetch_array($items_2))
		{
			?>			
            	<li>
                	 <a href="update.php?m_id=<?php echo $row_2['member_id']; ?>"><?php echo $row_2['first_name']?></a>
                    <?php
					if(submenu_v($row_2['member_id'],$dbObj)=="")
					{
						?></li><?php
					}
				?>                         
			<?php
		}
		?></ul><?php
	}
} */
?>
<div id="links" class="hypLinks"><a href="tree.html">Family Tree</a>&nbsp;&nbsp;<a href="add_member.php">Add New Member</a><br /></div>
<h2 style="padding-top: 2px; padding-bottom:2px">Family Tree</h2>

<div id="smoothmenu1" class="ddsmoothmenu">
<ul>
<?php
while($row = mysqli_fetch_array($items_m))
{
	// print_r($row);
	?>
    	<li><a href="update.php?m_id=<?php echo $row[cl_member_id]; ?>"><?php echo $row[cl_first_name]." & ".$row[cl_spouse_name]?></a>
		<?php
        if(submenu_h($row[cl_member_id],$dbObj)=="")
        {
            ?></li><?php
        }
}
?>
</ul>
<br style="clear: left" />
</div>


<!-- <h2 style="margin-top:200px">Vertical </h2>

<div id="smoothmenu2" class="ddsmoothmenu-v"><ul>
<?php ?><?php
/* while($row_v = mysqli_fetch_array($items_v))
{ */
	?>
    	<li><a href="update.php?m_id=<?php //echo $row_v['member_id']; ?>"><?php //echo $row_v['first_name']?></a>
		<?php
        // if(submenu_v($row_v['member_id'],$link)=="")
        // {
            ?></li><?php
        // }
//}
?><?php?>
</ul>
</div> -->