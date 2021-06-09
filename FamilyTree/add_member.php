<html>

<link rel="stylesheet" type="text/css" href="ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="ddsmoothmenu-v.css" />
<LINK href="custom.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="ddsmoothmenu.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<?php
// error_reporting(0);
include_once("database.php");

if (isset($_GET['msg']))
	$messages=$_GET['msg'];
else
	$messages="";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	$parent_id		= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['parentid']));
	$first_name		= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['firstname']));	
	$last_name		= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['lastname']));
	$gender				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['gender']));
	$spouse_name	= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['spousename']));	
	$member_img		= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['memberimg']));
	if(!$parent_id || !$first_name)
	{
		header("location:add_member.php?msg=*Missing mandatory fields");
	}
	else
	{
		$sqlIns = "INSERT INTO  ".tb_member." (".cl_parent_id.",".cl_first_name.",".cl_last_name.",".cl_gender.",".cl_spouse_name.",".cl_member_img.") VALUES ('".$parent_id."','".$first_name."','".$last_name."','".$gender."','".$spouse_name."','".$member_img."');";
		//echo $sqlIns;exit;
		$dbObj->executeQuery($sqlIns,"ins-DB");
		header("location:add_member.php?msg=Added new member");
	}	
}

$sql = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id." IS NULL ORDER BY ".cl_parent_id.",".cl_member_id." ASC;";
//echo $sql;
$items_v = $dbObj->executeQuery($sql,"addm-sel");
//echo "here:".mysqli_num_rows($items_v);
?>

<div id="links" class="hypLinks"><a href="tree.html">Family Tree</a>&nbsp;&nbsp;<a href="index.php">View Member</a></div>
</br>
<div class="messages"><?php echo $messages; ?></div>
<form method="post">
<table width="30%" style="border:1px solid #09F;border-radius:10px;padding:10px;font-family: Arial, Helvetica, sans-serif;font-size: 12px;">
	<tr>
    	<Td width="50%" valign="top"><strong>Parent* :</strong></Td>
        <td>
<?php
function submenu_v($member_id,$dbObj)
{
	$sql_2 = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_spouse_name.",".cl_parent_id." FROM ".tb_member." WHERE ".cl_parent_id."=$member_id ORDER BY ".cl_parent_id.", ".cl_member_id." ASC;";
	$items_2 = $dbObj->executeQuery($sql_2,"addm-sel2");
	
	if(mysqli_num_rows($items_2)>0)
	{
		?><ul><?php
		while($row_2=mysqli_fetch_array($items_2))
		{
			?>			
            	<li>               	
                <a><input type="radio" name="parentid" id="parentid"  value="<?php echo $row_2['member_id'];?>" style="float:left"/>
                <?php echo $row_2['first_name']?></a>
                <?php
                if(submenu_v($row_2['member_id'],$dbObj)=="")
                {
                    ?></li><?php
                }				
		}
		?></ul><?php
	}
}
?>

<div id="smoothmenu2" class="ddsmoothmenu-v">
<ul>
<?php
while($row_v = mysqli_fetch_array($items_v))
{
	?>
    	<li>
        	<a>
            	<input type="radio" name="parentid" id="parentid"  value="<?php echo $row_v['member_id'];?>" style="float:left" />
				<?php echo $row_v['first_name']?>            </a>
		<?php
        if(submenu_v($row_v['member_id'],$dbObj)=="")
        {
            ?></li><?php
        }
}
?>
</ul>
</div>	</td>
   </tr>
   <tr>
   		<td><strong>First Name* :</strong></td>
        <td><input type="text" name="firstname" id="firstname" /></td>
   </tr>
   <tr>
   		<td><strong>Last Name :</strong></td>
        <td><input type="text" name="lastname" id="lastname" /></td>
   </tr>
   <tr>
     <td><strong>Gender* :</strong></td>
     <td><input type="radio" name="gender" <?php if (isset($gender) && $gender=="F") echo "checked";?> value="F">Female
		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="M") echo "checked";?> value="M">Male
		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="O") echo "checked";?> value="O">Other
	 </td>
   </tr>
   <tr>
     <td><strong>DOB</strong></td>
     <td><input type="date" id="mDOB" name="mDOB"></td>
   </tr>
   <tr>
     <td><strong>Date of demise</strong></td>
     <td><input type="date" id="mDOD" name="mDOD"></td>
   </tr>
   <tr>
     <td><strong>Spouse Name :</strong></td>
     <td><input type="text" name="spousename" id="spousename" /></td>
   </tr>
   <tr>
     <td><strong>Spouse's DOB</strong></td>
     <td><input type="date" id="sDOB" name="sDOB"></td>
   </tr>
   <tr>
     <td><strong>Spouse's date of demise</strong></td>
     <td><input type="date" id="sDOD" name="sDOD"></td>
   </tr>
   <tr>
   		<td><strong>Upload Image </strong></td>
        <td><input type="text" name="memberimg" id="memberimg" /></td>
   </tr>
   <tr>
   		<td colspan="2"><input type="submit" name="submit" value="Submit" class="btnPost" /></td>
   </tr>
</table>
</form>