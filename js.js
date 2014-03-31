"use strict";

// jQuery soft scroll
jQuery.fn.scroll_top = function (cb) {
	if ( this.offset() ) jQuery('html, body').animate({
		scrollTop: parseInt( this.offset().top, 10 )
	}, 500, cb);
};
jQuery('ul.nav a,a.navbar-brand').click( function (e){
	if ( e.target.hash ) {
		jQuery( e.target.hash ).scroll_top(function() {
			if (e.target.hash == '#login') $('#inputUser').focus();
		});
		e.preventDefault();
	}
});

// angular application
angular.module('ela', [
	'ui.bootstrap'
]).

controller('search', ['$scope', '$http', '$modal', function ($scope, $http, $modal) {

	// Initialize user data
	$scope.users = $scope.filtered_users = [];
	$http.get('api.php?action=search').then(function (res) {
		$scope.users = res.data;

		angular.forEach($scope.users, function (value) {
			value.bio = value.first + /*' ' + value.Last +*/ ' ' + value.bio;
		});
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

	// Order By
	$scope.fields = [
		{field: ['first','last'], disp: 'First Name'},
		{field: ['last','first'], disp: 'Last Name'},
		{field: ['title','first','last'], disp: 'Title'},
		{field: ['company','first','last'], disp: 'Company'},
		{field: ['city','state','first','last'], disp: 'City'},
		{field: ['state','city','first','last'], disp: 'State'}
	];
	$scope.field = $scope.fields[0].field;
	$scope.sort_order = false;

	// Details
	$scope.view = function (user) {
		var instance = $modal.open({
			templateUrl: 'tpl/note.tpl.html',
			controller: ['$scope', 'person', '$modalInstance', function ($scope, person, $modalInstance) {
				$scope.person = person;
				$scope.ok = function () { $modalInstance.close($scope.person); };
				$scope.cancel = function () { $modalInstance.dismiss('cancel'); };
			}],
			resolve: {
				person: function () { return angular.copy(user); }
			},
			windowClass: 'person-notes'
		});
		instance.result.then(function (person) {
			angular.extend(user, person);
			$http.post('api.php?action=note', person).then(function (res) {
				angular.extend(user, res.data);
			});
		});
	};
}]).

filter('pagination', function () {
	return function (inputArray, selectedPage, pageSize) {
		var start = (selectedPage-1) * pageSize;
		return inputArray.slice(start, start + pageSize);
	};
}).

directive('textAutoScale', function () {
	return {
		restrict: 'C',
		link: function(scope, element, attrs) {
			element.on('keyup', function (e) {
				e.target.style.height = "1px";
    			e.target.style.height = (25+e.target.scrollHeight)+"px";
			});
			scope.$watch(function () { return element.is(':visible'); }, function () { element.keyup(); });
		}
	}
});