<html>

<link rel="stylesheet" type="text/css" href="ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="ddsmoothmenu-v.css" />
<LINK href="custom.css" rel="stylesheet" type="text/css" />

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
if(!session_start())
{
	session_start();
}

// unset($_SESSION);
// $isError=0;
// $_SESSION['isError']=0;
!isset($_GET['isError'])?$isError=0:$isError=1;
if(($isError==0) && isset($_SESSION['isError']) && $_SESSION['isError']==1)
	$_SESSION['isError']=0;
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$parentid				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['parentid']));
	$firstname			= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['firstname']));
	$lastname				= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['lastname']));
	$gender					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['gender']));
	$mPhone					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['mPhone']));
	$mEmail					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['mEmail']));
	$spousename			= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['spousename']));
	$spouselastname	= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['spouselastname']));
	$sPhone					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['sPhone']));
	$sEmail					= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['sEmail']));
	$member_img			= addslashes( mysqli_real_escape_string($dbObj->linkDB,$_POST['member_img']));
	(strtotime($_POST['mDOB']) != 0) ? $mDOB = date("Y-m-d", strtotime($_POST['mDOB'])): $mDOB=NULL;
	(strtotime($_POST['mDOD']) != 0) ? $mDOD = date("Y-m-d", strtotime($_POST['mDOD'])): $mDOD=NULL;
	(strtotime($_POST['sDOB']) != 0) ? $sDOB = date("Y-m-d", strtotime($_POST['sDOB'])): $sDOB=NULL;
	(strtotime($_POST['sDOD']) != 0) ? $sDOD = date("Y-m-d", strtotime($_POST['sDOD'])): $sDOD=NULL;
	(strtotime($_POST['marriageDate']) != 0) ? $marriageDate = date("Y-m-d", strtotime($_POST['marriageDate'])): $marriageDate=NULL;
	$_SESSION['parentid']=$parentid;
	$_SESSION['firstname']=$firstname;
	$_SESSION['lastname']=$lastname;
	$_SESSION['gender']=$gender;
	$_SESSION['mPhone']=$mPhone;
	$_SESSION['mEmail']=$mEmail;
	$_SESSION['spousename']=$spousename;
	$_SESSION['spouselastname']=$spouselastname;
	$_SESSION['sPhone']=$sPhone;
	$_SESSION['sEmail']=$sEmail;
	$_SESSION['mDOB']=$mDOB;
	$_SESSION['mDOD']=$mDOD;
	$_SESSION['sDOB']=$sDOB;
	$_SESSION['sDOD']=$sDOD;
	$_SESSION['marriageDate']=$marriageDate;
	
	if(!$parentid || !$firstname || !$gender)
	{
		$_SESSION['isError']=1;
		header("location:add_member.php?msg=*Missing mandatory fields&isError=1");
	}
	else
	{
		$sqlIns = "INSERT INTO  ".tb_member." (`".cl_parent_id."`,`".cl_first_name."`,`".cl_last_name."`,`".cl_gender."`,`".cl_phone."`,`".cl_email."`,`".cl_spouse_name."`,`".cl_spouse_lastname."`,`".cl_spouse_phone."`,`".cl_spouse_email."`,`".cl_member_img."`,`".cl_dob."`,`".cl_dod."`,`".cl_spouse_dob."`,`".cl_spouse_dod."`,`".cl_marriage_date."`) VALUES (".$parentid.",'".$firstname."','".$lastname."','".$gender."','".$mPhone."','".$mEmail."','".$spousename."','".$spouselastname."','".$sPhone."','".$sEmail."','".$member_img."'";
		// $sqlIns = "INSERT INTO  ".tb_member." VALUES (,'".$parentid."','".$firstname."','".$lastname."','".$gender."','".$mPhone."','".$mEmail."','".$spousename."','".$spouselastname."','".$sPhone."','".$sEmail."','".$member_img."'";
		$date_clause="";
		(strtotime($_SESSION['mDOB']) == 0) ? $date_clause=",NULL" : $date_clause=",'".$mDOB."'";
		(strtotime($_SESSION['mDOD']) == 0) ? $date_clause=$date_clause.",NULL" : $date_clause=$date_clause.",'".$mDOD."'";
		(strtotime($_SESSION['sDOB']) == 0) ? $date_clause=$date_clause.",NULL" : $date_clause=$date_clause.",'".$sDOB."'";
		(strtotime($_SESSION['sDOD']) == 0) ? $date_clause=$date_clause.",NULL" : $date_clause=$date_clause.",'".$sDOD."'";
		(strtotime($_SESSION['marriageDate']) == 0) ? $date_clause=$date_clause.",".cl_marriage_date."=NULL" : $date_clause=$date_clause.",'".$marriageDate."'";
		$date_clause=$date_clause.");";
		$sqlIns=$sqlIns.$date_clause;
		// echo $sqlIns;exit;
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
<!-- <table width="30%" style="border:1px solid #09F;border-radius:10px;padding:10px;font-family: Arial, Helvetica, sans-serif;font-size: 12px;"> -->
<table width="30%" class="tableCustom">
	<tr>
    	<Td width="50%" valign="top"><strong>Parent* </strong></Td>
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
                <a><input type="radio" name="parentid" id="parentid" value="<?php echo $row_2[cl_member_id];?>" style="float:left" <?php if (isset($_SESSION['isError']) && $_SESSION['isError']==1 && $_SESSION['parentid']==$row_2[cl_member_id]) echo "checked";?>/>
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
while($row_v = mysqli_fetch_array($items_v))
{
	?>
    	<li>
        	<a>
            	<input type="radio" name="parentid" id="parentid"  value="<?php echo $row_v[cl_member_id];?>" style="float:left" <?php if (isset($_SESSION['isError']) && $_SESSION['isError']==1 && $_SESSION['parentid']==$row_v[cl_member_id]) echo "checked";?> />
				<?php echo $row_v[cl_first_name];echo (($row_v[cl_spouse_name]!=NULL)? " & ".$row_v[cl_spouse_name]:"");?></a>
		<?php
        if(submenu_v($row_v['member_id'],$dbObj)=="")
        {
            ?></li><?php
        }
}
?>
</ul>
</div></td>
   </tr>
   <tr>
   		<td><strong>First Name* </strong></td>
        <td><input type="text" name="firstname" id="firstname" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['firstname']:""; ?>" /></td>
   </tr>
   <tr>
   		<td><strong>Last Name </strong></td>
        <td><input type="text" name="lastname" id="lastname" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['lastname']:""; ?>" /></td>
   </tr>
   <tr>
     <td><strong>Gender* </strong></td>
     <td><input type="radio" name="gender" <?php if (isset($_SESSION['isError']) && $_SESSION['isError']==1 && $_SESSION['gender']=="F") echo "checked";?> value="F"/>Female
		<input type="radio" name="gender" <?php if (isset($_SESSION['isError']) && $_SESSION['isError']==1 && $_SESSION['gender']=="M") echo "checked";?> value="M"/>Male
		<input type="radio" name="gender" <?php if (isset($_SESSION['isError']) && $_SESSION['isError']==1 && $_SESSION['gender']=="O") echo "checked";?> value="O"/>Other
	 </td>
   </tr>
   <tr>
     <td><strong>DOB</strong></td>
     <td><input type="date" id="mDOB" name="mDOB" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['mDOB']:NULL;?>"/></td>
   </tr>
   <tr>
     <td><strong>Date of demise</strong></td>
     <td><input type="date" id="mDOD" name="mDOD" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['mDOD']:NULL;?>"/></td>
   </tr>
	 <tr>
     <td><strong>Phone</strong></td>
     <td><input type="text" id="mPhone" name="mPhone" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['mPhone']:""; ?>"/></td>
   </tr>
   <tr>
     <td><strong>Email</strong></td>
     <td><input type="text" id="mEmail" name="mEmail" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['mEmail']:""; ?>"/></td>
   </tr>
   
   <tr>
   	<td><strong>Marriage Date </strong></td>
    <td><input type="date" name="marriageDate" id="marriageDate" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['marriageDate']:NULL;?>" /></td>
   </tr>
   <tr>
     <td><strong>Spouse's Name </strong></td>
     <td><input type="text" name="spousename" id="spousename" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['spousename']:""; ?>"/></td>
   </tr>
	 <tr>
     <td><strong>Spouse's Last Name </strong></td>
     <td><input type="text" name="spouselastname" id="spouselastname" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['spouselastname']:""; ?>"/></td>
   </tr>
	 <tr>
   	<td><strong>Spouse's Phone </strong></td>
    <td><input type="text" name="sPhone" id="sPhone" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['sPhone']:""; ?>"?/></td>
   </tr>
   <tr>
   	<td><strong>Spouse's Email </strong></td>
    <td><input type="text" name="sEmail" id="sEmail" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['sEmail']:""; ?>" /></td>
   </tr>
   <tr>
     <td><strong>Spouse's DOB</strong></td>
     <td><input type="date" id="sDOB" name="sDOB" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['sDOB']:NULL;?>"/></td>
   </tr>
   <tr>
     <td><strong>Spouse's date of demise</strong></td>
     <td><input type="date" id="sDOD" name="sDOD" value="<?php echo (isset($_SESSION['isError']) && $_SESSION['isError']==1)? $_SESSION['sDOD']:NULL;?>"/></td>
   </tr>
   <tr>
   		<td><strong>Upload Image </strong></td>
        <td><input type="text" name="member_img" id="member_img" /></td>
   </tr>
   <tr>
   		<td colspan="2"><input type="submit" name="submit" value="Submit" class="btnPost" /></td>
   </tr>
</table>
</form>