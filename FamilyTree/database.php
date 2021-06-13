<?php
/************************************************************************************/
/*DB related... */
/************************************************************************************/
include_once("constants.php");
include_once("tables.php");
// include_once("ErrorReportingConfig.php");

class database extends Constants
{
	public $linkDB;
	// public function connectDB($server,$user,$pass,$db,$dbPort)
	public function connectDB()
	{
		// echo "database = ".$this->server."-".$this->user."-".$this->pass."-".$this->db."-".$this->dbPort;
		// $dbConn = mysqli_connect('p:'.$server,$user,$pass,$db,$dbPort) or die('DB connection failed - '.mysqli_connect_errno()." >>> ".mysqli_connect_error());
		// mysqli_select_db($dbConn,$db) or die('Database doesn\'t exists !!! <br/>'.mysqli_error($dbConn));
		$dbConn = mysqli_connect('p:'.$this->server,$this->user,$this->pass,$this->db,$this->dbPort) or die('DB connection failed - '.mysqli_connect_errno()." >>> ".mysqli_connect_error());
		mysqli_select_db($dbConn,$this->db) or die('Database doesn\'t exists !!! <br/>'.mysqli_error($dbConn));
		
		return $dbConn;
		//$link=$dbConn;
	}
	
	public function executeQuery($sql,$string="")
	{
		$dbResult=mysqli_query($this->linkDB,$sql);
		if(!$dbResult)
			die("$string : ".mysqli_error($this->linkDB));
		else
			return $dbResult;	
	}

	// Get all children for a member
	public function getChildList($memberID,$string="")
	{
		$sql = "SELECT ".cl_member_id.",".cl_first_name.",".cl_last_name.",".cl_parent_id.",".cl_spouse_name." FROM ".tb_member." WHERE ".cl_parent_id."=$memberID ORDER BY ".cl_parent_id.", ".cl_member_id." ASC;";
		// echo $sql;
		$dbResult = $this->executeQuery($sql,$string);
		return $dbResult;	
	}

	// Get member info
	public function getMmberInfo($memberID,$isParentNull=false,$string="")
	{
		if($isParentNull == true)	// to fetch topmost member
			$sql = "SELECT * FROM `".tb_member."` WHERE `".cl_parent_id."` IS NULL;";
		else
			$sql = "SELECT * FROM `".tb_member."` WHERE `".cl_member_id."`=".$memberID."";
		// echo $sql." : ";
		$dbResult = $this->executeQuery($sql,$string);
		return $dbResult;	
	}

	// Get ParentID
	public function getParent($memberID,$string="")
	{
		$sql = "SELECT `".cl_parent_id."` FROM ".tb_member." WHERE member_id=$memberID;";
		// echo $sql";
		$dbResult = $this->executeQuery($sql,$string);
		return $dbResult;	
	}

	// delete member
	public function deleteMember($memberID,$string="")
	{
		$sql = "SELECT `".cl_member_id."` FROM `".tb_member."` WHERE `".cl_parent_id."`=$memberID;";
		// echo $sql;
		
		$rs_child = $this->executeQuery($sql,"checkForChildrenBeforeDelete");
		if(!$rs_child)
			die("$string : ".mysqli_error($this->linkDB));
		else
		{
			$childCount=mysqli_num_rows($rs_child);
			if($childCount > 0)
			{
				//echo "Child count is ".$childCount.". Unable to delete";
				return false;
			}
			else {
				// echo "Proceed to delete?";
				$sqlDel="DELETE FROM `".tb_member."` WHERE `".cl_member_id."`=".$memberID.";";
				// echo $sqlDel;
				if($this->executeQuery($sqlDel,$string))
					return true;
				else 
					return false;
			}
			exit;
			//return $dbResult;
		}
	}
}

$dbObj = new database();
$dbObj->init($_SERVER['HTTP_HOST']);
$dbObj->linkDB = $dbObj->connectDB();
// $dbObj->connectDB();
// $link = $dbObj->connectDB($server,$user,$pass,$db,$dbPort);
// echo $link->host_info."\n";
	

?>