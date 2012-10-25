UserCatalogCtrl = ['$scope','Brand', ($scope,Brand)->
	@
]

UserIndexCtrl = ['$scope','$http', ($scope,$http)->
	
	@
]

UserCartCtrl = ['$scope', ($scope)->
	@
]

UserProfileCtrl = ['$scope','$http',($scope,$http)->
	$http.get('/profile').success (data)->
		$scope.profile = data
	@
	$scope.submit = ->
		$http.post('/profile', JSON.stringify($scope.profile)).success (data)->
			$scope.profile = data
			$scope.saved=true
			console.log(data)
		@
]

MenuCtrl = ['$scope', ($scope)->
	$scope.order = 3
	@
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