ProductListCtrl = ['$scope','$http','$filter', ($scope,$http,$filter) ->
	$http.get('/product/all.json').success (data)->
		$scope.products = data
			

	@
]


PhoneDetailCtrl = ['$scope','$routeParams', ($scope,$routeParams) ->
	$scope.phoneId = $routeParams.phoneId
	$scope.hello = (name) -> 
		$scope.msg = "hello #{name}"
		
	@
]