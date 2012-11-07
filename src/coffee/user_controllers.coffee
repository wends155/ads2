UserCatalogCtrl = ['$scope','Company','Category','Product', ($scope,Company, Category,Product)->
	$scope.companies = Company.query()
	$scope.categories = Category.query()
	$scope.products = Product.query()
	console.log $scope.categories
	console.log $scope.companies
	console.log $scope.products
]

UserIndexCtrl = ['$scope','$http', ($scope,$http)->
	#humane.log('welcome')
	
]

UserCartCtrl = ['$scope','Cart', ($scope,Cart)->
	subt = (item) ->
		item.subtotal = item.price * item.quantity
	test_items = [
		{
			id:1
			name:'wewe'
			price:240.5
			quantity:2

		},
		{
			id:2
			name:'imari'
			price: 120
			quantity:1
		},
		{
			id:4
			name:'test'
			price: 150
			quantity:3
		}
	]
	Cart.replace(test_items)
	subt(item) for item in Cart.items
	$scope.items = Cart.items
	window.cartitems = $scope.items
	$scope.total = ->
		t = 0
		(t+=item.subtotal for item in $scope.items)
		console.log t
		return t
	$scope.remove = (item)->
		Cart.removeItem(item)
	$scope.clear = ->
		$scope.items = []
		Cart.clear()
		humane.log("Cart cleared.")
]

UserProfileCtrl = ['$scope','$http',($scope,$http)->
	$http.get('/profile').success (data)->
		$scope.profile = data
	
	$scope.submit = ->
		$http.post('/profile', JSON.stringify($scope.profile)).success (data)->
			$scope.profile = data
			$scope.saved=true
			humane.log('Profile Saved')
			console.log(data)
		
]

MenuCtrl = ['$scope', ($scope)->
	$scope.order = 3
	
]

ChangePassCtrl = ['$scope','$http',($scope,$http)->
	$ = $scope
	$.verified = false	

	$scope.verify = ->
		$http.post('/verify_password',JSON.stringify($scope.user)).success(->
			console.log JSON.stringify $.user
			$.verified = true
			#humane.log('password correct!')
		)
		.error(->
			$.fail = true
			console.log JSON.stringify $.user
			$.user.password = ""
			humane.log('wrong password!')
		)
	$.change = ->
		$.status = ""
		p1 = $.new.password
		p2 = $.new.password_conf
		pack = 
			password: $.user.password
			new_password: p1
			new_password_confirm: p2
		pack = JSON.stringify pack
		if(p1 == p2)
			$http.post('/change_password', pack).success(->
				humane.log('Password Changed Successfully')
				$.new = {}
				$.verified = false
				$.user = {}
			).error(->
				humane.log("Password error")
			)
		else
			$.status = "error"
			humane.log('Passwords do not match')
			$.new = {}
		console.log pack
]

RegisterCtrl = ['$scope','$http',($scope,$http)->
	$scope.login = false
	$scope.check_username = ()->

		$uname = $scope.user.username
		console.log $uname
		if($uname == undefined)
			$scope.username_invalid = false
			$scope.username_valid = false
			$scope.username_state = "error"
		else
			$http.get("/check/#{$uname}").error(->
				$scope.valid=true
				$scope.username_state = "success"
				$scope.username_valid = true
				$scope.username_invalid = false
				console.log "valid username"
				)
			.success(->
				$scope.valid = false
				$scope.username_state = "error"
				$scope.username_invalid = true
				$scope.username_valid = false
				console.log "username already taken"
				)
	$scope.confirm = ->
		if($scope.user.password != undefined)
			if($scope.user.password == $scope.user.password_confirm)
				$scope.password_state = "success"
				$scope.password_valid = true
				console.log "equal"
			else
				$scope.password_state = "error"
				$scope.password_valid = false
				console.log "not equal"
		else
			$scope.password_state = "error"
			$scope.password_valid = false
	$scope.submit = ->
		$scope.profile.birthday = "#{$scope.profile.bday.month}/#{$scope.profile.bday.day}/#{$scope.profile.bday.year}"
		pack = 
			user:$scope.user
			profile:$scope.profile
		pack = JSON.stringify(pack)
		$http.post('/user', pack).success((data)-> 
			$scope.user = {}
			$scope.profile = {}
			$scope.login = true
		).error(->
			$scope.failed = true
		)

		console.log pack
]

ads.controller('RegisterCtrl', RegisterCtrl)
ads.controller('MenuCtrl', MenuCtrl)