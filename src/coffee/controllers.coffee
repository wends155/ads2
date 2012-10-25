ProductListCtrl = ['$scope','$http','$filter', ($scope,$http,$filter) ->
	$http.get('/product/all.json').success (data)->
		$scope.products = data
	@
]


PhoneDetailCtrl = ['$scope','$routeParams', ($scope,$routeParams) ->
	$scope.phoneId = $routeParams.phoneId
	$scope.spinner = true
	$scope.hello = (name) -> 
		$scope.msg = "hello #{name}"
		$scope.spinner = false
	@
]

ProductCtrl = ['$scope','$http',($scope, $http)->
	$http.get('/product/all.json').success (data)->
		$scope.products = data
		$scope.spinner = false
	$http.get('/company/all.json').success (data)->
		$scope.companies = data
	$http.get('/category/all.json').success (data)->
		$scope.categories = data
	$http.get('/brand/all.json').success (data)->
		$scope.brands = data

	$scope.limit = 20
	$scope.saved = false
	$scope.spinner = true
	$scope.cancel = ->
		$scope.product = {}
	$scope.submit = ->
		console.log JSON.stringify($scope.product)
		$http.post('/product/new.json', JSON.stringify($scope.product)).success (data)->
			$scope.saved = true
			$scope.products.push(data)
			$scope.product = {}
			@
	$scope.delete = (id)->
		$http.delete("/product/#{id}.json").success ->
			$http.get('/product/all.json').success (data)->
				$scope.products = data
				@
		@
	@
]

ProductDetailCtrl = ['$scope','$routeParams','$http',($scope,$routeParams,$http) -> 
	$http.get('/product/' + $routeParams.id + '.json').success (data)->
		$scope.product = data
		$scope.spinner = false
	$http.get('/company/all.json').success (data)->
		$scope.companies = data
	$http.get('/category/all.json').success (data)->
		$scope.categories = data
	$http.get('/brand/all.json').success (data)->
		$scope.brands = data
	$scope.id = $routeParams.id
	$scope.spinner = true
	$scope.saved = false;
	$scope.submit = ->
		console.log JSON.stringify($scope.product)
		$http.post('/product/' + $scope.id + '.json',JSON.stringify($scope.product)).success ->
			$scope.saved = true
			@
	@
]

BrandCtrl = ['$scope','$http',($scope, $http)->
	$http.get('/brand/all.json').success (data)->
		$scope.brands = data
	$scope.delete = (id) ->
		$http.delete('/brand/'+id+'.json').success ->
			$http.get('/brand/all.json').success (data)->
				$scope.brands = data
	$scope.submit = ->
		$http.post('/brand/new.json', JSON.stringify($scope.brand)).success (data)->
			$scope.brands.push(data)
			$scope.brand = {}
	@
]

BrandDetailCtrl = ['$scope','$http', '$routeParams','Brand', ($scope, $http, $routeParams,Brand) ->
	$scope.id = $routeParams.id
	$http.get('/brand/'+$scope.id+'.json').success (data)->
		$scope.brand = data
	$scope.caption = "Cancel"
	$scope.products = Brand.products({id:$scope.id})
	
	$scope.submit = ->
		$http.post('/brand/' + $scope.id + '.json', JSON.stringify($scope.brand)).success ->
			$scope.saved = true
			$scope.caption = "Back"
]

CompanyCtrl = ['$scope','$http',($scope, $http)->
	$http.get('/company/all.json').success (data)->
		$scope.companies = data

	$scope.delete = (id)->
		$http.delete('/company/'+id+'.json').success ->
			$http.get('/company/all.json').success (data)->
				$scope.companies = data
				@
			@
	@
	$scope.submit = ->
		$http.post('/company/new.json', JSON.stringify($scope.company)).success (data)->
			$scope.companies.push(data)
			$scope.company = {}
			@
]

CompanyDetailCtrl = ['$scope','$routeParams','$http',($scope,$routeParams,$http)->
	$http.get('/company/'+ $routeParams.id + '.json').success (data)->
		$scope.company = data
	$scope.caption = "Cancel"
	$scope.submit = ->
		$http.post('/company/' + $routeParams.id + '.json', JSON.stringify($scope.company)).success ->
			$scope.saved = true
			$scope.caption = "Back"
		
]

CategoryCtrl = ['$scope','$http',($scope, $http)->
	$http.get('/category/all.json').success (data)->
		$scope.categories = data

	$scope.delete = (id)->
		$http.delete('/category/'+id+'.json').success ->
			$http.get('/category/all.json').success (data)->
				$scope.categories = data
			@
		@
	@
	$scope.submit = ->
		$http.post('/category/new.json', JSON.stringify($scope.category)).success (data)->
			$scope.categories.push(data)
			$scope.category = {}
			@
]

CategoryDetailCtrl = ['$scope','$routeParams','$http',($scope,$routeParams,$http)->
	$http.get('/category/'+$routeParams.id+'.json').success (data)->
		$scope.category = data
	$scope.caption = "Cancel"
	$scope.submit = ->
		$http.post('/category/'+$routeParams.id+'.json', JSON.stringify($scope.category)).success ->
			$scope.saved = true
			$scope.caption = "Back"
]