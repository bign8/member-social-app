<?php
	session_start();
	if (isset($_POST['login'])) {
		if ($_POST['user'] == 'john' && $_POST['pass'] == 'doe') {
			$_SESSION['user'] = array(
				'userID' => 'B0091656878&C`G)9Tod',
				'first' => 'John',
				'last' => 'Doe',
				'company' => 'Don\'t care',
				'title' => 'Manager',
				'city' => 'Two Dot',
				'state' => 'MT',
				'bio' => 'Something...'
			);
			die(header('Location: index.php')); // lose post request
		} else {
			// show login error
		}
		
	} elseif (isset($_REQUEST['logout'])) {
		unset( $_SESSION['user'] );
		die(header('Location: index.php')); // lose query string
	}
	$auth = isset( $_SESSION['user'] );
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>ELA - App</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href="css.css" rel="stylesheet">
</head>
<body data-spy="scroll" data-target=".navbar">
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#home">ELA</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#home">Home</a></li>
					<li><a href="#about">About</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#faq">FAQ</a></li>
							<?php if ($auth): ?><li><a href="#contacts">Contacts</a></li><?php endif; ?>
							<li><a href="#samples">Project Samples</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Guides</li>
							<li><a href="#hints">Hints + Tips</a></li>
							<li><a href="#desc">Guide Description</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">External Links</li>
							<li><a href="http://ela.upstreamacademy.com/" target="blank">Progress Tracker</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if ($auth): ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php echo isset($_SESSION['user']['first']) ? $_SESSION['user']['first'] : 'John'; ?> 
								<?php echo isset($_SESSION['user']['last']) ? $_SESSION['user']['last'] : 'Doe'; ?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Your Profile</a></li>
								<li><a href="#">Your Conference</a></li>
								<li><a href="#">Your Calendar</a></li>
								<li><a href="#">Your Workbook</a></li>
								<li><a href="index.php?logout">Logout</a></li>
							</ul>
						</li>
					<?php else: ?>
						<li><a href="#login">Login</a></li>
					<?php endif; ?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>

	<div id="wrap" data-ng-app="ela">
		<?php include('frame/home.frame.html'); ?>

		<?php include('frame/about.frame.html'); ?>

		<?php include('frame/faq.frame.html'); ?>

		<?php if ($auth) include('frame/search.frame.html'); ?>

		<?php include('frame/samples.frame.html'); ?>

		<?php include('frame/hints.frame.html'); ?>

		<?php include('frame/desc.frame.html'); ?>

		<?php if (!$auth) include('frame/login.frame.html'); ?>

		<div class="container" style="min-height:0"></div><!-- same as a push -->
	</div><!-- ./wrap -->

	<div id="footer" class="navbar navbar-default navbar-fixed-bottom">
		<div class="container">
			<p class="pull-right social">
				<a href="http://www.linkedin.com/groups?gid=4403897" target="blank">
					<i class="fa fa-linkedin-square text-muted"></i>
				</a>
			</p>
			<p class="text-muted credit">
				&copy; <a href="http://upstreamacademy.com">Upstream Academy</a> 
				<?php echo date('Y'); ?>
			</p>
		</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.min.js"></script>
	<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.min.js"></script>
	<script src="js.js"></script>
</body>
</html>