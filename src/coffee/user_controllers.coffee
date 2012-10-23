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

ads.controller('MenuCtrl', MenuCtrl)