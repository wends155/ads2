phonecat = angular.module('ads',['phonecatFilters'])

phonecat.config([
	'$routeProvider', ($routeProvider) ->
		$routeProvider.when('/products',{templateUrl: '/assets/partials/product-list.html', controller: ProductListCtrl})
		.when('/product/:phoneId', {templateUrl:'/assets/partials/phone-detail.html', controller: PhoneDetailCtrl})
		.otherwise({redirectTo: '/products'})
		])

