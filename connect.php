<?php include "header.php"; ?>
<?php include "sqlconnect.php"; ?>
<?php
function errorDialog($title, $message)
{
	echo "<div class=\"head\"><div class=\"panel panel-danger\"><div class=\"panel-heading\">" . $title . "</div><div class=\"panel-body\">" . $message . "<br>"; 
	echo "<div class=\"par\"><a class=\"btn btn-default\" href=\"login.php\">Try again</a></div>";
	echo "</div></div></div>";
}

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
	$query = mysql_query("SELECT * FROM users where userName = '$_POST[usernameRegister]'"); 
		$row = mysql_fetch_array($query); 
		
	if(!empty($row['userName']))
	{
		echo "The username is already taken.";
		return false;
	}
	else
	{
		// create account
		
		$date = date("Y-m-d H:i:s");
		if(mysql_query("INSERT INTO users(userName,pass,joinDate) VALUES('$_POST[usernameRegister]', '$pwmd5', '$date')"))
		{
			echo "Account created succesfully. Please log in.";
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

		$query = mysql_query("SELECT * FROM users where BINARY userName = '$_POST[usernameLogin]' AND BINARY pass = '$pwmd5'"); 
		$row = mysql_fetch_array($query); 
		
		if (!$query || mysql_num_rows($query) <= 0)
		{
			errorDialog("Sign in error", "Incorrect log in."); 
			return false;
		}
		
		if(!empty($row['userName']) AND !empty($row['pass'])) 
		{ 
			$_SESSION['userName'] = $_POST['usernameLogin'];
			$_SESSION['signedIn'] = true;
			
			// set last log in date
			$date = date("Y-m-d H:i:s");
			if (!mysql_query("UPDATE users SET lastLoginDate='$date' WHERE userID='$row[0]'"))
			{
				echo "Error";
				return false;
			}
			
			return true;
		} 
		else 
		{ 
			errorDialog("Sign in error", "Incorrect log in."); 
			return false;
		} 
	} 
	else
	{
		errorDialog("Sign in error", "Please enter your username and password."); 
		return false;
	}
} 

if(isset($_POST['login'])) 
{ 
	if (signIn())
	{
		header("Location: hot.php");
	}
}
elseif(isset($_POST['register']))
{
	echo "<br><br><br><br><br>register";
	register();
}
?>

<!-- Navbar -->
<body>
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
		  </button>
		  <a class="navbar-brand" href="index.php">SongSwap</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		  <ul class="nav navbar-nav">
			<li><a href="hot.php"><span class="glyphicon glyphicon-fire"></span> what's hot</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-asterisk"></span> new</a></li>
			<li><a href="page_submit.php"><span class="glyphicon glyphicon-upload"></span> submit</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li class="active">
			<?php include "check_login.php"; ?>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
</body>