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
	<!-- Wrap all page content here -->
	<div id="wrap" data-ng-app="ela">

		<!-- Fixed navbar -->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">ELA</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#home">Home</a></li>
						<li><a href="#about">About</a></li>
						<li><a href="#faq">FAQ</a></li>
						<li><a href="#contacts">Contacts</a></li>
						<li><a href="http://ela.upstreamacademy.com/" target="blank">Progress Tracker</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Project Samples</a></li>
								<li><a href="#">More Tools...</a></li>
								<li class="divider"></li>
								<li class="dropdown-header">Guides</li>
								<li><a href="#">Hints + Tips</a></li>
								<li><a href="#">Guide Description</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php if (true): /* check authentication */ ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "John Doe"; ?> <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Your Conference</a></li>
									<li><a href="#">Your Calendar</a></li>
									<li><a href="#">Your Workbook</a></li>
									<li><a href="#">Logout</a></li>
								</ul>
							</li>
						<?php else: ?>
							<li><a href="#">Login</a></li>
						<?php endif; /* end authentication check */ ?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>

		<!-- Begin HOME content -->
		<div class="container" id="home">
			<div class="page-header">
				<h1>Welcome to ELA</h1>
			</div>
			<img class="pull-right img-responsive col-sm-3 hidden-xs img-rounded" src="data/img/buiz2.jpg">
			<p class="lead">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
			</p>
			<p>
				In feugiat tincidunt tortor. Quisque cursus purus a justo egestas, id consectetur tellus vulputate. Quisque sed blandit nulla. Nunc fringilla quis lacus eget hendrerit. Etiam tincidunt metus at nisl scelerisque dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus vestibulum mauris lacus, nec accumsan lectus adipiscing nec. Vestibulum convallis suscipit lectus vitae eleifend. Proin luctus pulvinar mi et elementum. Pellentesque luctus, metus quis elementum dictum, leo lorem posuere odio, vel accumsan tellus odio at risus. Proin tempus imperdiet quam nec vestibulum.
			</p>
			<p>
				Morbi placerat felis neque, at placerat lorem tempus quis. Duis tincidunt tempor nisl sed tempus. Etiam a pharetra enim. Ut semper in quam quis sodales. In ac velit viverra, tristique lectus ut, imperdiet nulla. Morbi egestas dapibus turpis at sodales. Ut imperdiet turpis justo, ac placerat risus gravida sed. Suspendisse potenti.
			</p>
			<p>
				Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris nisl sem, fringilla nec neque molestie, porttitor accumsan tellus. Nam felis odio, sollicitudin a mi vitae, vehicula dictum diam. Cras condimentum sit amet lacus at luctus. Curabitur aliquet ante consequat, aliquet ligula eu, congue nisl. Proin nibh ligula, ornare vel elit ac, sagittis lacinia tellus. Duis non orci egestas, pharetra purus id, mattis nisi. Maecenas sagittis, erat id placerat placerat, ante est rhoncus ligula, eget aliquet tellus odio vitae augue. Cras non mauris neque. Cras varius vestibulum dui sed rutrum. Maecenas nisl est, pharetra sit amet risus eget, ornare scelerisque lorem. Nunc at dolor non odio ullamcorper vulputate vitae a purus.
			</p>
			<p>
				Quisque semper varius nisl vel facilisis. Maecenas ornare molestie diam vitae ultrices. Donec vel erat quis magna tempor pharetra. Quisque congue lorem sit amet ultrices cursus. Suspendisse turpis sapien, mattis ac augue eget, varius sollicitudin dui. Mauris vel justo in nulla convallis aliquam ut vel elit. Sed pretium rhoncus imperdiet. Ut lacus erat, suscipit quis enim et, iaculis dictum ipsum. Vestibulum dignissim, lacus vel aliquet molestie, urna purus cursus libero, in lacinia velit leo a enim. Ut et interdum magna, sit amet placerat erat. Praesent nec tempor neque. Cras ultricies odio a dui fringilla consequat. Donec dictum consequat eros quis lobortis. Proin venenatis lacus et sem congue, at placerat velit consectetur. Nunc lobortis est a dolor varius, non vestibulum elit feugiat.
			</p>
		</div>

		<!-- Begin ABOUT content -->
		<div class="container" id="about">
			<div class="page-header">
				<h1>About</h1>
			</div>
			<img class="pull-right img-responsive col-sm-3 hidden-xs img-rounded" src="data/img/buiz1.jpg">
			<p class="lead">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
			</p>
			<p>
				In feugiat tincidunt tortor. Quisque cursus purus a justo egestas, id consectetur tellus vulputate. Quisque sed blandit nulla. Nunc fringilla quis lacus eget hendrerit. Etiam tincidunt metus at nisl scelerisque dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus vestibulum mauris lacus, nec accumsan lectus adipiscing nec. Vestibulum convallis suscipit lectus vitae eleifend. Proin luctus pulvinar mi et elementum. Pellentesque luctus, metus quis elementum dictum, leo lorem posuere odio, vel accumsan tellus odio at risus. Proin tempus imperdiet quam nec vestibulum.
			</p>
			<p>
				Morbi placerat felis neque, at placerat lorem tempus quis. Duis tincidunt tempor nisl sed tempus. Etiam a pharetra enim. Ut semper in quam quis sodales. In ac velit viverra, tristique lectus ut, imperdiet nulla. Morbi egestas dapibus turpis at sodales. Ut imperdiet turpis justo, ac placerat risus gravida sed. Suspendisse potenti.
			</p>
			<p>
				Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris nisl sem, fringilla nec neque molestie, porttitor accumsan tellus. Nam felis odio, sollicitudin a mi vitae, vehicula dictum diam. Cras condimentum sit amet lacus at luctus. Curabitur aliquet ante consequat, aliquet ligula eu, congue nisl. Proin nibh ligula, ornare vel elit ac, sagittis lacinia tellus. Duis non orci egestas, pharetra purus id, mattis nisi. Maecenas sagittis, erat id placerat placerat, ante est rhoncus ligula, eget aliquet tellus odio vitae augue. Cras non mauris neque. Cras varius vestibulum dui sed rutrum. Maecenas nisl est, pharetra sit amet risus eget, ornare scelerisque lorem. Nunc at dolor non odio ullamcorper vulputate vitae a purus.
			</p>
			<p>
				Quisque semper varius nisl vel facilisis. Maecenas ornare molestie diam vitae ultrices. Donec vel erat quis magna tempor pharetra. Quisque congue lorem sit amet ultrices cursus. Suspendisse turpis sapien, mattis ac augue eget, varius sollicitudin dui. Mauris vel justo in nulla convallis aliquam ut vel elit. Sed pretium rhoncus imperdiet. Ut lacus erat, suscipit quis enim et, iaculis dictum ipsum. Vestibulum dignissim, lacus vel aliquet molestie, urna purus cursus libero, in lacinia velit leo a enim. Ut et interdum magna, sit amet placerat erat. Praesent nec tempor neque. Cras ultricies odio a dui fringilla consequat. Donec dictum consequat eros quis lobortis. Proin venenatis lacus et sem congue, at placerat velit consectetur. Nunc lobortis est a dolor varius, non vestibulum elit feugiat.
			</p>
		</div>

		<!-- Begin FAQ content -->
		<div class="container" id="faq">
			<div class="page-header">
				<h1>Frequently Asked Questions</h1>
			</div>
			<div class="col-sm-9">
				<p class="lead">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
				</p>
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									Question #1
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
									Question #2
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									Question #3
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									Question #4
								</a>
							</h4>
						</div>
						<div id="collapseFour" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									Question #5
								</a>
							</h4>
						</div>
						<div id="collapseFive" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
									Question #6
								</a>
							</h4>
						</div>
						<div id="collapseSix" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
									Question #7
								</a>
							</h4>
						</div>
						<div id="collapseSeven" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
									Question #8
								</a>
							</h4>
						</div>
						<div id="collapseEight" class="panel-collapse collapse">
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3 hidden-xs">
				<img class="img-responsive img-rounded" src="data/img/buiz3.jpg">
			</div>
		</div>

		<!-- Begin SEARCH content -->
		<div class="container" id="contacts" data-ng-controller="search">
			<div class="page-header">
				<h1>Contacts</h1>
			</div>
			<p class="lead">
				Find your friends and colleagues from ELA right here.
			</p>

			<div class="row">
				<div class="col-md-7 col-sm-8"><!-- search -->
					<div class="input-group">
						<label class="input-group-addon" for="search_field">Search</label>
						<input type="text" class="form-control" id="search_field" placeholder="Type here..." data-ng-model="search_str">
						<span class="input-group-btn">
							<button class="btn btn-danger" data-ng-click="search_str=''">
								<i class="glyphicon glyphicon-remove" style="top:2px"></i>
							</button>
						</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-4 hidden-xs"><!-- order -->
					<div class="input-group">
						<label class="input-group-addon" for="search_order">Order</label>
						<select ng-model="field" class="form-control" id="search_order" 
							data-ng-options="x.field as x.disp for x in fields" 
							data-ng-change="sort_order=false">
							<option value="" disabled>Order By...</option>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-info" data-ng-click="sort_order=!sort_order">
								<i class="glyphicon" data-ng-class="{'glyphicon-chevron-down':sort_order, 'glyphicon-chevron-up':!sort_order}"></i>
							</button>
						</span>
					</div>
				</div>
				<div class="col-md-2 hidden-xs hidden-sm"><!-- pagination -->
					<div class="input-group">
						<label class="input-group-addon" for="search_page">Limit</label>
						<select ng-model="limit" class="form-control" id="search_page" data-ng-options="x for x in limits">
							<option value="" disabled>Per Page...</option>
						</select>
				</div>
			</div>
			<div style="min-height: 600px"><!-- eases the scroll jerk on small searches -->
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Contact</th>
							<th style="width:75%" class="hidden-xs">
								<small class="pull-right text-right" style="font-weight:normal" data-ng-bind="total_rows()"></small>
								Bio
							</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="user in (filtered_users = (users | filter:search_str)) | orderBy:field:sort_order | pagination:page:limit">
							<td>
								<div class="center-cropped pull-left img-rounded">
									<img data-ng-src="img/{{user.Last}}, {{user.First}}.jpg" class="img-rounded" height="100px" 
										data-ng-attr-title="{{user.First}} {{user.Last}}"
										data-ng-attr-alt="{{user.First}} {{user.Last}}" />
								</div>
								<strong>
									<span data-ng-bind="user.First">John</span>&nbsp;
									<span data-ng-bind="user.Last">Doe</span>
								</strong><br/>
								<small data-ng-bind="user.TITLE">Intern</small><br/>
								<span class="text-muted">
									<span data-ng-bind="user.COMPANY">Temporary INC.</span><br/>
									<span data-ng-bind="user.CITY">Two Dot</span>,&nbsp;<span data-ng-bind="user.STATE">MT</span>
								</span>
							</td>
							<td data-ng-bind="user.Bio" class="hidden-xs">was an amazing ...</td>
						</tr>
					</tbody>
				</table>

				<div class="text-center" data-ng-show="pages() !== 1"><!-- pager -->
					<pagination num-pages="pages()" current-page="page" max-show="5"></pagination>
				</div>
			</div>
		</div>
	</div>

	<div id="footer">
		<div class="container">
			<p class="pull-right social">
				<a href="http://www.linkedin.com/groups?gid=4403897" target="blank">
					<i class="fa fa-linkedin-square text-muted"></i>
				</a>
			</p>
			<p class="text-muted credit">
				&copy; <a href="http://upstreamacademy.com">Upstream Academy</a> 
				<script>document.write(new Date().getFullYear())</script>
			</p>
		</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.min.js"></script>
	<script src="js.js"></script>
</body>
</html>