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

MenuCtrl = ['$scope','Cart','$location','$rootScope','Order','$timeout', 
($scope,Cart,$location,$rootScope,Order,$timeout)->
	checker = null
	Order.query((data)->
		$scope.order = data.length
		)
	$scope.orderCount = 0

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
	checkOrders = ->
		clearTimeout(checker)
		console.log "code change 2"
		checker = $timeout(checkOrders,1000)
		@
	checkOrders()
	$scope.stop = ->
		$timeout.cancel($scope.timeout)
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

OrderCtrl = ['$scope','adOrder','$location',($scope,Order,$location)->
	#window.order = Order
	Order.query((data)->
		#console.log data
		$scope.data = data
		$scope.orders = data
		$scope.spinner = true
	)
	$scope.claim = (order)->
		order.date_claimed = Date.now() / 1000
		console.log order.total - order.downpayment
		order.balance = order.total - order.downpayment
		order.$save()
		humane.log "Order claimed"

	$scope.filterClaim = ->
		console.log "claim: #{$scope.claimed}"
		if($scope.claimed)
			filter = (o for o in $scope.data when o.date_claimed != null)
			#console.log filter
			$scope.orders = filter
		else
			filter = (o for o in $scope.data when o.date_claimed == null)
			$scope.orders = filter
			#console.log filter
		
	$scope.filterPay = ->
		#console.log "pay: #{$scope.paid}"
		if($scope.paid)
			filter = (p for p in $scope.data when p.date_paid != null)
			$scope.orders = filter
		else
			filter = (p for p in $scope.data when p.date_paid == null)
			$scope.orders = filter


	$scope.reset = ->
		$scope.orders = $scope.data
		$scope.claimed = false
		$scope.paid = false

	$scope.pay = (id)->
		
		$location.path("/orders/pay/#{id}")
]

OrderDetailCtrl = ['$scope','$routeParams','adOrder','$location',($scope,$routeParams,Order,$location)->
	console.log $routeParams.id
	Order.get({id:$routeParams.id},(data)->
		$scope.order = data
		$scope.spinner = true
		console.log data
	)
	$scope.pay = (id)->
		$location.path("/orders/pay/#{id}")
	$scope.return = (id) ->
		$location.path("/return/#{id}")

]

OrderClaimCtrl = ['$scope','$routeParams','adOrder','Sales','$location',($scope,$routeParams,Order,Sales,$location)->
	console.log $routeParams.id
	Order.get({id:$routeParams.id},(data)->
		$scope.order = data
		console.log data
		$scope.spinner = true
	)
	$scope.submit = ->
		current_date = Math.round(Date.now()/1000)
		$scope.order.date_claimed = current_date
		$scope.order.due = current_date + (3600*24*30)
		$scope.order.balance = $scope.order.total - $scope.order.downpayment
		$scope.order.$save()
		sales = new Sales()
		sales.date = current_date
		sales.order_id = $scope.order.id
		sales.amount = $scope.order.downpayment
		sales.$save()
		$location.path('/orders')

]

OrderPayCtrl = ['$scope','$routeParams','adOrder','Sales','$location',($scope,$routeParams,Order,Sales,$location)->
	Order.get({id:$routeParams.id},(data)->
		$scope.order = data
		$scope.spinner = true
	)
	$scope.submit = ->
		current_date = Math.round(Date.now()/1000)
		amount = parseFloat( $scope.order.balance)
		$scope.order.date_paid = current_date
		$scope.order.balance = parseFloat($scope.order.balance) - amount
		console.log $scope.order.balance
		$scope.order.$save()

		sales = new Sales()
		sales.date = current_date
		sales.order_id = $scope.order.id
		sales.amount = amount
		sales.$save()
		$location.path('/orders')
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

SalesCtrl = ['$scope','Sales',($scope,Sales)->
	window.sales = Sales
]

RetExCtrl = ['$scope','Retex',($scope,Retex)->
	Retex.query((data)->
		$scope.data = data
		$scope.items = data
		console.log data
	)
]

WeeklyCtrl = ['$scope','Sales',($scope,Sales)->
	Sales.query((data)->
		$scope.data = data
		console.log data
		#$scope.sales = data
		#total = 0
		#total += parseFloat(s.amount) for s in $scope.sales
		#$scope.total = total
		$scope.spinner = true
	)

	$scope.submit = ->
		from = (new Date($scope.dateFrom)).valueOf()
		console.log 'from: ' + from
		to = (new Date($scope.dateTo)).valueOf()
		console.log 'to: ' + to
		a = (s for s in $scope.data when (s.date*1000)>=from)
		f = (s for s in a when (s.date*1000 <= (to+86400000) ))
		console.log f
		$scope.sales = f
		
		total = 0
		total += parseFloat(s.amount) for s in $scope.sales
		$scope.total = total
]

MonthlyCtrl = ['$scope','Sales',($scope,Sales)->
	$scope.currMonth = (new Date()).getMonth()
	$scope.year = (new Date()).getFullYear()
	Sales.query((data)->
		$scope.data = data
		f = (s for s in data when ((new Date(s.date*1000)).getMonth() == $scope.currMonth))
		total = 0
		total += parseFloat(s.amount) for s in f
		console.log  f
		console.log total
		$scope.sales = f
		$scope.total = total
		$scope.spinner = true
	)

	$scope.changeMonth = ->
		#console.log $scope.month
		#console.log $scope.data
		f = (s for s in $scope.data when ((new Date(s.date*1000)).getMonth() == parseInt($scope.month)) and (new Date(s.date*1000)).getFullYear() == $scope.year )
		console.log  f
		total = 0
		total += parseFloat(s.amount) for s in f
		console.log total
		$scope.sales = f
		$scope.total = total

]

DuesCtrl = ['$scope', 'Dues','sms', ($scope,Dues,sms) -> 
	Dues.query((data)->
		#console.log data
		$scope.orders = data
		$scope.spinner = true
		window.sms = sms
		console.log 'sms'
	)

	$scope.notify = (order) ->
		#alert order.mobile
		m_no = order.mobile
		due = new Date(parseInt(order.due)*1000)
		ddate = (due.getMonth()+1) + "/" + due.getDate() + "/" + due.getFullYear()

		console.log ddate
		send = new sms()
		console.log send
		console.log parseInt(order.due)
		send.number = m_no
		send.message = "your due date for order##{order.id} is on #{ddate}"
		send.$save()
		alert "notification sent to #{m_no}"
		order.notified = true
]

admin.controller('MenuCtrl',MenuCtrl)