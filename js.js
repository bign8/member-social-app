angular.module('ela', []).

controller('search', ['$scope', '$http', function ($scope, $http) {

	// Initialize user data
	$scope.users = $scope.filtered_users = [];
	$http.get('search.php').then(function (res) {
		$scope.users = res.data;

		var imgQueue = [];
		angular.forEach($scope.users, function (value) {
			value.Bio = value.First + /*' ' + value.Last +*/ ' ' + value.Bio;
			imgQueue.push(value);
		});

		// Image queue Processor
		(function ( queue ) {
			var image = new Image(), user;
			var queue_handler = function () {
				if (queue.length) {
					user = queue.shift();
					image.src = 'img/' + user.Last + ', ' + user.First + '.jpg';
				}
			};
			image.onload = queue_handler;
			image.onerror = function (e) {
				console.log('Image Frefetch Error');
				console.log(e);
				queue_handler();
			};
			queue_handler();
		})( imgQueue );
		
	});

	// Searching
	$scope.total_rows = function () {
		var tail = ($scope.filtered_users.length == $scope.users.length) ? '' : (' of ' + $scope.users.length);
		return 'Total: ' + $scope.filtered_users.length + tail;
	};

	// Pagination
	$scope.limits = [5,10,25,50,100];
	$scope.limit = $scope.limits[0];
	$scope.page = 1;
	$scope.pages = function () {
		return Math.ceil( $scope.filtered_users.length / $scope.limit ) || 1;
	};

	// Order By
	$scope.fields = [
		{field: ['First','Last'], disp: 'First Name'},
		{field: ['Last','First'], disp: 'Last Name'},
		{field: ['TITLE','First','Last'], disp: 'Title'},
		{field: ['COMPANY','First','Last'], disp: 'Company'},
		{field: ['CITY','STATE','First','Last'], disp: 'City'},
		{field: ['STATE','CITY','First','Last'], disp: 'State'}
	];
	$scope.field = $scope.fields[0].field;
	$scope.sort_order = false;
}]).

filter('pagination', function () {
	return function (inputArray, selectedPage, pageSize) {
		var start = (selectedPage-1) * pageSize;
		return inputArray.slice(start, start + pageSize);
	};
}).

directive('pagination', function () {
	return {
		restrict: 'E',
		scope: {
			numPages: '=',
			currentPage: '=',
			maxShow: '='
		},
		template: '' + 
			'<ul class="pagination">' + 
			'	<li ng-class="{disabled: noPrevious()}">' + 
			'		<a ng-click="selectPage( 1 )">&laquo;</a>' + 
			'	</li>' + 
			'	<li ng-class="{disabled: noPrevious()}">' + 
			'		<a ng-click="selectPrevious()">&lsaquo;</a>' + 
			'	</li>' + 
			'	<li ng-repeat="page in print_pages" ng-class="{active: isActive(page)}">' + 
			'		<a ng-click="selectPage(page)">{{page}}</a>' + 
			'	</li>' + 
			'	<li ng-class="{disabled: noNext()}">' + 
			'		<a ng-click="selectNext()">&rsaquo;</a>' + 
			'	</li>' + 
			'	<li ng-class="{disabled: noNext()}">' + 
			'		<a ng-click="selectPage( numPages )">&raquo;</a>' + 
			'	</li>' + 
			'</ul>',
		replace: true,
		link: function ($scope) {

			// thanks: https://github.com/angular-ui/bootstrap/blob/master/src/pagination/pagination.js#L134
			var trim_pager = function () {
				startPage = Math.max($scope.currentPage - Math.floor($scope.maxShow/2), 1);
				endPage   = Math.min(startPage + $scope.maxShow - 1, $scope.numPages);
				if (endPage >= $scope.numPages) startPage = endPage - $scope.maxShow + 1; // adjust if necessary
				$scope.print_pages = $scope.pages.slice(startPage-1, endPage);
			};
			$scope.$watch('numPages', function (value) {
				$scope.pages = [];
				for (var i = 1; i <= value; i++) $scope.pages.push(i);
				if ( $scope.currentPage > value ) $scope.selectPage(value);
				trim_pager();
			});
			$scope.$watch('currentPage', trim_pager);

			$scope.noPrevious = function () {
				return $scope.currentPage === 1;
			};
			$scope.noNext = function () {
				return $scope.currentPage === $scope.numPages;
			};
			$scope.isActive = function (page) {
				return $scope.currentPage === page;
			};
			$scope.selectPage = function (page) {
				if ( !$scope.isActive(page) ) $scope.currentPage = page;
			};
			$scope.selectNext = function () {
				if ( !$scope.noNext() ) $scope.selectPage( $scope.currentPage + 1 );
			};
			$scope.selectPrevious =  function () {
				if ( !$scope.noPrevious() ) $scope.selectPage( $scope.currentPage - 1 );
			};
		}
	}
});