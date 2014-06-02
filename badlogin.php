
<!DOCTYPE html>
<!--[if lt IE 7]><html class="ng-csp ie ie6 lte9 lte8 lte7"><![endif]-->
<!--[if IE 7]><html class="ng-csp ie ie7 lte9 lte8 lte7"><![endif]-->
<!--[if IE 8]><html class="ng-csp ie ie8 lte9 lte8"><![endif]-->
<!--[if IE 9]><html class="ng-csp ie ie9 lte9"><![endif]-->
<!--[if gt IE 9]><html class="ng-csp ie"><![endif]-->
<!--[if !IE]><!--><html class="ng-csp"><!--<![endif]-->

	<head data-requesttoken="63ff3987c9fe78ac46bd">
		<title>
		ownCloud		</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-itunes-app" content="app-id=543672169">
		<link rel="shortcut icon" href="/owncloud/core/img/favicon.png" />
		<link rel="apple-touch-icon-precomposed" href="/owncloud/core/img/favicon-touch.png" />
					<link rel="stylesheet" href="/owncloud/remote.php/core.css?v=b56ea7b6aa77f6f9008bc9362fab3597" type="text/css" media="screen" />
							<script type="text/javascript" src="/owncloud/index.php/core/js/config.js?v=b56ea7b6aa77f6f9008bc9362fab3597"></script>
					<script type="text/javascript" src="/owncloud/remote.php/core.js?v=b56ea7b6aa77f6f9008bc9362fab3597"></script>
					<script type="text/javascript" src="/owncloud/core/js/visitortimezone.js?v=b56ea7b6aa77f6f9008bc9362fab3597"></script>
		
			</head>

	<body id="body-login">
		<div class="wrapper"><!-- for sticky footer -->
			<header><div id="header">
				<img src="/owncloud/core/img/logo.svg" class="svg" alt="ownCloud" />
				<div id="logo-claim" style="display:none;"></div>
			</div></header>
			<div><p class="info">Incorrect login. Please try again.</p></div>
			<!--[if IE 8]><style>input[type="checkbox"]{padding:0;}</style><![endif]-->
<form method="post" name="login">
	<fieldset>
							<p id="message" class="hidden">
			<img class="float-spinner" src="/owncloud/core/img/loading-dark.gif"/>
			<span id="messageText"></span>
			<!-- the following div ensures that the spinner is always inside the #message div -->
			<div style="clear: both;"></div>
		</p>
		<p class="infield grouptop">
			<input type="text" name="user" id="user" placeholder=""
				   value="" autofocus				   autocomplete="on" required/>
			<label for="user" class="infield">Username</label>
			<img class="svg" src="/owncloud/core/img/actions/user.svg" alt=""/>
		</p>

		<p class="infield groupbottom">
			<input type="password" name="password" id="password" value="" placeholder=""
				   required />
			<label for="password" class="infield">Password</label>
			<img class="svg" id="password-icon" src="/owncloud/core/img/actions/password.svg" alt=""/>
		</p>

						<input type="checkbox" name="remember_login" value="1" id="remember_login" checked />
		<label for="remember_login">remember</label>
				<input type="hidden" name="timezone-offset" id="timezone-offset"/>
		<input type="submit" id="submit" class="login primary" value="Log in"/>
	</fieldset>
</form>


			<div class="push"></div><!-- for sticky footer -->
		</div>

		<footer>
			<p class="info">
				<a href="http://owncloud.org" target="_blank">ownCloud</a> – web services under your control			</p>
		</footer>
	</body>
</html>
