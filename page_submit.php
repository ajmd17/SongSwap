<!DOCTYPE html>
<?php include "header.php"; ?>
<?php include "sqlconnect.php"; ?>
<?php
$query = mysql_query("SELECT * FROM links ORDER BY RAND() LIMIT 1");
$row = mysql_fetch_array($query);
$url = $row[1];
$video_id = "";
$title = $row[2];
$platform = $row['platform'];
$submitter = "Anonymous";
$viewcount = 0;
if (isset($row[3]))
	$submitter = $row[3];
$ismysong = false;
if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['signedIn'] == true && $_SESSION['userName'])
{
	if ($_SESSION['userName'] == $submitter)
		$ismysong = true;
}
if (!isset($row['numViews']))
{
	mysql_query("UPDATE links SET numViews = 0 WHERE linkID='$row[0]'");
}
else
{
	if (!$ismysong)
	{
		// make view count go up 
		if (!mysql_query("UPDATE links SET numViews = numViews+1 WHERE linkID='$row[0]'"))
		{
			echo "Error setting view count";
		}
	}
}
$query = mysql_query("SELECT * FROM links WHERE linkID='$row[0]'");
$row = mysql_fetch_array($query);
$viewcount = $row['numViews'];

if ($platform == 'youtube') // if youtube, add youtube player api script.
{
	if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) 
	{
		$video_id = $match[1];
	}
	echo "<head><br><script src=\"http://www.youtube.com/player_api\"></script>" .
	
	"<script>
	var player;
	var loaded;
	function onYouTubePlayerAPIReady() {
		player = new YT.Player('player', {
			height: '350',
			width: '640',
			playerVars: {
				controls: 0,
				modestbranding: 1,
			}, 
			videoId: '" . $video_id . "',
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		});
		loaded = true;
	}
	setInterval(function() {
		if (loaded) {
			var timeToListen = 30.0;
			if (parseFloat(player.getDuration()) < 30.0) {
				timeToListen = parseFloat(player.getDuration());
			}
			if (player.getCurrentTime() >= timeToListen) {
				document.getElementById(\"postbtn\").removeAttribute('disabled');
				document.getElementById(\"timeremaining\").innerHTML = \"0s\";
				//$(\"#posttooltip\").attr('data-title', \"Thanks for showing your support!\");
			}
			else {
				document.getElementById(\"timeremaining\").innerHTML = Math.ceil(timeToListen-player.getCurrentTime()) + \"s\";
			}
		}
	},100);
	// stop
	function stopVideo() {
		player.stopVideo();
	}
	function playVideo() {
		event.target.playVideo();
	}
	// autoplay video
	function onPlayerReady(event) {
	}
	// when video ends
	function onPlayerStateChange(event) {
	}
	</script><br></head>";
} // if youtube
elseif ($platform == 'soundcloud')
{
	echo "<script src=\"http://w.soundcloud.com/player/api.js\"></script>
	<script>
		var duration;
		var ready = false;
		var widget;
		$(document).ready(function() {
			var trackUrl = '" . $url . "';
			$.get('http://api.soundcloud.com/resolve.json?url=' + trackUrl +
				'&client_id=cfa6203016f3842e366b4116b39d8b4f', function(
					result) {
					$('#soundcloudplayer').attr('src',
						'https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' +
						result.id + '&auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false&amp;visual=false'
						);
					widget = SC.Widget(document.getElementById(
						'soundcloudplayer'));
					widget.bind(SC.Widget.Events.READY, function() {
						ready = true;
					});
					widget.getDuration(function(dur) {
						duration = dur;
					});
				});
		});
			
		setInterval(function() {
			if (ready) {
				widget.getPosition(getTime);
			}
		}, 1000);

		function getTime(time) {
			var timeToListen = 30.0;
			if (parseFloat(duration) < 30.0) {
				timeToListen = parseFloat(duration);
			}
			if (time / 1000 >= timeToListen) {
				document.getElementById(\"postbtn\").removeAttribute('disabled');
				document.getElementById(\"timeremaining\").innerHTML = \"0s\";
			}
			else {
				document.getElementById(\"timeremaining\").innerHTML = Math.ceil(timeToListen-(time / 1000)) + \"s\";
			}
		}
	</script>";
}
?>
<body>
	<script>
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
	$(function() {
		$('.tooltip-wrapper').tooltip({placement: "left", html: true});
	});
	</script>

	<div class="head">
		<!-- Submit -->
		<form id='submitLink' action='submit.php' method='post' accept-charset='UTF-8'>
			<fieldset>
				<legend>Submit Link</legend>
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				<br>

				<label for='titleField' >Title:</label>
				<input type='text' name='titleField' id='titleField'  maxlength="50" />
				<br>
				 
				<label for='urlField' >Link URL:</label>
				<input type='text' name='urlField' id='urlField'  maxlength="150" />
				 
				<input id="button" type="submit" name='submitLinkBtn' value='Submit' />
			</fieldset>
		</form>
	
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" onclick="playVideo()" data-target="#myModal">
		  Watch video
		</button>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" >
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="stopVideo()" aria-label="Close"><span style="font-family:Arial; font-size: 16pt;" aria-hidden="true">&times;</span></button>
				
				<div class="rightAlignTiny">
					 <div class="dropdown">
					  <a class="small" id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						Report
						<span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu" aria-labelledby="dLabel">
						<div class="small">
							<a>This isn't a song</a>
							<a>Inappropriate content</a>
							<a>Video/song doesn't play</a>
						</div>
					  </ul>
					</div>
				</div>
				
				<h4 class="modal-title" id="myModalLabel">
					<?php echo "\"" . $title . "\" - Submitted by " . $submitter; ?>
				</h4>
				  <div class="container-fluid">
					<div class="row">
						<div class="col-sm-6" style="box-shadow: 5px 5px 15px #555555; padding: 0;">
							<div id="player" style="position:relative;display: block; width: 100%; height: 350px; padding: 0; margin: 0 auto;">
								<?php
									if ($platform == 'soundcloud')
										echo "<iframe id=\"soundcloudplayer\" style=\"width: 100%; height: 65px;\" heightscrolling=\"no\" frameborder=\"no\" src=\"\"> </iframe><br>";
								?>
							</div>
						</div>
						<div class="col-sm-6" style="min-height: 350px; padding: 50px;">
							<h2 style="text-align: center;">Artist Info</h2><hr>
						</div>
					</div>
				</div>
			  </div>
				  
				  
			  <div class="modal-footer">
			  
				<div id="timeremaining" class="leftAlign"> 0s </div>
				<div id="viewcount" class="leftAlign"> <?php echo "Views: " . $viewcount; ?> </div>
			  
				<div id="posttooltip" class="tooltip-wrapper" data-title="Before share your music with the world, please support this artist by checking out their music too.
				<br><br>You don't have to listen to the entire song.">
					<button type="button" class="btn btn-primary" id="postbtn" disabled>
							Post
					</button>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	</div>

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
			<li class="active"><a href="page_submit.php"><span class="glyphicon glyphicon-upload"></span> submit</a></li>
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