<!DOCTYPE html>
<?php include "header.php"; ?>
<?php include "sqlconnect.php"; ?>
	<body>
		<div class="margin2">
			<div class="jumbotron">
			
			  <div class="container">
				<h1 style="font-size: 52pt; color: #111111;">SongSwap</h1>
				<p style="color: #111111;">SongSwap is a self-promotion tool for independent musicians. And then some.</p>
			  </div>
			  
			</div>
		</div>
		
			
		<div class="container">
		  <!-- Example row of columns -->
		  <div class="row" style="border-radius:18px; background-color:rgba(204,238,255,0.12);
			box-shadow: 0 10px 6px -6px #777;">
			<h1 style="
			display: flow; width: 100%;
			position: relative; padding: 0px 0px 0px 15px;
			">What does it do?</h1>
			
			<div style="margin-top: 25px; padding: 8px;">
			
				<div class="col-md-4">
				  <h2>For artists</h2>
				  <p>SongSwap allows artists to share their music online by "swapping" their songs with another musician. Every time you share a song, you will be matched up with another artist's song. Before you share your music, you must first give their music a chance to be heard.
					<br><br>If all goes according to plan: both musicians end up with a new fan, and another musician to listen to.</p>
				</div>
				<div class="col-md-4">
				  <h2>For music fans</h2>
				  <p>You can find new independent musicians to listen to. "Fan" artists to see whenever they share a new song. Communicate with them via messaging. <br><br>Sign up as a music fan and show your support!</p>
			   </div>
				
			</div>
		  </div>
		</div> <!-- /container -->  
	
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
				<li>
				<?php include "check_login.php"; ?>
				</li>
			  </ul>
			</div>
		  </div>
		</nav>
	</body>