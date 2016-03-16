

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

	$(function() {
		$('.tooltip-wrapper').tooltip({placement: "left", html: true});
	});

	var player;
	var loaded;

	function onYouTubePlayerAPIReady() {
		player = new YT.Player('player', {
			height: '390',
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
		
		if (loaded)
		{
			var timeToListen = 30.0;
			
			if (parseFloat(player.getDuration()) < 30.0)
			{
				timeToListen = parseFloat(player.getDuration());
			}
			
			if (player.getCurrentTime() >= timeToListen)
			{
				document.getElementById("postbtn").removeAttribute('disabled');
				document.getElementById("timeremaining").innerHTML = "0s";
			}
			else
			{
				document.getElementById("timeremaining").innerHTML = Math.ceil(timeToListen-player.getCurrentTime()) + "s";
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
