<?php
define('DB_HOST', 'localhost'); 
define('DB_NAME', 'test'); 
define('DB_USER','root'); 
define('DB_PASSWORD',''); 

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

function register()
{
	if(empty($_POST['usernameRegister']) || 
	   empty($_POST['passwordRegister']) || empty($_POST['passwordRegister2']) ||
	   empty($_POST['emailRegister'])    || empty($_POST['emailRegister2']))
	   
	{
		echo "No fields may be left empty.";
		return false;
	}
	
	if ($_POST['passwordRegister'] != $_POST['passwordRegister2'])
	{
		echo "The passwords must match!";
		return false;
	}
	
	if ($_POST['emailRegister'] != $_POST['emailRegister2'])
	{
		echo "The emails must match!";
		return false;
	}
	
	$pwmd5 = md5($_POST['passwordRegister']);
	
	// check if already registered username
	$query = mysql_query("SELECT * FROM UserName where userName = '$_POST[usernameRegister]'"); 
		$row = mysql_fetch_array($query); 
		
	if(!empty($row['userName']))
	{
		echo "The username is already taken.";
		return false;
	}
	else
	{
		// create account
		
		if(mysql_query("INSERT INTO UserName(userName,pass) VALUES('$_POST[usernameRegister]', '$pwmd5')"))
		{
			echo "Account created succesfully";
			return true;
		}
		else
		{
			echo "Error while creating account";
			return false;
		}
		
	}
	
	return false;
}

function signIn() 
{ 
	if(!empty($_POST['usernameLogin']) && !empty($_POST['passwordLogin']))
	{ 
		$pwmd5 = md5($_POST['passwordLogin']);

		$query = mysql_query("SELECT * FROM UserName where BINARY userName = '$_POST[usernameLogin]' AND BINARY pass = '$pwmd5'"); 
		$row = mysql_fetch_array($query); 
		
		if (!$query || mysql_num_rows($query) <= 0)
		{
			echo "Invalid login"; 
			return false;
		}
		
		if(!empty($row['userName']) AND !empty($row['pass'])) 
		{ 
			$_SESSION['userName'] = $row['pass']; 
			echo "Login succesful"; 
			return true;
		} 
		else 
		{ 
			echo "Invalid login"; 
			return false;
		} 
	} 
	else
	{
		echo "Please enter your username and password.";
		return false;
	}
} 

session_start();

if(isset($_POST['login'])) 
{ 
	signIn();
}
elseif(isset($_POST['register']))
{
	register();
}




?>