<?php include "header.php"; ?>
<?php include "sqlconnect.php"; ?>

<?php
function errorDialog($title, $message)
{
	echo "<div class=\"head\"><div class=\"panel panel-danger\"><div class=\"panel-heading\">" . $title . "</div><div class=\"panel-body\">" . $message . "<br>"; 
	echo "<div class=\"par\"><a class=\"btn btn-default\" href=\"index.php\">Home</a></div>";
	echo "</div></div></div>";
}

if (isset($_GET['id']))
{

	$id = intval($_GET['id']);
	
	$myid = 0;
	$ismyprofile = false;
	
	$query = mysql_query("SELECT * FROM users where userID = '$id'"); 
	$row = mysql_fetch_array($query); 
	
	if (!$query || mysql_num_rows($query) <= 0)
	{
		errorDialog("Error", "User does not exist!<br>The account may have been deleted or banned."); 
		return false;
	}
	
	if (!isset($row['numPageViews']))
	{
		mysql_query("UPDATE users SET numPageViews = 0 WHERE userID='$id'");
	}
	
	if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
	{
		$queryMe = mysql_query("SELECT * FROM users where userName = '$_SESSION[userName]'"); 
		$rowMe = mysql_fetch_array($queryMe); 
		$myid = $rowMe[0];
		
		if ($myid == $id)
			$ismyprofile = true;
	}
	
	if (!$ismyprofile)
	{
		// make view count go up 
		if (!mysql_query("UPDATE users SET numPageViews = numPageViews+1 WHERE userID='$id'"))
			echo "Error setting page view count";
		
		// update page views
		$query = mysql_query("SELECT * FROM users where userID = '$id'"); 
		$row = mysql_fetch_array($query); 
	}

	$screenName = $row['userName'];
	
	$numPageViews = $row['numPageViews'];
	
	$t_j = strtotime($row['joinDate']);
	$joinDate = date('F d, Y, g:i A',$t_j);
	
	$t_l = strtotime($row['lastLoginDate']);
	$lastLoginDate = date('F d, Y, g:i A',$t_l);
	
	
	// get number of submitted links
	$resCountSongs=mysql_query("SELECT count(*) as numSubmissions FROM links WHERE submitter = '$screenName'");

	$countSongs=mysql_fetch_assoc($resCountSongs);
	$countSongs=$countSongs['numSubmissions'];
	
	// get number of submitted links
	$resNumFans=mysql_query("SELECT count(*) as numFans FROM fans WHERE artistID = '$id'");

	$numFans=mysql_fetch_assoc($resNumFans);
	$numFans=$numFans['numFans'];
	
	
	
	echo "<div class=\"profile\">" .
		  "<h1 style=\"display: inline-block;\">";
	  
	echo $screenName . "</h1>";
	if ($id == $myid)
	{
		echo "<p style=\"display: inline-block; padding-left: 5px;\">    (that's you!)</p>";
	}

	?>
	  
	<div class="rightAlign">
			<?php

				$isfan = false;
				$signedIn = false;
				if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
				{
					$signedIn = true;
					$fanQuery = mysql_query("SELECT * FROM fans where artistID = '$id' AND fanID = '$myid'"); 
					$fanRow = mysql_fetch_array($fanQuery); 
					
					if (!$fanQuery || mysql_num_rows($fanQuery) <= 0)
					{
						$isfan = false;
					}
					
					if(!empty($fanRow['fanID']) AND !empty($fanRow['artistID'])) 
					{ 
						$isfan = true;
					}
				}
			
				// the user clicked the "fan" button
				if (isset($_POST['fan']) && !$isfan)
				{
					// double check to make sure the user didn't mess with anything
					if ($id != $myid)
					{
						$fanDate = date("Y-m-d H:i:s");
						if(mysql_query("INSERT INTO fans(artistID,fanID,fanDate) VALUES('$id', '$myid', '$fanDate')"))
						{
							$isfan = true;
							// reload fans
							$resNumFans=mysql_query("SELECT count(*) as numFans FROM fans WHERE artistID = '$id'");

							$numFans=mysql_fetch_assoc($resNumFans);
							$numFans=$numFans['numFans'];
						}
						else
							echo "Unknown error";
					}
					else
						echo "You cannot Fan yourself";
				}
				// the user clicked the "unfan" button
				elseif (isset($_POST['unfan']) && $isfan)
				{
					// double check to make sure the user didn't mess with anything
					if ($id != $myid)
					{
						$fanDate = date("Y-m-d H:i:s");
						if(mysql_query("DELETE FROM fans where artistID='$id' AND fanID='$myid'"))
						{
							$isfan = false;
							// reload fans
							$resNumFans=mysql_query("SELECT count(*) as numFans FROM fans WHERE artistID = '$id'");

							$numFans=mysql_fetch_assoc($resNumFans);
							$numFans=$numFans['numFans'];
						}
						else
							echo "Unknown error";
					}
					else
						echo "You cannot unFan yourself";
				}
				
				echo "<div style=\"padding-top: 10px;\">";
				if ($id == $myid)
				{
					echo "<form action=\"profile.php?id=" . $id . "\" method=\"post\"><button type=\"submit\" id=\"fanbtn\" name=\"fan\" class=\"btn btn-default btn-lg\"";
					echo " disabled><span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span> Fan</button></form>";
				}
				elseif ($isfan)
				{
					echo "<form action=\"profile.php?id=" . $id . "\" method=\"post\"><button type=\"submit\" id=\"unfanbtn\" name=\"unfan\" class=\"btn btn-default btn-lg\"";
					echo "><span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span> Unfan</button></form>";
				}
				elseif (!$isfan && $signedIn)
				{
					echo "<form action=\"profile.php?id=" . $id . "\" method=\"post\"><button type=\"submit\" id=\"fanbtn\" name=\"fan\" class=\"btn btn-default btn-lg\"";
					echo "><span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span> Fan</button></form>";
				}
				elseif (!$isfan && !$signedIn)
				{
					echo "<a class=\"btn btn-default btn-lg\" ";
					echo "href=\"login.php\" ";
					echo " ><span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\" ></span>";
					
					echo "Sign in to Fan";
					
					echo "</a></form>";
				}
				echo "</div>";
			echo "</div>";
			?>
	  
	<?php
	  echo "<p>" .
	  
	  "<b>Joined: </b>" . $joinDate . "<br>" .
	  "<b>Last logged in: </b>" . $lastLoginDate . "<br>" .
	  "<b>Profile views: </b>" . $numPageViews . "<br>" .
	  "<b>Submitted songs: </b>" . $countSongs . "<br>" .
	  "<b>Fans: </b>" . $numFans . "<br>" .
	  "</p>";
	  
	echo "</div>";
}
?>



<body>
	<!-- Navbar -->
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
