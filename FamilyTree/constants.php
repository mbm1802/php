<?php
/************************************************************************************/
/*	Constants - Modify hostname,DB Username/Password/DB-Name and Domain Root*/
/************************************************************************************/

// global $domainroot;

//echo $_SERVER['HTTP_HOST'];

// $IMG_UPLOAD_PATH = "./images";

class Constants
{
	protected $server;
	protected $user;
	protected $pass;
	protected $db;
	protected $dbPort;
	
function init($httpHost)
{
	// echo $httpHost;
	// if ($_SERVER['HTTP_HOST']=='localhost:81')
	if ($httpHost=='localhost:81')
	{
		$this->server		= 'localhost';
		$this->user			= 'root';
		$this->pass			= '';
		$this->db			  = 'kidangeth'; //familytree
		$this->dbPort		= '3306';
		$domainroot			= 'http://localhost:81/Family_Tree';
	}
	else 
	{
		// echo "Check connection strings - ".$_SERVER['HTTP_HOST'];
		$this->server		= 'localhost';
		$this->user			= 'root';
		$this->pass			= 'mariadb';
		$this->db			  = 'kidangeth'; //familytree
		$this->dbPort		= '3306';
		$domainroot			= 'http://cent8n1/ftree';
	}
	// echo "Constants--->".$this->server."-".$this->user."-".$this->pass."-".$this->db."-".$this->dbPort;
}
	
}
?>