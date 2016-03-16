<?php 
	session_start();
?>
<head>
  <title>SongSwap</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/theme-lumen.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
  <style>
	* {
		font-size: 11pt;
		font-family: 'Oswald', sans-serif;
	}
	html {
		height: 100%;
	}
	body {
		height: 100%;
		background: linear-gradient(45deg, hsla(340, 0%, 59%, 1) 0%, hsla(340, 0%, 59%, 0) 70%), linear-gradient(135deg, hsla(200, 13%, 60%, 1) 10%, hsla(200, 13%, 60%, 0) 80%), linear-gradient(225deg, hsla(345, 7%, 68%, 1) 10%, hsla(345, 7%, 68%, 0) 80%), linear-gradient(315deg, hsla(35, 44%, 61%, 1) 100%, hsla(35, 44%, 61%, 0) 70%);
	}
	.profile {
		box-shadow: 0 10px 6px -6px #777;
		border: 1px solid;
		border-color: #517994;
		border-radius: 5px;
		position: relative;
		width: 75%;
		display: table;
		margin: 0 auto;
		margin-top: 100px;
		padding: 0px 30px 30px 30px;
		background-color: #f2f3f3;
	}
	.banner {
		padding: 70px 0px 3px 3px;
		font-size: 11pt;
		display: table;
		margin: 0 auto;
		width: 50%;
	}
	.head {
		font-size: 26pt;
		padding: 25px 0px 3px 3px;
		display: table;
		margin: 0 auto;
	}
	.btn:focus,
	.btn:active:focus,
	.btn.active:focus,
	.btn.focus,
	.btn:active.focus,
	.btn.active.focus {
		outline: none;
	}
	.leftAlign {
		float: left;
		padding: 10px;
	}
	.rightAlign {
		float: right;
	}
	.rightAlignTiny {
		float: right;
		padding: 0px 30px 0px 0px;
	}
	.small {
		font-size: 8pt;
	}
	@media (min-width: 768px) {
		.modal-xl {
			width: 90%;
			max-width: 1200px;
		}
	}
	.jumbotron {
		background-color: #ffffff;
		opacity: 0.4;
		box-shadow: 0px 7px 5px #555555;
	}
	.margin {
		margin-bottom: 45px;
	}
	.margin2 {
		margin-top: 53px;
	}
	.bg-1 {
		background-color: white;
	}
	.bg-2 {
		background-color: #474e5d;
		/* Dark Blue */
		
		color: #ffffff;
	}
	.bg-3 {
		background-color: #ffffff;
		/* White */
		
		color: #555555;
	}
	.bg-4 {
		background-color: #2f2f2f;
		/* Black Gray */
		
		color: #fff;
	}
	.container-fluid-landing {
		opacity: 0.75;
		padding-top: 70px;
		padding-bottom: 70px;
		box-shadow: 0px 7px 5px #555555;
		border-radius: 5px;
		position: relative;
		margin: 0 auto;
		display: table;
		width: 95%;
		height: 100%;
		padding: 0px 10px 30px 30px;
	}
	.par {
		padding: 12px 0px 3px 3px;
		display: table;
		margin: 0 auto;
	}
	.tooltip-wrapper {
		display: inline-block;
	}
	.tooltip-wrapper .btn[disabled] {
		pointer-events: none;
	}
	.tooltip-wrapper.disabled {
		cursor: not-allowed;
	}
	.navbar {
		position: fixed;
		top: 0px;
		width: 100%;
		margin-bottom: 0;
		border-radius: 0px;
		box-shadow: 2px 2px 5px #999999;
	}
	footer {
		background-color: #024C67;
		padding: 25px;
	}
	.vid {
		box-shadow: 5px 5px 5px #555555;
		position: relative;
		width: 49%;
		margin: 8px;
		display: inline-block;
		padding: 0;
	}
	.loginBox {
		position: relative;
		width: 50%;
		min-height: 350px;
		text-align: center;
		display: table;
		margin: 0 auto;
	}
	.registerBox {
		position: relative;
		width: 80%;
		text-align: center;
		display: table;
		margin: 0 auto;
	}
	.tableView {
		display: block;
		width: 190px;
		height: 190px;
		background-color: white;
		box-shadow: 3px 3px 8px #666666;
		border-radius: 4px;
		padding-bottom: 15px;
		border-width: 1px;
		border-bottom-color: #296083;
		border-bottom-style: solid;
	}
	.card {
		text-align: center;
	}
  </style>
</head>