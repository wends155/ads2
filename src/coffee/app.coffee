phonecat = angular.module('ads',['phonecatFilters'])

phonecat.config([
	'$routeProvider', ($routeProvider) ->
		$routeProvider.when('/products',{templateUrl: '/assets/partials/product-list.html', controller: ProductListCtrl})
		.when('/product/:phoneId', {templateUrl:'/assets/partials/phone-detail.html', controller: PhoneDetailCtrl})
		.otherwise({redirectTo: '/products'})
		])

admin = angular.module('admin',[])
admin.config(['$routeProvider',($routeProvider) -> 
	$routeProvider.when('/',{templateUrl: '/assets/partials/admin-index.html'})
	.when('/products', {templateUrl:'/assets/partials/products.html', controller: ProductCtrl})
	.when('/product/:id',{templateUrl:'/assets/partials/product-detail.html', controller: ProductDetailCtrl})
	.when('/brand',{templateUrl:'/assets/partials/brand.html', controller: BrandCtrl})
	.when('/company',{templateUrl: '/assets/partials/company.html', controller: CompanyCtrl})
	.when('/category',{templateUrl: '/assets/partials/category.html', controller: CategoryCtrl})
	.otherwise({redirectTo:'/'})
	@
	])