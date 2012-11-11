#Admin Pages Controllers
#======================
#These are controllers used in the admin pages
#

#Product List Controller
#----------------------
#deprecated function
#
ProductListCtrl = ['$scope','$http','$filter', ($scope,$http,$filter) ->
	$http.get('/product/all.json').success (data)->
		$scope.products = data
	
]

#Phone Details Controller
#-----------------------
#
#todo
PhoneDetailCtrl = ['$scope','$routeParams', ($scope,$routeParams) ->
	$scope.phoneId = $routeParams.phoneId
	$scope.spinner = true
	# change the spinner
	$scope.hello = (name) -> 
		$scope.msg = "hello #{name}"
		$scope.spinner = false
	
]

MenuCtrl = ['$scope','Cart','$location','$rootScope','Order', ($scope,Cart,$location,$rootScope,Order)->
	Order.query((data)->
		$scope.order = data.length
		)
	
	$scope.count = ->
		Cart.items.length

	$scope.logout = ->
		#$location.path('/')
		$rootScope.$broadcast('logout',{})
		$location.path('/logout')
		Cart.clear()
	$scope.$on('$routeChangeSuccess',->
		$scope.activePath = $location.path()
		#console.log $scope.activePath
	)
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
			
	$scope.delete = (id)->
		$http.delete("/product/#{id}.json").success ->
			$http.get('/product/all.json').success (data)->
				$scope.products = data
	
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
	
	$scope.submit = ->
		$http.post('/company/new.json', JSON.stringify($scope.company)).success (data)->
			$scope.companies.push(data)
			$scope.company = {}
	
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
	
	$scope.submit = ->
		$http.post('/category/new.json', JSON.stringify($scope.category)).success (data)->
			$scope.categories.push(data)
			$scope.category = {}
	
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

OrderCtrl = ['$scope','adOrder',($scope,adOrder)->
	window.order = adOrder
]

OrderDetailCtrl = ['$scope','$routeParams',($scope,$routeParams)->
	console.log $routeParams.id
]

ProfilesCtrl = ['$scope','adProfiles',($scope,profiles)->
	profiles.query((data)->
		$scope.profiles = data
		$scope.spinner = true
		#window.profiles = data
	)
	$scope.remove = (profile)->
		profile.$delete(->
			profiles.query((data)->
				$scope.profiles = data
				humane.log "dealer removed from list"
			)
		)
		
		
]

ProfilesDetailCtrl = ['$scope','adProfiles','$routeParams',($scope,profiles,$routeParams)->
	profiles.get({id:$routeParams.id},(data)->
		$scope.profile = data
		window.profile = data
	)
]

ProfileOrdersCtrl = ['$scope','adProfiles','$routeParams',($scope,profiles,$routeParams)->
	profiles.orders({id:$routeParams.id}, (data)->
		$scope.data = data
		$scope.orders = data
		$scope.predicate = ''
		$scope.reverse = true
		$scope.spinner = true
	)
	$scope.filterPaid = ->
		
			if($scope.paid)
				o = (ord for ord in $scope.data when ord.date_paid != null)
				$scope.orders = o
				
			else 
				o = (ord for ord in $scope.data when ord.date_paid == null)
				$scope.orders = o
				
		
	$scope.filterClaimed = ->
		
			if($scope.claimed)
				o = (ord for ord in $scope.data when ord.date_claimed != null)
				$scope.orders = o
			else
				o = (ord for ord in $scope.data when ord.date_claimed == null)
				$scope.orders = o
	$scope.reset = ->
		$scope.paid = false
		$scope.claimed = false
		$scope.orders = $scope.data
]

StockCtrl = ['$scope','Stock','Product',($scope,Stock,Product)->
	Stock.query((data)->
		$scope.stocks = data
		window.stocks = data
		$scope.spinner = true
	)
	$scope.delete = (stock)->
		ok = confirm("Do you want to delete #{stock.product.name}")
		if (ok)
			stock.$delete(->
				$scope.spinner =false
				Stock.query((data)->
					$scope.stocks = data
					$scope.spinner = true
					humane.log "#{stock.product.name} removed from list"
				)
			)
]

StockAddCtrl = ['$scope','Stock','Product','$location',($scope,Stock,Product,$location)->
	Product.query((products)->
		#$scope.products = data
		Stock.query((stocks)->
			stock_ids = (s.product.id for s in stocks)
			console.log stock_ids
			data = (s for s in products when s.id not in stock_ids)
			console.log data
			$scope.products = data
			$scope.spinner = true
		)
	)
	$scope.stock = new Stock()

	$scope.submit = ->
		stock_selected = $scope.stock.product
		$scope.stock.$save(
			->
				st = (s for s in $scope.products when s.id != stock_selected.id)	
				$scope.products = st
				humane.log "Stock '#{stock_selected.name}'' added"
				$location.path('/stocks')
			-> 
				humane.log "failed" 

		)

]

StockIncCtrl = ['$scope','$routeParams','Stock','$http','$location',($scope,$routeParams,Stock,$http,$location)->
	id = $routeParams.id
	Stock.get({id:id},(data)->
		$scope.stock = data
		console.log data
	)
	$scope.submit = ->
		$http.get("/stocks/#{id}/inc/#{$scope.stock.value}").success(->
			humane.log "'#{$scope.stock.product.name}'' Stock increased by #{$scope.stock.value}"
			$location.path('/stocks')
		).error(->
			humane.log "failed"
		)

]

StockDecCtrl = ['$scope','$routeParams','Stock','$http','$location',($scope,$routeParams,Stock,$http,$location)->
	id = $routeParams.id
	Stock.get({id:id},(data)->
		$scope.stock = data
		console.log data
	)
	$scope.submit = ->
		$http.get("/stocks/#{id}/dec/#{$scope.stock.value}").success(->
			humane.log "'#{$scope.stock.product.name}'' Stock decreased by #{$scope.stock.value}"
			$location.path('/stocks')
		).error(->
			humane.log "failed"
		)
		

]

StockReportCtrl = ['$scope',($scope)->

]

admin.controller('MenuCtrl',MenuCtrl)