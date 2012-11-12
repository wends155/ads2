#ads module
#--------
#	the main user module
#Dependencies:
#
# * phonecatFilters
# * restService
ads = angular.module('ads',['phonecatFilters','restService'])

#location configuration for ng-view
#
ads.config([
	'$routeProvider', ($routeProvider) ->
		user = "/assets/partials/user"
		$routeProvider
		.when('/',{
			templateUrl: "#{user}/index.html",
			controller: UserIndexCtrl
			})
		.when('/products',{
			templateUrl: '/assets/partials/product-list.html', 
			controller: ProductListCtrl})
		.when('/product/:phoneId', {
			templateUrl:'/assets/partials/phone-detail.html', 
			controller: PhoneDetailCtrl})
		.when('/catalog',{
			templateUrl: "#{user}/catalog.html",
			controller: UserCatalogCtrl
			})
		.when('/cart',{
			templateUrl: "#{user}/cart.html",
			controller: UserCartCtrl
			})
		.when('/profile',{
			templateUrl: "#{user}/profile.html",
			controller: UserProfileCtrl
			})
		.when('/change',{
			templateUrl: "#{user}/change.html",
			controller: ChangePassCtrl
			})
		.when('/orders',{
			templateUrl: "#{user}/orders.html",
			controller: UserOrderCtrl
			})
		.when('/return/:id',{
			templateUrl: "#{user}/return.html"
			controller: UserReturnCtrl
			})
		.otherwise({redirectTo: '/'})
		])
#admin module
#------------
#
#module used for administration pages
#
admin = angular.module('admin',['restService','AdminServices'])
admin.config(['$routeProvider','$locationProvider',($routeProvider,$locationProvider) -> 
	adtmpl = "/assets/partials/admin"
	$routeProvider.when('/',{templateUrl: '/assets/partials/admin-index.html'})
	.when('/products', {templateUrl:'/assets/partials/products.html', controller: ProductCtrl})
	.when('/product/:id',{templateUrl:'/assets/partials/product-detail.html', controller: ProductDetailCtrl})
	.when('/brand',{templateUrl:'/assets/partials/brand.html', controller: BrandCtrl})
	.when('/brand/:id', {templateUrl:'/assets/partials/brand-detail.html', controller: BrandDetailCtrl})
	.when('/company',{templateUrl: '/assets/partials/company.html', controller: CompanyCtrl})
	.when('/company/:id', {templateUrl:'/assets/partials/company-detail.html' ,  controller: CompanyDetailCtrl})
	.when('/category',{templateUrl: '/assets/partials/category.html', controller: CategoryCtrl})
	.when('/category/:id',{templateUrl:'/assets/partials/category-detail.html', controller: CategoryDetailCtrl})
	.when('/catalog')
	.when('/orders',{
		templateUrl:"#{adtmpl}/orders.html"
		controller: OrderCtrl
		})
	.when('/orders/:id',{
		templateUrl: "#{adtmpl}/order_details.html"
		controller: OrderDetailCtrl
		})
	.when('/orders/claim/:id',{
		templateUrl: "#{adtmpl}/order_claim.html"
		controller: OrderClaimCtrl
		})
	.when('/orders/pay/:id',{
		templateUrl: "#{adtmpl}/order_pay.html"
		controller: OrderPayCtrl
		})
	.when('/dealers')
	.when('/reports')
	.when('/sms')
	.when('/profiles',{
		templateUrl: "#{adtmpl}/profiles.html"
		controller: ProfilesCtrl
		})
	.when('/profiles/:id',{
		templateUrl: "#{adtmpl}/profiles_detail.html"
		controller: ProfilesDetailCtrl
		})
	.when('/profiles/:id/orders',{
		templateUrl: "#{adtmpl}/profile_orders.html"
		controller: ProfileOrdersCtrl
		})
	.when('/stocks',{
		templateUrl: "#{adtmpl}/stocks.html"
		controller: StockCtrl
		})
	.when('/stocks/new',{
		templateUrl: "#{adtmpl}/stock_new.html"
		controller: StockAddCtrl
		})
	.when('/stocks/:id/inc',{
		templateUrl: "#{adtmpl}/stock_inc.html"
		controller: StockIncCtrl
		})
	.when('/stocks/:id/dec',{
		templateUrl: "#{adtmpl}/stock_dec.html"
		controller: StockDecCtrl
		})
	.when('/stocks/report',{
		templateUrl: "#{adtmpl}/stock_report.html"
		controller: StockReportCtrl
		})
	.otherwise({redirectTo:'/'})
	#$locationProvider.html5Mode(true)
	@
	])