<?php include "header.php" ?>
<?php include "sqlconnect.php" ?>

<?php
function errorDialog($title, $message)
{
	echo "<div class=\"head\"><div class=\"panel panel-danger\"><div class=\"panel-heading\">" . $title . "</div><div class=\"panel-body\">" . $message . "<br>"; 
	echo "<div class=\"par\"><a class=\"btn btn-default\" href=\"index.php\">Go home</a></div>";
	echo "</div></div></div>";
}

function submitLink()
{
	$title = $_POST['titleField'];
	$url = $_POST['urlField'];
	
	if (empty($title))
	{
		?>
		<script type="text/javascript"> window.alert('Please give your song a name!'); </script>
		<?php
		return false;
	}
	
	if (empty($url))
	{
		?>
		<script type="text/javascript"> window.alert('How are people going to listen to your song? You didn\'t enter a URL!'); </script>
		<?php
		return false;
	}
	
	$platform = "undefined";
	
	if (strpos($url, 'youtube') !== FALSE)
	{
		$platform = "youtube";
	}
	elseif (strpos($url, 'soundcloud') !== FALSE)
	{
		$platform = "soundcloud";
	}
	else
	{
		echo "Unsupported platform!";
		return false;
	}
	
	$loggedIn = false;
	
	if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
	{
		$loggedIn = true;
	}
	
	$date = date("Y-m-d H:i:s");
	if (!$loggedIn)
	{
		if(mysql_query("INSERT INTO links(title,url,platform, dateSubmitted, numViews) VALUES('$title', '$url', '$platform', '$date', '0')"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	elseif ($loggedIn)
	{
		$check = mysql_query("SELECT * FROM links WHERE url='$url'");
		if ($check || mysql_num_rows($check) > 5)
		{
			errorDialog("Warning", "You are attempting to submit a song that has been shared over 5 times.<br>
									Please, do not spam your music. Give everyone else to chance to be heard!<br><br>
									If more excessive reposting is detected from your account, your account may be suspended."); 
									
			if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
			{
				$queryMe = mysql_query("SELECT * FROM users where userName = '$_SESSION[userName]'"); 
				$rowMe = mysql_fetch_array($queryMe); 
				$myid = $rowMe[0];
				
				mysql_query("INSERT INTO spammers (userID, numWarnings) VALUES ($myid, 1) ON DUPLICATE KEY UPDATE numWarnings = numWarnings+1; ");
			}
			return false;
		}
		
		if(mysql_query("INSERT INTO links(title,url,submitter,platform, dateSubmitted, numViews) VALUES('$title', '$url', '$_SESSION[userName]', '$platform', '$date', '0')"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	return false;
}

if(isset($_POST['submitLinkBtn'])) 
{ 
	submitLink();
}


?>