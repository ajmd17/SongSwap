<?php include "header.php"; ?>

<body>
	<h1 class="head" style="padding: 85px 0 0 0; font-family: 'Oswald';">You don't need to create an account to use SongSwap.</h1>
	<p class="par">But creating an account will allow you to display your interests, keep tabs on other artists and let your fans reach out to you. </p>

	<!-- Login form -->

	<div class="loginBox" style="padding: 25px 0 0 0;">
		<div class="panel panel-primary">
			<div class="panel-heading">Sign in</div>
			<div class="panel-body">
				<form id='loginForm' action='connect.php' class="form-horizontal" method='post' accept-charset='UTF-8'>
					<fieldset>
						<input type='hidden' name='submitted' class="form-control" id='submitted' value='1' />
						<div class="form-group">
							<label for='usernameLogin' class="col-sm-2 control-label">Username:</label>
							<div class="col-sm-10">
								<input type='text' name='usernameLogin' class="form-control" id='usernameLogin' maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label for='passwordLogin' class="col-sm-2 control-label">Password:</label>
							<div class="col-sm-10">
								<input type='password' name='passwordLogin' class="form-control" id='usernameLogin' maxlength="50" />
							</div>
						</div>
						<input id="button" class="btn btn-default" type="submit" name='login' value='Log in' />
					</fieldset>
				</form>
			</div>
		</div>
	</div>

	<!-- Registration -->
	<div class="registerBox">
		<div class="panel panel-default">
			<div class="panel-heading">Not registered yet? Sign up.</div>
			<div class="panel-body">
				<form id='registerForm' action='connect.php' class="form-horizontal" method='post' accept-charset='UTF-8'>
					<fieldset>
						<input type='hidden' name='submitted' id='submitted' value='1' />

						<div class="form-group">
							<label for='usernameRegister' class="col-sm-2 control-label">Username:</label>
							<div class="col-sm-10">
								<input type='text' name='usernameRegister' class="form-control" id='usernameRegister' maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label for='passwordRegister' class="col-sm-2 control-label">Password:</label>
							<div class="col-sm-10">
								<input type='password' name='passwordRegister' class="form-control" id='passwordRegister' maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label for='passwordRegister2' class="col-sm-2 control-label">Password (again):</label>
							<div class="col-sm-10">
								<input type='password' name='passwordRegister2' class="form-control" id='passwordRegister2' maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label for='emailRegister' class="col-sm-2 control-label">Email address:</label>
							<div class="col-sm-10">
								<input type='text' name='emailRegister' class="form-control" id='emailRegister' maxlength="50" />
							</div>
						</div>
						<div class="form-group">
							<label for='emailRegister2' class="col-sm-2 control-label">Email address (again):</label>
							<div class="col-sm-10">
								<input type='text' name='emailRegister2' class="form-control" id='emailRegister2' maxlength="50" />
							</div>
						</div>

						<input id="button" class="btn btn-default" type="submit" name='register' value='Register' />

					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>

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
					<li><a href="hot.php"><span class="glyphicon glyphicon-fire"></span> what's hot</a>
					</li>
					<li><a href="#"><span class="glyphicon glyphicon-asterisk"></span> new</a>
					</li>
					<li><a href="page_submit.php"><span class="glyphicon glyphicon-upload"></span> submit</a>
					</li>
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