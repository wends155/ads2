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

ProductCtrl = ['$scope','$http',($scope, $http)->
	$http.get('/product/all.json').success (data)->
		$scope.products = data
	$http.get('/company/all.json').success (data)->
		$scope.companies = data
	$http.get('/category/all.json').success (data)->
		$scope.categories = data
	$http.get('/brand/all.json').success (data)->
		$scope.brands = data
	$scope.limit = 20
	$scope.show = false
	$scope.saved = false
	$scope.showform = ->
		$scope.show = true
	$scope.submit = ->
		$http.post('/product/new.json', JSON.stringify($scope.product)).success ->
			$scope.saved = true
			$scope.products.push($scope.product)
			$scope.product = {}
			@
	$scope.delete = (id)->
		$http.delete('/product/' + id + '.json').success ->
			$http.get('/product/all.json').success (data)->
				$scope.products = data
				@
		@
	@
]

ProductDetailCtrl = ['$scope','$routeParams','$http',($scope,$routeParams,$http) -> 
	$http.get('/product/' + $routeParams.id + '.json').success (data)->
		$scope.product = data
	$scope.id = $routeParams.id
	$scope.saved = false;
	$scope.submit = ->
		$http.post('/product/' + $scope.id + '.json',JSON.stringify($scope.product)).success ->
			$scope.saved = true
			@
	@
]

BrandCtrl = ['$scope','$http',($scope, $http)->
	
	@
]

CompanyCtrl = ['$scope','$http',($scope, $http)->
	
	@
]

CategoryCtrl = ['$scope','$http',($scope, $http)->
	
	@
]