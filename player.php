<?php include "sqlconnect.php"; ?>
<?php
	$v_id = 0;
	
	if (isset($_POST['player_id']))
	{
		// if 'player_id' is set in the url, automatically show the player on document load
		$v_id = intval($_POST['player_id']);
	}
	
	$query = mysql_query("SELECT * FROM links WHERE linkID = $v_id");
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
		echo "" .
		
		"<script>
			var player;
			var loaded;
			
			if(document.getElementById('player_api') === null) {
				var tag = document.createElement('script');
				tag.src = \"http://www.youtube.com/player_api\";
				tag.id = \"player_api\";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			}
			else { initPlayer(); }
			
			function onYouTubePlayerAPIReady() { initPlayer(); }
			
			function initPlayer() {
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
			function stopVideo() { player.stopVideo(); }
			function playVideo() { event.target.playVideo(); }
			function onPlayerReady(event) { }
			function onPlayerStateChange(event) { }
		</script>";
	} // if youtube
	elseif ($platform == 'soundcloud')
	{
		echo "<script>
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
	</script>";
	}
	echo "<script>
		$(document).ready(function() {
		});
	</script>";
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" >
	<div class="modal-dialog modal-xl" role="document">
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
					<?php 
						echo "\"" . $title . "\" - Submitted by " . $submitter; 
					?>
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
				
			</div>
		</div>
	</div>
</div>
