<?php
function checkLoggedIn()
{
	if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
	{
		return true;
	}
	
	return false;
}

$isLoggedIn = checkLoggedIn();

if (!$isLoggedIn)
{
	echo "<a href=\"login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> sign in</a>";
}
else if ($isLoggedIn)
{
	$query = mysql_query("SELECT * FROM users where userName = '$_SESSION[userName]'"); 
	$row = mysql_fetch_array($query); 
	$id = $row[0];
	
	echo "<li class=\"dropdown\">";
	echo "<a class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-user\"></span> " . $_SESSION['userName'] . "</a>";
	
	echo "<ul class=\"dropdown-menu\">";
	
	echo "<li><a href=\"#\"><i class=\"glyphicon glyphicon-music\"></i> My shares</a></li>";
	echo "<li><a href=\"#\"><i class=\"glyphicon glyphicon-thumbs-up\"></i> My fans</a></li>";
	
	echo "<li role=\"separator\" class=\"divider\"></li>";
	
	echo "<li><a href=\"#\"><i class=\"glyphicon glyphicon-heart\"></i> Favorites</a></li>";
	echo "<li><a href=\"#\"><i class=\"glyphicon glyphicon-envelope\"></i> Messages</a></li>";
	
	echo "<li role=\"separator\" class=\"divider\"></li>";
	
	echo "<li><a href=\"profile.php?id=" . $id . "\"><i class=\"glyphicon glyphicon-eye-open\"></i> View profile</a></li>";
	echo "<li><a href=\"#\"><i class=\"glyphicon glyphicon-cog\"></i> Manage profile</a></li>";
	
	echo "<li role=\"separator\" class=\"divider\"></li>";
	
	echo "<li><a href=\"logout.php\">Sign out</a></li>";
	
	echo "</ul>";
	
	echo "</li>";
}
?>