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

// alert  - popup
function delete_box(val,page,id)
	{
			if(val=="Delete")
			{
				var conBox = confirm("Do you want to delete member?");
				if(conBox)
				{
					// document.getElementById('opn').value="Delete";
					document.form1.submit();
					// alert("Delete");
				}
				else
				{
					window.location="update.php";
				}
			}
	}

</script>
<?php

// if(!session_start())
// {
// 	session_start();
// }
// error_reporting(0);
include_once("database.php");

if (isset($_GET['msg']))
	$messages=$_GET['msg'];
else
	$messages="";

global $member_ID;
$member_ID = $_GET['m_id'];

$rs_sqlUpdSel = $dbObj->getMmberInfo($member_ID,false,"getMemberForUpdate");
if(mysqli_num_rows($rs_sqlUpdSel) == 1)
{
	$row_upd = mysqli_fetch_array($rs_sqlUpdSel);
	//print_r($row_upd);
	
	$member_id		= $row_upd[cl_member_id];
	$parent_id		= $row_upd[cl_parent_id];
	$first_name		= $row_upd[cl_first_name];
	$last_name		= $row_upd[cl_last_name];
	$gender				= $row_upd[cl_gender];
	$mPhone				= $row_upd[cl_phone];
	$mEmail				= $row_upd[cl_email];
	$spouse_name	= $row_upd[cl_spouse_name];
	$spouse_lastname	= $row_upd[cl_spouse_lastname];
	$sPhone				= $row_upd[cl_spouse_phone];
	$sEmail				= $row_upd[cl_spouse_email];
	(strtotime($row_upd[cl_dob]) != 0) ? $mDOB=date("Y-m-d", strtotime($row_upd[cl_dob])) : $mDOB=NULL;
	(strtotime($row_upd[cl_dod]) != 0) ? $mDOD=date("Y-m-d", strtotime($row_upd[cl_dod])) : $mDOD=NULL;
	(strtotime($row_upd[cl_spouse_dob]) != 0 ) ? $sDOB=date("Y-m-d", strtotime($row_upd[cl_spouse_dob])) : $sDOB=NULL;
	(strtotime($row_upd[cl_spouse_dod]) != 0 ) ? $sDOD=date("Y-m-d", strtotime($row_upd[cl_spouse_dod])) : $sDOD=NULL;
	(strtotime($row_upd[cl_marriage_date]) != 0 ) ? $marriageDate=date("Y-m-d", strtotime($row_upd[cl_marriage_date])) : $marriageDate=NULL;
	$member_img		= $row_upd[cl_member_img];
}


if($_SERVER['REQUEST_METHOD']=="POST")
{	
	if (isset($_POST['btnSubmit']))
	{
			//echo "<pre>";	print_r($_POST);	echo "</pre>"; 
			$member_id				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['memberId']));
			$parent_id 				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['parent_id'])); 
			$first_name 			= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['first_name']));	
			$last_name 				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['last_name']));
			$gender 					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['gender']));
			$mPhone 					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['mPhone']));
			$mEmail 					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['mEmail']));
			$spouse_name 			= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['spouse_name']));
			$spouse_lastname	= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['spouse_lastname']));
			$sPhone 					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['sPhone']));
			$sEmail 					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['sEmail']));
			(strtotime($_POST['mDOB']) != 0) ? $mDOB = date("Y-m-d", strtotime($_POST['mDOB'])): $mDOB=NULL;
			(strtotime($_POST['mDOD']) != 0) ? $mDOD = date("Y-m-d", strtotime($_POST['mDOD'])): $mDOD=NULL;
			(strtotime($_POST['sDOB']) != 0) ? $sDOB = date("Y-m-d", strtotime($_POST['sDOB'])): $sDOB=NULL;
			(strtotime($_POST['sDOD']) != 0) ? $sDOD = date("Y-m-d", strtotime($_POST['sDOD'])): $sDOD=NULL;
			(strtotime($_POST['marriageDate']) != 0) ? $marriageDate = date("Y-m-d", strtotime($_POST['marriageDate'])): $marriageDate=NULL;
			$member_img 		= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['member_img']));

			// Date field value needs to be set to NULL in case time conversion doesn't give a valid UNIX time. So constructing the update sql clause dynamically.
			$upd_sql_date="";
			(strtotime($_POST['mDOB']) == 0) ? $upd_sql_date=",".cl_dob."=NULL" : $upd_sql_date=",".cl_dob."='".$mDOB."'";
			(strtotime($_POST['mDOD']) == 0) ? $upd_sql_date=$upd_sql_date.",".cl_dod."=NULL" : $upd_sql_date=$upd_sql_date.",".cl_dod."='".$mDOD."'";
			(strtotime($_POST['sDOB']) == 0) ? $upd_sql_date=$upd_sql_date.",".cl_spouse_dob."=NULL" : $upd_sql_date=$upd_sql_date.",".cl_spouse_dob."='".$sDOB."'";
			(strtotime($_POST['sDOD']) == 0) ? $upd_sql_date=$upd_sql_date.",".cl_spouse_dod."=NULL" : $upd_sql_date=$upd_sql_date.",".cl_spouse_dod."='".$sDOD."'";
			(strtotime($_POST['marriageDate']) == 0) ? $upd_sql_date=$upd_sql_date.",".cl_marriage_date."=NULL" : $upd_sql_date=$upd_sql_date.",".cl_marriage_date."='".$marriageDate."'";
			$where_clause=" WHERE ".cl_member_id."=".$member_id.";";

			if ($parent_id > 0)
				{
					$sql_upd = "UPDATE `".tb_member."` SET `".cl_parent_id."`=".$parent_id.",`".cl_first_name."`='".$first_name."',`".cl_last_name."`='".$last_name."',`".cl_gender."`='".$gender."',`".cl_spouse_name."`='".$spouse_name."',`".cl_spouse_lastname."`='".$spouse_lastname."',`".cl_member_img."`='".$member_img."',`".cl_phone."`='".$mPhone."',`".cl_email."`='".$mEmail."',`".cl_spouse_phone."`='".$sPhone."',`".cl_spouse_email."`='".$sEmail."'";
				}
				else
				{
					$sql_upd = "UPDATE `".tb_member."` SET `".cl_first_name."`='".$first_name."',`".cl_last_name."`='".$last_name."',`".cl_gender."`='".$gender."',`".cl_spouse_name."`='".$spouse_name."',`".cl_spouse_lastname."`='".$spouse_lastname."',`".cl_member_img."`='".$member_img."',`".cl_phone."`='".$mPhone."',`".cl_email."`='".$mEmail."',`".cl_spouse_phone."`='".$sPhone."',`".cl_spouse_email."`='".$sEmail."'";
				}
				$sql_upd=$sql_upd.$upd_sql_date.$where_clause;
				// echo $sql_upd;exit;
				$dbObj->executeQuery($sql_upd,"upd-mem");
				header("location:update.php?msg=update&m_id=".$_POST['memberId']."&msg=Details updated");
	}
	else if (isset($_POST['btnDelete']))
	{
		$result = $dbObj->deleteMember($member_ID,"deletemember");
		if($result==true)
			header("location:index.php");
		else
			header("location:update.php?m_id=".$member_ID."&msg=Unable to delete. Check if children exist or SQL error.");
		// exit;
	}
}

// Get top member - start of the TREE
$items_v = $dbObj->getMmberInfo($member_ID,true,"getTopNode");
?>

<div id="links" class="hypLinks"><a href="tree.html">Family Tree</a>&nbsp;&nbsp;<a href="index.php">Home</a></div>
</br>

<div class="messages"><?php echo $messages;?></div>
<form method="post" name="form1">
<table width="30%" class="tableCustom">
	<tr>
    	<td width="50%" valign="top"><strong>Parent :</strong></td>
        <td>
<?php

function submenu_v($member_id,$dbObj)
{
	// Get all children for the member
	$rs_chldrnList = $dbObj->getChildList($member_id,"getChildren");
	global $ParentofCurrentlySelected;
	$ParentofCurrentlySelected=0;
	$rs_Parent = $dbObj->getParent($_GET['m_id'],"upd-getParent");
	$row_Parent = mysqli_fetch_array($rs_Parent);

	// Loop the children for a member and print the same. For each element do recursive search for children.
	if(mysqli_num_rows($rs_chldrnList)>0)
	{
		?><ul><?php
		while($row_2=mysqli_fetch_array($rs_chldrnList))
		{
			if($row_2[cl_member_id] == $row_Parent[cl_parent_id])
			{
				$ParentofCurrentlySelected=1;
			}
			?>			
				<li>               	
					<a>
						<input type="radio" name="parent_id" id="parent_id"  value="<?php echo $row_2[cl_member_id];?>" style="float:left" <?php echo ($ParentofCurrentlySelected == 1)? "checked": "";?> />
							<?php echo $row_2[cl_first_name]; echo (($row_2[cl_spouse_name]!=NULL)? " & ".$row_2[cl_spouse_name]:"");?></a>
					<?php
					if(submenu_v($row_2[cl_member_id],$dbObj)=="")
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
// Printing the top member (PARENT_ID=NULL) and loop through each child
$rs_Parent = $dbObj->getParent($_GET['m_id'],"upd-checkIfParent");
$row_Parent = mysqli_fetch_array($rs_Parent);
while($row_v = mysqli_fetch_array($items_v))
{
	?>
    	<li>
        	<a><input type="radio" name="parent_id" id="parent_id" value="<?php echo $row_v[cl_member_id];?>" style="float:left" <?php echo ($row_v[cl_member_id]==$row_Parent[cl_parent_id])? "checked":""  ?> />
					<?php echo $row_v[cl_first_name]; echo (($row_v[cl_spouse_name]!=NULL)? " & ".$row_v[cl_spouse_name]:"");?>
				</a>
		<?php
        if(submenu_v($row_v[cl_member_id],$dbObj)=="")
        {
          ?></li><?php
        }
}
?>
</ul>
</div></td>
   </tr>
    <tr>
		<td><strong>Parent id :</strong></td>
		<td><input type="text" name="parent_id" id="parent_id"value="<?php echo $parent_id; ?>" readonly /></td>
	</tr>
	<!-- <tr>
		<td><strong>Member id :</strong></td>
		<td><input type="text" name="member_id" id="member_id" value="<?php echo $member_id; ?>" readonly /></td>	
	</tr> -->
	<tr>
		<td><strong>First Name :</strong></td>
		<td><input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" /></td>	
   </tr>
   <tr>
   		<td><strong>Last Name :</strong></td>
        <td><input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" /></td>
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
     <td><input type="date" id="mDOB" name="mDOB" value="<?php echo $mDOB;?>"></td>
   </tr>
   <tr>
     <td><strong>Date of demise</strong></td>
     <td><input type="date" id="mDOD" name="mDOD" value="<?php echo $mDOD;?>"></td>
   </tr>
   <tr>
     <td><strong>Phone</strong></td>
     <td><input type="text" id="mPhone" name="mPhone" value="<?php echo $mPhone;?>"></td>
   </tr>
   <tr>
     <td><strong>Email</strong></td>
     <td><input type="text" id="mEmail" name="mEmail" value="<?php echo $mEmail;?>"></td>
   </tr>
   
   <tr>
   	<td><strong>Marriage Date :</strong></td>
    <td><input type="date" name="marriageDate" id="marriageDate" value="<?php echo $marriageDate; ?>" /></td>
   </tr>
   
   <tr>
   	<td><strong>Spouse's Name :</strong></td>
    <td><input type="text" name="spouse_name" id="spouse_name" value="<?php echo $spouse_name; ?>" /></td>
   </tr>
	 <tr>
   	<td><strong>Spouse's Last Name :</strong></td>
    <td><input type="text" name="spouse_lastname" id="spouse_lastname" value="<?php echo $spouse_lastname; ?>" /></td>
   </tr>
   <tr>
   	<td><strong>Spouse's Phone :</strong></td>
    <td><input type="text" name="sPhone" id="sPhone" value="<?php echo $sPhone; ?>" /></td>
   </tr>
   <tr>
   	<td><strong>Spouse Email :</strong></td>
    <td><input type="text" name="sEmail" id="sEmail" value="<?php echo $sEmail; ?>" /></td>
   </tr>
   <tr>
     <td><strong>Spouse's DOB</strong></td>
     <td><input type="date" id="sDOB" name="sDOB" value="<?php echo $sDOB;?>"></td>
   </tr>
   <tr>
     <td><strong>Spouse's date of demise</strong></td>
     <td><input type="date" id="sDOD" name="sDOD" value="<?php echo $sDOD;?>"></td>
   </tr>
   <tr>
   		<td><strong>Upload image :</strong></td>
        <td><input type="text" name="member_img" id="member_img" value="<?php echo $member_img; ?>" /></td>
   </tr>
   <tr>
   		<td><input type="submit" name="btnSubmit" value="Modify" class="btnPost" /></td>
        <td><input type="submit" name="btnDelete" value="Delete" class="btnPost" onclick ="javascript:delete_box('Delete','update.php');" />
				<input type="hidden" id="memberId" name="memberId" value="<?php echo $member_ID?>"/></td>
   </tr>
</table>
</form>