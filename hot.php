<!DOCTYPE html>
<?php include "header.php"; ?>
<?php include "sqlconnect.php"; ?>

<?php
function showMessage($title, $message)
{
	echo "<div class=\"banner\"><div class=\"alert alert-info alert-dismissible\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" . $message; 
	echo "</div></div>";
}

if (isset($_GET['signedout']))
{
	$signedout = $_GET['signedout'];

	if ($signedout && $signedout == "true")
	{
		showMessage("Signed out", "You have successfully signed out of your account.");
	}
}
?>

<script src="http://w.soundcloud.com/player/api.js"></script>
<script src="jquery_cookie.js"> </script>

<script>
function grabSoundcloudArtwork(elementID, trackurl)
{
	var result;
	$(document).ready(function() {
		$.get('http://api.soundcloud.com/resolve.json?url=' + trackurl + '&client_id=cfa6203016f3842e366b4116b39d8b4f', function(result) {
			var artwrk = result.artwork_url;
			artwrk = artwrk.replace('-large', '-t500x500');

			$('#' + elementID).attr('src', artwrk);
		});
	});
}
</script>

<body>
	<div style="margin: 0 auto; padding: 0; margin-top:65px; width: 460px; max-height: 30px; display: table; ">

		<div class="btn-group" style="float:left; padding: 0; ">
		  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Sort by <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
			<a href="hot.php?order=by_date">Most recent</a><br>
			<a href="hot.php?order=by_views">Most viewed</a>
		  </ul>
		</div>
		
		<div class="btn-group" style="float:left; padding: 0; margin-left: 10px;">
		  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Show from <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
			<a href="hot.php?from=three_days">Within three days</a><br>
			<a href="hot.php?from=this_week">Within this week</a><br>
			<a href="hot.php?from=this_month">Within this month</a><br>
			<a href="hot.php?from=this_year">Within this year</a><br>
			<a href="hot.php?from=three_years">Within three years</a><br>
			<a href="hot.php?from=all_time">Any time</a>
		  </ul>
		</div>

		<div style="margin: 0 auto; float: right; display:inline-block; text-align: right; padding: 0; ">
			<form method="post" id="searchquery" action="hot.php?search" class="form-search form-inline" style="">
				<div class="input-append">
						<input type="text" name="query" style="width: 150px; border-radius: 4px; border: 0px solid;" class="search-query" placeholder="Search videos..." />
						<input type="submit" name="submit" class="btn btn-primary btn-sm" value="Search" />
				</div>
			</form>
		</div>
	</div>


<?php

function loadFromDatabase()
{
	define ("ORDER_VIEWS", "by_views");
	define ("ORDER_DATE", "by_date");

	define ("THREE_DAYS", "three_days");
	define ("THIS_WEEK", "this_week");
	define ("THIS_MONTH", "this_month");
	define ("THIS_YEAR", "this_year");
	define ("THREE_YEARS", "three_years");
	define ("ALL_TIME", "all_time");

	$order = ORDER_VIEWS;
	$datesToShow = ALL_TIME;

	if (isset($_GET['order']))
	{
		$order = $_GET['order'];
	}

	if (isset($_GET['from']))
	{
		$datesToShow = $_GET['from'];
	}

	if (isset($_POST['query']))
	{
		//echo "Search query: " . $_POST['query'];
	}
	
	
	
	$qStr = "SELECT * FROM links";// ORDER BY numViews DESC";
	
	if ($datesToShow == THREE_DAYS)
	{
		$qStr .= " WHERE DATE(dateSubmitted) > (NOW() - INTERVAL 3 DAY)";
	}
	elseif ($datesToShow == THIS_WEEK)
	{
		$qStr .= " WHERE DATE(dateSubmitted) > (NOW() - INTERVAL 1 WEEK)";
	}
	elseif ($datesToShow == THIS_MONTH)
	{
		$qStr .= " WHERE DATE(dateSubmitted) > (NOW() - INTERVAL 1 MONTH)";
	}
	elseif ($datesToShow == THIS_YEAR)
	{
		$qStr .= " WHERE DATE(dateSubmitted) > (NOW() - INTERVAL 1 YEAR)";
	}
	elseif ($datesToShow == THREE_YEARS)
	{
		$qStr .= " WHERE DATE(dateSubmitted) > (NOW() - INTERVAL 3 YEAR)";
	}
	else
	{
		// do nothing
	}
	
	if ($order == ORDER_DATE)
	{
		$qStr .= " ORDER BY dateSubmitted DESC";
	}
	elseif ($order == ORDER_VIEWS)
	{
		$qStr .= " ORDER BY numViews DESC";
	}
	
	$now = date("Y-m-d H:i:s");
	$query = mysql_query($qStr) or die($qStr . "<br/><br/>" . mysql_error()); // order by most views 
	
	echo "<div style=\"margin: 0 auto; margin-top: 20px; display: table;\">";
	while ($row = mysql_fetch_array($query)) 
	{
		$submitter = "Anonymous";
		$submitterID = 0;
		$linkID = $row[0];
		$vidurl = $row[1];
		$title = $row[2];
		$viewcount = $row[4];
		$videoDate = date("Y-m-d H:i:s");
		
		if (isset($row[4]) && $row[4])
		{
			$videoDate = $row[4];
		}
		if (isset($row[3]) && $row[3])
		{
			$submitter = $row[3];
			
			$uploaderQuery = mysql_query("SELECT * FROM users where userName = '$submitter'"); 
			$uploaderRow = mysql_fetch_array($uploaderQuery); 
			
			$submitterID = intval($uploaderRow[0]);
		}
		
		if ($row['platform'])
		{
			echo "
			<script> $(document).ready(function() {
					$(\"#img_" . $linkID . "\").on(\"click\", function() {
						$.ajax ({
							cache: false,
							type: \"POST\",
							url: 'player.php',
							data: {player_id: '" . $linkID . "'},
							success: function(data) {
								$('#viewer').html(data);
								$('#myModal').modal('show');
							}
						});
					});
				});
			</script>
			";
			
			echo "<a href=\"#a\" id=\"player_" . $linkID . "\">";
			//echo "<a href=\"hot.php?player_id=" . $linkID . "\" id=\"player_" . $linkID . "\">";
			echo "<div class=\"col-xs-5 thumb\" style=\"width: 200px; height: 200px;\">";
			echo "<div class=\"tableView\">";	
			echo "<p style=\"margin: 0 auto; text-align: center; padding: 0; font-size: 10pt;\">";
			echo $title . "<br>";
			echo "</p>";
			
			if ($row['platform'] == 'youtube')
			{
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $row[1], $match)) 
				{
					$video_id = $match[1];
					echo "<img id=\"img_" . $linkID . "\" src=\"http://img.youtube.com/vi/" . $video_id . "/0.jpg\" style=\"width: 100%; height: 87%; \">"; // thumbnail
				}
			}
			elseif ($row['platform'] == 'soundcloud')
			{
				echo "<script>
					$(document).ready(function() {
							grabSoundcloudArtwork('img_" . $linkID . "', '" . $vidurl . "');
						}
					);
				</script>";
				
				echo "<img id=\"img_" . $linkID . "\" style=\"width: 100%; height: 87%; \" src=\"\">";
			}
			
			echo "<a class=\"leftAlign\" ";

			if ($submitterID != 0)
			{
				echo "href=\"profile.php?id=" . $submitterID ."\"";
			}

			echo "style=\"margin: 0 auto; padding: 0px 0px 0px 5px; font-size: 8pt;\">";
			echo $submitter . "<br>";
			echo "</a>";
			
			echo "<p class=\"rightAlign\" style=\"margin: 0 auto; padding: 0px 0px 5px 0px; font-size: 8pt;\">";
			echo $viewcount . " views<br>";
			echo "</p>";
			
			echo "</div>";
			echo "</div>";
			echo "</a>\n";
		}
	}
	echo "</div>";
}

loadFromDatabase();

?>

<div id="viewer">

</div>



</body>

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
			<li class="active"><a href="hot.php"><span class="glyphicon glyphicon-fire"></span> what's hot</a></li>
			<li><a href="#"><span class="glyphicon glyphicon-asterisk"></span> new</a></li>
			<li><a href="page_submit.php"><span class="glyphicon glyphicon-upload"></span> submit</a></li>
		  </ul>

		  <ul class="nav navbar-nav navbar-right">
			<li>
			<?php include "check_login.php"; ?>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
</body>