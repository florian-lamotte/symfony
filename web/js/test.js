var blog = angular.module("blog", []);

blog.controller("BlogController",function($scope, $http){
	$http.get("/api/post").then(function (response) {
	  	$scope.Mydata = response.data.posts;
	  	console.log($scope.Mydata);
  	});
});