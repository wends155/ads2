PhoneListCtrl = ['$scope','$http','$filter', ($scope,$http,$filter) ->
	$http.get('phones.json').success (data)->
		$scope.unfiltered = data 

		$scope.phones = $filter('filter')($scope.unfiltered,$scope.query)
		
		$scope.numberOfPages = ->
			Math.ceil($scope.phones.length/$scope.limit)
		
		$scope.isLastPage = ->
			($scope.currentPage == $scope.numberOfPages()) or ($scope.numberOfPages() == 0)
		
		@

	$scope.orderProp = 'id'
	$scope.currentPage = 1
	$scope.limit = 1
	$scope.start = 0
	$scope.change = ->
		console.log "filtered: " + $scope.phones
		$scope.phones = $filter('filter')($scope.unfiltered,$scope.query)
		$scope.start = 0
		$scope.currentPage = 1

	$scope.nextPage = ->
		$scope.currentPage++
		console.log "currentPage: " + $scope.currentPage
		$scope.start = +$scope.start + +$scope.limit
		console.log "start: " + $scope.start
	$scope.previousPage = ->
		$scope.currentPage--
		console.log "currentPage: " + $scope.currentPage
		$scope.start = +$scope.start - +$scope.limit

		if $scope.start < 0 
			$scope.start = 0

		console.log "start: " + $scope.start
		true
	$scope.isFirstPage = ->
		$scope.currentPage == 1
	
	@
]


PhoneDetailCtrl = ['$scope','$routeParams', ($scope,$routeParams) ->
	$scope.phoneId = $routeParams.phoneId
	$scope.hello = (name) -> 
		$scope.msg = "hello #{name}"
		
	@
]