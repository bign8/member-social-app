<div class="container" id="profile">
	<div class="page-header">
		<h1>Profile <small><?php echo $_SESSION['user']['first'] . ' ' . $_SESSION['user']['last']; ?></small></h1>
	</div>
	<p class="lead">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac eleifend nisl. Mauris vitae tincidunt turpis, quis facilisis orci. Maecenas elementum sapien vitae libero semper commodo. Quisque tincidunt, dui vitae laoreet sollicitudin, sem tellus interdum odio, eu ornare tellus tellus ac tortor. Nulla laoreet urna ligula, ut ultrices dui ultricies et. Proin in viverra tellus. Duis vel sem quis neque molestie vehicula id eu mauris. Mauris eleifend ut est at luctus. Sed nec ligula a lectus ultricies bibendum viverra vitae ante. Suspendisse fringilla turpis nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec fermentum nisl urna, non dictum dolor facilisis eu.
	</p>
	<div class="well">
		<form role="form" action="index.php#profile" method="post" class="form-horizontal clearfix">
			<div class="row">
				<div class="col-sm-2">
					<img class="img-responsive img-rounded" style="margin-bottom: 10px"
						src="img-full/<?php echo $_SESSION['user']['last'] . ',%20' . $_SESSION['user']['first']; ?>.jpg">
					<input id="user_image" type="file" class="hidden" accept="image/*" />
					<input type="button" class="btn btn-sm btn-default col-sm-12" value="Choose" onclick="user_image.click()" />
				</div>

				<div class="col-sm-4">
					<?php if (in_array('profile-error', $app->status)): ?>
						<div class="alert alert-danger">
							<strong>Something went wrong</strong> 
							and we were unable to save your changes. 
						</div>
					<?php endif; ?>
					<div class="form-group">
						<label for="user_first" class="col-sm-3 control-label">First&nbsp;Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_first" placeholder="First Name" name="first" 
								value="<?php echo $_SESSION['user']['first']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_last" class="col-sm-3 control-label">Last&nbsp;Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_last" placeholder="Last Name" name="last"
								value="<?php echo $_SESSION['user']['last']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_title" class="col-sm-3 control-label">Title</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_title" placeholder="Title" name="title"
								value="<?php echo $_SESSION['user']['title']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_company" class="col-sm-3 control-label">Company</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_company" placeholder="Company" name="company"
								value="<?php echo $_SESSION['user']['company']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_city" class="col-sm-3 control-label">City</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_city" placeholder="City" name="city"
								value="<?php echo $_SESSION['user']['city']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="user_state" class="col-sm-3 control-label">State</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user_state" placeholder="State" name="state"
								value="<?php echo $_SESSION['user']['state']; ?>">
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="user_bio">Biography</label>
					<textarea id="user_bio" class="form-control text-auto-scale" placeholder="Bio..." rows="10" name="bio"><?php echo $_SESSION['user']['bio']; ?></textarea>
					<p class="help-block">* Your first name is automatically prepended when printing</p>
				</div>
			</div>
			<button type="submit" class="btn btn-primary pull-right" name="profile">Save Changes</button>
			<button type="reset" class="btn btn-default" name="reset">Reset</button>
		</form>
	</div>
	<p>
		In feugiat tincidunt tortor. Quisque cursus purus a justo egestas, id consectetur tellus vulputate. Quisque sed blandit nulla. Nunc fringilla quis lacus eget hendrerit. Etiam tincidunt metus at nisl scelerisque dapibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus vestibulum mauris lacus, nec accumsan lectus adipiscing nec. Vestibulum convallis suscipit lectus vitae eleifend. Proin luctus pulvinar mi et elementum. Pellentesque luctus, metus quis elementum dictum, leo lorem posuere odio, vel accumsan tellus odio at risus. Proin tempus imperdiet quam nec vestibulum.
	</p>
</div>