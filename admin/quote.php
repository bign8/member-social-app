<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quote Editor</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.table .add { width: 100%; }
		.table .view label { width: 100%; }
		.table .editing .view { display: none; }
		.table .edit { display: none; }
		.table .editing .edit { display: block; }
	</style>
</head>
<body data-ng-app="ela-quote">
	
	<div class="container" data-ng-controller="quote-edit">
		<table class="table" data-ng-cloak>
			<thead>
				<tr>
					<th class="col-sm-2">Author</th>
					<th class="col-sm-10">Quote</th>
				</tr>
			</thead>
			<tbody>
				<tr class="add">
					<td colspan="2">
						<form data-ng-submit="add_item()" class="add">
							<div class="col-sm-2">
								<input type="text" class="form-control" placeholder="New Author" data-ng-model="new_quote.author">
							</div>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="New Quote" data-ng-model="new_quote.quote">
									<span class="input-group-btn">
										<button class="btn btn-success" type="submit">+</button>
									</span>
								</div>
							</div>
						</form>
					</td>
				</tr>
				<tr data-ng-repeat="q in quotes">
					<td data-ng-class="{editing: (editing == q && field == 'author')}">
						<div class="view">
							<label data-ng-bind="q.author" data-ng-dblclick="start_editing(q, 'author')"></label>
						</div>
						<form data-ng-submit="done_editing(q)">
							<input type="text" class="edit form-control" data-ng-model="q.author" data-ng-blur="done_editing(q)" data-edit-escape="undo_editing(q)" data-edit-focus="q == editing">
						</form>
					</td>
					<td data-ng-class="{editing: (editing == q && field == 'quote')}">
						<div class="view" data-ng-dblclick="start_editing(q, 'quote')">
							<span data-ng-bind="q.quote"></span>
							<button type="button" class="close" aria-hidden="true" data-ng-click="remove_item(q)">&times;</button>
						</div>
						<form data-ng-submit="done_editing(q)">
							<input type="text" class="edit form-control" data-ng-model="q.quote" data-ng-blur="done_editing(q)" data-edit-escape="undo_editing(q)" data-edit-focus="q == editing">
						</form>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- <pre>{{quotes | json}}</pre> -->
	</div>

	<!-- // <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
	<!-- // <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.min.js"></script>
	<!-- // <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.min.js"></script> -->
	<script src="quote.js"></script>
</body>
</html>