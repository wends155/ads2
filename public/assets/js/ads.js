(function() {
  var BrandCtrl, BrandDetailCtrl, CategoryCtrl, CategoryDetailCtrl, ChangePassCtrl, CompanyCtrl, CompanyDetailCtrl, DuesCtrl, MenuCtrl, MonthlyCtrl, OrderClaimCtrl, OrderCtrl, OrderDetailCtrl, OrderPayCtrl, PhoneDetailCtrl, ProductCtrl, ProductDetailCtrl, ProductListCtrl, ProfileOrdersCtrl, ProfilesCtrl, ProfilesDetailCtrl, RegisterCtrl, RetExCtrl, SalesCtrl, StockAddCtrl, StockCtrl, StockDecCtrl, StockIncCtrl, StockReportCtrl, UserCartCtrl, UserCatalogCtrl, UserIndexCtrl, UserOrderCtrl, UserProfileCtrl, UserReturnCtrl, WeeklyCtrl, admin, adminRest, ads, filters, rest,
    __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  ads = angular.module('ads', ['phonecatFilters', 'restService']);

  ads.config([
    '$routeProvider', function($routeProvider) {
      var user;
      user = "/assets/partials/user";
      return $routeProvider.when('/', {
        templateUrl: "" + user + "/index.html",
        controller: UserIndexCtrl
      }).when('/products', {
        templateUrl: '/assets/partials/product-list.html',
        controller: ProductListCtrl
      }).when('/product/:phoneId', {
        templateUrl: '/assets/partials/phone-detail.html',
        controller: PhoneDetailCtrl
      }).when('/catalog', {
        templateUrl: "" + user + "/catalog.html",
        controller: UserCatalogCtrl
      }).when('/cart', {
        templateUrl: "" + user + "/cart.html",
        controller: UserCartCtrl
      }).when('/profile', {
        templateUrl: "" + user + "/profile.html",
        controller: UserProfileCtrl
      }).when('/change', {
        templateUrl: "" + user + "/change.html",
        controller: ChangePassCtrl
      }).when('/orders', {
        templateUrl: "" + user + "/orders.html",
        controller: UserOrderCtrl
      }).when('/return/:id', {
        templateUrl: "" + user + "/return.html",
        controller: UserReturnCtrl
      }).otherwise({
        redirectTo: '/'
      });
    }
  ]);

  admin = angular.module('admin', ['restService', 'AdminServices']);

  admin.config([
    '$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
      var adtmpl;
      adtmpl = "/assets/partials/admin";
      $routeProvider.when('/', {
        templateUrl: '/assets/partials/admin-index.html'
      }).when('/products', {
        templateUrl: '/assets/partials/products.html',
        controller: ProductCtrl
      }).when('/product/:id', {
        templateUrl: '/assets/partials/product-detail.html',
        controller: ProductDetailCtrl
      }).when('/brand', {
        templateUrl: '/assets/partials/brand.html',
        controller: BrandCtrl
      }).when('/brand/:id', {
        templateUrl: '/assets/partials/brand-detail.html',
        controller: BrandDetailCtrl
      }).when('/company', {
        templateUrl: '/assets/partials/company.html',
        controller: CompanyCtrl
      }).when('/company/:id', {
        templateUrl: '/assets/partials/company-detail.html',
        controller: CompanyDetailCtrl
      }).when('/category', {
        templateUrl: '/assets/partials/category.html',
        controller: CategoryCtrl
      }).when('/category/:id', {
        templateUrl: '/assets/partials/category-detail.html',
        controller: CategoryDetailCtrl
      }).when('/catalog').when('/orders', {
        templateUrl: "" + adtmpl + "/orders.html",
        controller: OrderCtrl
      }).when('/orders/:id', {
        templateUrl: "" + adtmpl + "/order_details.html",
        controller: OrderDetailCtrl
      }).when('/orders/claim/:id', {
        templateUrl: "" + adtmpl + "/order_claim.html",
        controller: OrderClaimCtrl
      }).when('/orders/pay/:id', {
        templateUrl: "" + adtmpl + "/order_pay.html",
        controller: OrderPayCtrl
      }).when('/dealers').when('/reports').when('/sms').when('/profiles', {
        templateUrl: "" + adtmpl + "/profiles.html",
        controller: ProfilesCtrl
      }).when('/profiles/:id', {
        templateUrl: "" + adtmpl + "/profiles_detail.html",
        controller: ProfilesDetailCtrl
      }).when('/profiles/:id/orders', {
        templateUrl: "" + adtmpl + "/profile_orders.html",
        controller: ProfileOrdersCtrl
      }).when('/stocks', {
        templateUrl: "" + adtmpl + "/stocks.html",
        controller: StockCtrl
      }).when('/stocks/new', {
        templateUrl: "" + adtmpl + "/stock_new.html",
        controller: StockAddCtrl
      }).when('/stocks/:id/inc', {
        templateUrl: "" + adtmpl + "/stock_inc.html",
        controller: StockIncCtrl
      }).when('/stocks/:id/dec', {
        templateUrl: "" + adtmpl + "/stock_dec.html",
        controller: StockDecCtrl
      }).when('/stocks/report', {
        templateUrl: "" + adtmpl + "/stock_report.html",
        controller: StockReportCtrl
      }).when('/sales', {
        templateUrl: "" + adtmpl + "/sales.html",
        controller: SalesCtrl
      }).when('/retex', {
        templateUrl: "" + adtmpl + "/retex.html",
        controller: RetExCtrl
      }).when('/return/:id', {
        templateUrl: "" + adtmpl + "/return.html",
        controller: UserReturnCtrl
      }).when('/weekly', {
        templateUrl: "" + adtmpl + "/weekly.html",
        controller: WeeklyCtrl
      }).when('/monthly', {
        templateUrl: "" + adtmpl + "/monthly.html",
        controller: MonthlyCtrl
      }).when('/dues', {
        templateUrl: "" + adtmpl + "/dues.html",
        controller: DuesCtrl
      }).otherwise({
        redirectTo: '/'
      });
      return this;
    }
  ]);

  filters = angular.module('phonecatFilters', []);

  filters.filter('startFrom', function() {
    return function(input, start) {
      if (angular.isArray(input)) {
        return input.slice(start);
      }
      return input;
    };
  });

  ProductListCtrl = [
    '$scope', '$http', '$filter', function($scope, $http, $filter) {
      return $http.get('/product/all.json').success(function(data) {
        return $scope.products = data;
      });
    }
  ];

  PhoneDetailCtrl = [
    '$scope', '$routeParams', function($scope, $routeParams) {
      $scope.phoneId = $routeParams.phoneId;
      $scope.spinner = true;
      return $scope.hello = function(name) {
        $scope.msg = "hello " + name;
        return $scope.spinner = false;
      };
    }
  ];

  MenuCtrl = [
    '$scope', 'Cart', '$location', '$rootScope', 'Order', '$timeout', function($scope, Cart, $location, $rootScope, Order, $timeout) {
      var checkOrders, checker;
      checker = null;
      Order.query(function(data) {
        return $scope.order = data.length;
      });
      $scope.orderCount = 0;
      $scope.count = function() {
        return Cart.items.length;
      };
      $scope.logout = function() {
        $rootScope.$broadcast('logout', {});
        $location.path('/logout');
        return Cart.clear();
      };
      $scope.$on('$routeChangeSuccess', function() {
        return $scope.activePath = $location.path();
      });
      checkOrders = function() {
        clearTimeout(checker);
        console.log("code change 2");
        checker = $timeout(checkOrders, 1000);
        return this;
      };
      checkOrders();
      return $scope.stop = function() {
        return $timeout.cancel($scope.timeout);
      };
    }
  ];

  ProductCtrl = [
    '$scope', '$http', function($scope, $http) {
      $http.get('/product/all.json').success(function(data) {
        $scope.products = data;
        return $scope.spinner = false;
      });
      $http.get('/company/all.json').success(function(data) {
        return $scope.companies = data;
      });
      $http.get('/category/all.json').success(function(data) {
        return $scope.categories = data;
      });
      $http.get('/brand/all.json').success(function(data) {
        return $scope.brands = data;
      });
      $scope.limit = 20;
      $scope.saved = false;
      $scope.spinner = true;
      $scope.cancel = function() {
        return $scope.product = {};
      };
      $scope.submit = function() {
        console.log(JSON.stringify($scope.product));
        return $http.post('/product/new.json', JSON.stringify($scope.product)).success(function(data) {
          $scope.saved = true;
          $scope.products.push(data);
          return $scope.product = {};
        });
      };
      return $scope["delete"] = function(id) {
        return $http["delete"]("/product/" + id + ".json").success(function() {
          return $http.get('/product/all.json').success(function(data) {
            return $scope.products = data;
          });
        });
      };
    }
  ];

  ProductDetailCtrl = [
    '$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
      $http.get('/product/' + $routeParams.id + '.json').success(function(data) {
        $scope.product = data;
        return $scope.spinner = false;
      });
      $http.get('/company/all.json').success(function(data) {
        return $scope.companies = data;
      });
      $http.get('/category/all.json').success(function(data) {
        return $scope.categories = data;
      });
      $http.get('/brand/all.json').success(function(data) {
        return $scope.brands = data;
      });
      $scope.id = $routeParams.id;
      $scope.spinner = true;
      $scope.saved = false;
      return $scope.submit = function() {
        console.log(JSON.stringify($scope.product));
        return $http.post('/product/' + $scope.id + '.json', JSON.stringify($scope.product)).success(function() {
          return $scope.saved = true;
        });
      };
    }
  ];

  BrandCtrl = [
    '$scope', '$http', function($scope, $http) {
      $http.get('/brand/all.json').success(function(data) {
        return $scope.brands = data;
      });
      $scope["delete"] = function(id) {
        return $http["delete"]('/brand/' + id + '.json').success(function() {
          return $http.get('/brand/all.json').success(function(data) {
            return $scope.brands = data;
          });
        });
      };
      return $scope.submit = function() {
        return $http.post('/brand/new.json', JSON.stringify($scope.brand)).success(function(data) {
          $scope.brands.push(data);
          return $scope.brand = {};
        });
      };
    }
  ];

  BrandDetailCtrl = [
    '$scope', '$http', '$routeParams', 'Brand', function($scope, $http, $routeParams, Brand) {
      $scope.id = $routeParams.id;
      $http.get('/brand/' + $scope.id + '.json').success(function(data) {
        return $scope.brand = data;
      });
      $scope.caption = "Cancel";
      $scope.products = Brand.products({
        id: $scope.id
      });
      return $scope.submit = function() {
        return $http.post('/brand/' + $scope.id + '.json', JSON.stringify($scope.brand)).success(function() {
          $scope.saved = true;
          return $scope.caption = "Back";
        });
      };
    }
  ];

  CompanyCtrl = [
    '$scope', '$http', function($scope, $http) {
      $http.get('/company/all.json').success(function(data) {
        return $scope.companies = data;
      });
      $scope["delete"] = function(id) {
        return $http["delete"]('/company/' + id + '.json').success(function() {
          return $http.get('/company/all.json').success(function(data) {
            return $scope.companies = data;
          });
        });
      };
      return $scope.submit = function() {
        return $http.post('/company/new.json', JSON.stringify($scope.company)).success(function(data) {
          $scope.companies.push(data);
          return $scope.company = {};
        });
      };
    }
  ];

  CompanyDetailCtrl = [
    '$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
      $http.get('/company/' + $routeParams.id + '.json').success(function(data) {
        return $scope.company = data;
      });
      $scope.caption = "Cancel";
      return $scope.submit = function() {
        return $http.post('/company/' + $routeParams.id + '.json', JSON.stringify($scope.company)).success(function() {
          $scope.saved = true;
          return $scope.caption = "Back";
        });
      };
    }
  ];

  CategoryCtrl = [
    '$scope', '$http', function($scope, $http) {
      $http.get('/category/all.json').success(function(data) {
        return $scope.categories = data;
      });
      $scope["delete"] = function(id) {
        return $http["delete"]('/category/' + id + '.json').success(function() {
          return $http.get('/category/all.json').success(function(data) {
            return $scope.categories = data;
          });
        });
      };
      return $scope.submit = function() {
        return $http.post('/category/new.json', JSON.stringify($scope.category)).success(function(data) {
          $scope.categories.push(data);
          return $scope.category = {};
        });
      };
    }
  ];

  CategoryDetailCtrl = [
    '$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
      $http.get('/category/' + $routeParams.id + '.json').success(function(data) {
        return $scope.category = data;
      });
      $scope.caption = "Cancel";
      return $scope.submit = function() {
        return $http.post('/category/' + $routeParams.id + '.json', JSON.stringify($scope.category)).success(function() {
          $scope.saved = true;
          return $scope.caption = "Back";
        });
      };
    }
  ];

  OrderCtrl = [
    '$scope', 'adOrder', '$location', function($scope, Order, $location) {
      Order.query(function(data) {
        $scope.data = data;
        $scope.orders = data;
        return $scope.spinner = true;
      });
      $scope.claim = function(order) {
        order.date_claimed = Date.now() / 1000;
        console.log(order.total - order.downpayment);
        order.balance = order.total - order.downpayment;
        order.$save();
        return humane.log("Order claimed");
      };
      $scope.filterClaim = function() {
        var filter, o;
        console.log("claim: " + $scope.claimed);
        if ($scope.claimed) {
          filter = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.date_claimed !== null) {
                _results.push(o);
              }
            }
            return _results;
          })();
          return $scope.orders = filter;
        } else {
          filter = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.date_claimed === null) {
                _results.push(o);
              }
            }
            return _results;
          })();
          return $scope.orders = filter;
        }
      };
      $scope.filterPay = function() {
        var filter, p;
        if ($scope.paid) {
          filter = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              p = _ref[_i];
              if (p.date_paid !== null) {
                _results.push(p);
              }
            }
            return _results;
          })();
          return $scope.orders = filter;
        } else {
          filter = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              p = _ref[_i];
              if (p.date_paid === null) {
                _results.push(p);
              }
            }
            return _results;
          })();
          return $scope.orders = filter;
        }
      };
      $scope.reset = function() {
        $scope.orders = $scope.data;
        $scope.claimed = false;
        return $scope.paid = false;
      };
      return $scope.pay = function(id) {
        return $location.path("/orders/pay/" + id);
      };
    }
  ];

  OrderDetailCtrl = [
    '$scope', '$routeParams', 'adOrder', '$location', function($scope, $routeParams, Order, $location) {
      console.log($routeParams.id);
      Order.get({
        id: $routeParams.id
      }, function(data) {
        $scope.order = data;
        $scope.spinner = true;
        return console.log(data);
      });
      $scope.pay = function(id) {
        return $location.path("/orders/pay/" + id);
      };
      return $scope["return"] = function(id) {
        return $location.path("/return/" + id);
      };
    }
  ];

  OrderClaimCtrl = [
    '$scope', '$routeParams', 'adOrder', 'Sales', '$location', function($scope, $routeParams, Order, Sales, $location) {
      console.log($routeParams.id);
      Order.get({
        id: $routeParams.id
      }, function(data) {
        $scope.order = data;
        console.log(data);
        return $scope.spinner = true;
      });
      return $scope.submit = function() {
        var current_date, sales;
        current_date = Math.round(Date.now() / 1000);
        $scope.order.date_claimed = current_date;
        $scope.order.due = current_date + (3600 * 24 * 30);
        $scope.order.balance = $scope.order.total - $scope.order.downpayment;
        $scope.order.$save();
        sales = new Sales();
        sales.date = current_date;
        sales.order_id = $scope.order.id;
        sales.amount = $scope.order.downpayment;
        sales.$save();
        return $location.path('/orders');
      };
    }
  ];

  OrderPayCtrl = [
    '$scope', '$routeParams', 'adOrder', 'Sales', '$location', function($scope, $routeParams, Order, Sales, $location) {
      Order.get({
        id: $routeParams.id
      }, function(data) {
        $scope.order = data;
        return $scope.spinner = true;
      });
      return $scope.submit = function() {
        var amount, current_date, sales;
        current_date = Math.round(Date.now() / 1000);
        amount = parseFloat($scope.order.balance);
        $scope.order.date_paid = current_date;
        $scope.order.balance = parseFloat($scope.order.balance) - amount;
        console.log($scope.order.balance);
        $scope.order.$save();
        sales = new Sales();
        sales.date = current_date;
        sales.order_id = $scope.order.id;
        sales.amount = amount;
        sales.$save();
        return $location.path('/orders');
      };
    }
  ];

  ProfilesCtrl = [
    '$scope', 'adProfiles', function($scope, profiles) {
      profiles.query(function(data) {
        $scope.profiles = data;
        return $scope.spinner = true;
      });
      return $scope.remove = function(profile) {
        return profile.$delete(function() {
          return profiles.query(function(data) {
            $scope.profiles = data;
            return humane.log("dealer removed from list");
          });
        });
      };
    }
  ];

  ProfilesDetailCtrl = [
    '$scope', 'adProfiles', '$routeParams', function($scope, profiles, $routeParams) {
      return profiles.get({
        id: $routeParams.id
      }, function(data) {
        $scope.profile = data;
        return window.profile = data;
      });
    }
  ];

  ProfileOrdersCtrl = [
    '$scope', 'adProfiles', '$routeParams', function($scope, profiles, $routeParams) {
      profiles.orders({
        id: $routeParams.id
      }, function(data) {
        $scope.data = data;
        $scope.orders = data;
        $scope.predicate = '';
        $scope.reverse = true;
        return $scope.spinner = true;
      });
      $scope.filterPaid = function() {
        var o, ord;
        if ($scope.paid) {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_paid !== null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          return $scope.orders = o;
        } else {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_paid === null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          return $scope.orders = o;
        }
      };
      $scope.filterClaimed = function() {
        var o, ord;
        if ($scope.claimed) {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_claimed !== null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          return $scope.orders = o;
        } else {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_claimed === null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          return $scope.orders = o;
        }
      };
      return $scope.reset = function() {
        $scope.paid = false;
        $scope.claimed = false;
        return $scope.orders = $scope.data;
      };
    }
  ];

  StockCtrl = [
    '$scope', 'Stock', 'Product', function($scope, Stock, Product) {
      Stock.query(function(data) {
        $scope.stocks = data;
        window.stocks = data;
        return $scope.spinner = true;
      });
      return $scope["delete"] = function(stock) {
        var ok;
        ok = confirm("Do you want to delete " + stock.product.name);
        if (ok) {
          return stock.$delete(function() {
            $scope.spinner = false;
            return Stock.query(function(data) {
              $scope.stocks = data;
              $scope.spinner = true;
              return humane.log("" + stock.product.name + " removed from list");
            });
          });
        }
      };
    }
  ];

  StockAddCtrl = [
    '$scope', 'Stock', 'Product', '$location', function($scope, Stock, Product, $location) {
      Product.query(function(products) {
        return Stock.query(function(stocks) {
          var data, s, stock_ids;
          stock_ids = (function() {
            var _i, _len, _results;
            _results = [];
            for (_i = 0, _len = stocks.length; _i < _len; _i++) {
              s = stocks[_i];
              _results.push(s.product.id);
            }
            return _results;
          })();
          console.log(stock_ids);
          data = (function() {
            var _i, _len, _ref, _results;
            _results = [];
            for (_i = 0, _len = products.length; _i < _len; _i++) {
              s = products[_i];
              if (_ref = s.id, __indexOf.call(stock_ids, _ref) < 0) {
                _results.push(s);
              }
            }
            return _results;
          })();
          console.log(data);
          $scope.products = data;
          return $scope.spinner = true;
        });
      });
      $scope.stock = new Stock();
      return $scope.submit = function() {
        var stock_selected;
        stock_selected = $scope.stock.product;
        return $scope.stock.$save(function() {
          var s, st;
          st = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.products;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              s = _ref[_i];
              if (s.id !== stock_selected.id) {
                _results.push(s);
              }
            }
            return _results;
          })();
          $scope.products = st;
          humane.log("Stock '" + stock_selected.name + "'' added");
          return $location.path('/stocks');
        }, function() {
          return humane.log("failed");
        });
      };
    }
  ];

  StockIncCtrl = [
    '$scope', '$routeParams', 'Stock', '$http', '$location', function($scope, $routeParams, Stock, $http, $location) {
      var id;
      id = $routeParams.id;
      Stock.get({
        id: id
      }, function(data) {
        $scope.stock = data;
        return console.log(data);
      });
      return $scope.submit = function() {
        return $http.get("/stocks/" + id + "/inc/" + $scope.stock.value).success(function() {
          humane.log("'" + $scope.stock.product.name + "'' Stock increased by " + $scope.stock.value);
          return $location.path('/stocks');
        }).error(function() {
          return humane.log("failed");
        });
      };
    }
  ];

  StockDecCtrl = [
    '$scope', '$routeParams', 'Stock', '$http', '$location', function($scope, $routeParams, Stock, $http, $location) {
      var id;
      id = $routeParams.id;
      Stock.get({
        id: id
      }, function(data) {
        $scope.stock = data;
        return console.log(data);
      });
      return $scope.submit = function() {
        return $http.get("/stocks/" + id + "/dec/" + $scope.stock.value).success(function() {
          humane.log("'" + $scope.stock.product.name + "'' Stock decreased by " + $scope.stock.value);
          return $location.path('/stocks');
        }).error(function() {
          return humane.log("failed");
        });
      };
    }
  ];

  StockReportCtrl = ['$scope', function($scope) {}];

  SalesCtrl = [
    '$scope', 'Sales', function($scope, Sales) {
      return window.sales = Sales;
    }
  ];

  RetExCtrl = [
    '$scope', 'Retex', function($scope, Retex) {
      return Retex.query(function(data) {
        $scope.data = data;
        $scope.items = data;
        return console.log(data);
      });
    }
  ];

  WeeklyCtrl = [
    '$scope', 'Sales', function($scope, Sales) {
      Sales.query(function(data) {
        $scope.data = data;
        console.log(data);
        return $scope.spinner = true;
      });
      return $scope.submit = function() {
        var a, f, from, s, to, total, _i, _len, _ref;
        from = (new Date($scope.dateFrom)).valueOf();
        console.log('from: ' + from);
        to = (new Date($scope.dateTo)).valueOf();
        console.log('to: ' + to);
        a = (function() {
          var _i, _len, _ref, _results;
          _ref = $scope.data;
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            s = _ref[_i];
            if ((s.date * 1000) >= from) {
              _results.push(s);
            }
          }
          return _results;
        })();
        f = (function() {
          var _i, _len, _results;
          _results = [];
          for (_i = 0, _len = a.length; _i < _len; _i++) {
            s = a[_i];
            if (s.date * 1000 <= (to + 86400000)) {
              _results.push(s);
            }
          }
          return _results;
        })();
        console.log(f);
        $scope.sales = f;
        total = 0;
        _ref = $scope.sales;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          s = _ref[_i];
          total += parseFloat(s.amount);
        }
        return $scope.total = total;
      };
    }
  ];

  MonthlyCtrl = [
    '$scope', 'Sales', function($scope, Sales) {
      $scope.currMonth = (new Date()).getMonth();
      $scope.year = (new Date()).getFullYear();
      Sales.query(function(data) {
        var f, s, total, _i, _len;
        $scope.data = data;
        f = (function() {
          var _i, _len, _results;
          _results = [];
          for (_i = 0, _len = data.length; _i < _len; _i++) {
            s = data[_i];
            if ((new Date(s.date * 1000)).getMonth() === $scope.currMonth) {
              _results.push(s);
            }
          }
          return _results;
        })();
        total = 0;
        for (_i = 0, _len = f.length; _i < _len; _i++) {
          s = f[_i];
          total += parseFloat(s.amount);
        }
        console.log(f);
        console.log(total);
        $scope.sales = f;
        $scope.total = total;
        return $scope.spinner = true;
      });
      return $scope.changeMonth = function() {
        var f, s, total, _i, _len;
        f = (function() {
          var _i, _len, _ref, _results;
          _ref = $scope.data;
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            s = _ref[_i];
            if (((new Date(s.date * 1000)).getMonth() === parseInt($scope.month)) && (new Date(s.date * 1000)).getFullYear() === $scope.year) {
              _results.push(s);
            }
          }
          return _results;
        })();
        console.log(f);
        total = 0;
        for (_i = 0, _len = f.length; _i < _len; _i++) {
          s = f[_i];
          total += parseFloat(s.amount);
        }
        console.log(total);
        $scope.sales = f;
        return $scope.total = total;
      };
    }
  ];

  DuesCtrl = [
    '$scope', 'Dues', 'sms', function($scope, Dues, sms) {
      Dues.query(function(data) {
        $scope.orders = data;
        $scope.spinner = true;
        window.sms = sms;
        return console.log('sms');
      });
      return $scope.notify = function(order) {
        var ddate, due, m_no, send;
        m_no = order.mobile;
        due = new Date(parseInt(order.due) * 1000);
        ddate = (due.getMonth() + 1) + "/" + due.getDate() + "/" + due.getFullYear();
        console.log(ddate);
        send = new sms();
        console.log(send);
        console.log(parseInt(order.due));
        send.number = m_no;
        send.message = "your due date for order#" + order.id + " is on " + ddate;
        send.$save();
        alert("notification sent to " + m_no);
        return order.notified = true;
      };
    }
  ];

  admin.controller('MenuCtrl', MenuCtrl);

  UserCatalogCtrl = [
    '$scope', 'Company', 'Category', 'Product', 'Cart', '$location', function($scope, Company, Category, Product, Cart, $location) {
      Company.query(function(data) {
        return $scope.companies = data;
      });
      Category.query(function(data) {
        return $scope.categories = data;
      });
      Product.query(function(data) {
        $scope.data = data;
        $scope.products = data;
        $scope.spinner = true;
        $scope.search = "";
        return console.log(data);
      });
      $scope.add = function(product) {
        product.quantity = 1;
        Cart.add(product);
        return $location.path('/cart');
      };
      $scope.filterCompany = function() {
        var category_id, company_id, fcat, filtered, o;
        console.log($scope.option.company.id);
        company_id = $scope.option.company.id;
        if (($scope.option.category != null)) {
          category_id = $scope.option.category.id;
          fcat = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.category_id === category_id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          console.log(fcat);
          filtered = (function() {
            var _i, _len, _results;
            _results = [];
            for (_i = 0, _len = fcat.length; _i < _len; _i++) {
              o = fcat[_i];
              if (o.company_id === company_id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          return $scope.products = filtered;
        } else {
          filtered = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.company_id === company_id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          console.log(filtered);
          return $scope.products = filtered;
        }
      };
      $scope.filterCategory = function() {
        var company_id, fcomp, filtered, id, o;
        console.log($scope.option.category.id);
        id = $scope.option.category.id;
        if (($scope.option.company != null)) {
          company_id = $scope.option.company.id;
          fcomp = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.company_id === company_id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          console.log(fcomp);
          filtered = (function() {
            var _i, _len, _results;
            _results = [];
            for (_i = 0, _len = fcomp.length; _i < _len; _i++) {
              o = fcomp[_i];
              if (o.category_id === id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          console.log(filtered);
          return $scope.products = filtered;
        } else {
          filtered = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              o = _ref[_i];
              if (o.category_id === id) {
                _results.push(o);
              }
            }
            return _results;
          })();
          return $scope.products = filtered;
        }
      };
      $scope.reset = function() {
        $scope.products = $scope.data;
        $scope.option.company = null;
        $scope.option.category = null;
        return $scope.search = "";
      };
      return window.test = function() {
        return console.log($scope.option);
      };
    }
  ];

  UserIndexCtrl = ['$scope', '$http', function($scope, $http) {}];

  UserCartCtrl = [
    '$scope', 'Cart', '$location', 'Order', function($scope, Cart, $location, Order) {
      $scope.items = Cart.items;
      window.cart = Cart;
      $scope.total = function() {
        var item, st, subtotal, t, _i, _len;
        st = (function() {
          var _i, _len, _ref, _results;
          _ref = $scope.items;
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            item = _ref[_i];
            _results.push(item.price * item.quantity);
          }
          return _results;
        })();
        t = 0;
        for (_i = 0, _len = st.length; _i < _len; _i++) {
          subtotal = st[_i];
          t += subtotal;
        }
        Cart.store($scope.items);
        return t;
      };
      $scope.remove = function(item) {
        return Cart.removeItem(item);
      };
      $scope.clear = function() {
        $scope.items = [];
        Cart.clear();
        return humane.log("Cart cleared.");
      };
      $scope.order = function() {
        var order;
        console.log($scope.items);
        order = new Order();
        order.date = Date.now() / 1000;
        order.items = $scope.items;
        order.date_paid = false;
        order.date_claimed = false;
        order.$save();
        $scope.clear();
        return $location.path('/orders');
      };
      return $scope.$on('logout', function(event) {
        return $scope.clear();
      });
    }
  ];

  UserOrderCtrl = [
    '$scope', 'Order', '$location', function($scope, Order, $location) {
      $scope.getTotal = function() {
        var dptotal, o, total, _i, _j, _len, _len1, _ref, _ref1;
        total = 0;
        _ref = $scope.orders;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          o = _ref[_i];
          total += o.total;
        }
        dptotal = 0;
        _ref1 = $scope.orders;
        for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
          o = _ref1[_j];
          dptotal += o.downpayment;
        }
        console.log(total);
        console.log(dptotal);
        $scope.total = total;
        return $scope.dptotal = dptotal;
      };
      window.order = Order;
      Order.query(function(data) {
        $scope.data = data;
        $scope.orders = data;
        $scope.predicate = '';
        $scope.reverse = true;
        $scope.spinner = true;
        $scope.getTotal();
        return console.log($scope.total);
      });
      $scope.filterPaid = function() {
        var o, ord;
        if ($scope.paid) {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_paid !== null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          $scope.orders = o;
          return $scope.getTotal();
        } else {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_paid === null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          $scope.orders = o;
          return $scope.getTotal();
        }
      };
      $scope.filterClaimed = function() {
        var o, ord;
        if ($scope.claimed) {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_claimed !== null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          $scope.orders = o;
          return $scope.getTotal();
        } else {
          o = (function() {
            var _i, _len, _ref, _results;
            _ref = $scope.data;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              ord = _ref[_i];
              if (ord.date_claimed === null) {
                _results.push(ord);
              }
            }
            return _results;
          })();
          $scope.orders = o;
          return $scope.getTotal();
        }
      };
      $scope.reset = function() {
        $scope.paid = false;
        $scope.claimed = false;
        $scope.orders = $scope.data;
        return $scope.getTotal();
      };
      $scope["return"] = function(item) {
        return $location.path("/return/" + item.id);
      };
      return $scope.total = function() {};
    }
  ];

  UserProfileCtrl = [
    '$scope', '$http', 'Profile', function($scope, $http, Profile) {
      Profile.get(function(data) {
        return window.profile = data;
      });
      $http.get('/profile').success(function(data) {
        $scope.profile = data;
        return $scope.spinner = true;
      });
      return $scope.submit = function() {
        return $http.post('/profile', JSON.stringify($scope.profile)).success(function(data) {
          $scope.profile = data;
          $scope.saved = true;
          return humane.log('Profile Saved');
        });
      };
    }
  ];

  UserReturnCtrl = [
    '$scope', '$location', '$routeParams', 'Item', 'Alternative', 'Retex', function($scope, $location, $routeParams, Item, Alternative, Retex) {
      Item.get({
        id: $routeParams.id
      }, function(data) {
        console.log(data);
        $scope.item = data;
        return Alternative.query({
          id: $scope.item.product.id
        }, function(data) {
          return $scope.alts = data;
        });
      });
      return $scope.submit = function() {
        var retex;
        $scope.item.$save();
        retex = new Retex();
        retex.old_product_id = $scope.item.product.id;
        retex.new_product_id = $scope.item.new_product.id;
        retex.date = Math.round(Date.now() / 1000);
        retex.item_id = $scope.item.id;
        retex.done = false;
        return retex.$save();
      };
    }
  ];

  MenuCtrl = [
    '$scope', 'Cart', '$location', '$rootScope', 'Order', function($scope, Cart, $location, $rootScope, Order) {
      Order.query(function(data) {
        return $scope.order = data.length;
      });
      $scope.count = function() {
        return Cart.items.length;
      };
      $scope.logout = function() {
        $rootScope.$broadcast('logout', {});
        $location.path('/logout');
        return Cart.clear();
      };
      return $scope.$on('$routeChangeSuccess', function() {
        $scope.activePath = $location.path();
        return console.log($scope.activePath);
      });
    }
  ];

  ChangePassCtrl = [
    '$scope', '$http', function($scope, $http) {
      var $;
      $ = $scope;
      $.verified = false;
      $scope.verify = function() {
        return $http.post('/verify_password', JSON.stringify($scope.user)).success(function() {
          console.log(JSON.stringify($.user));
          return $.verified = true;
        }).error(function() {
          $.fail = true;
          console.log(JSON.stringify($.user));
          $.user.password = "";
          return humane.log('wrong password!');
        });
      };
      return $.change = function() {
        var p1, p2, pack;
        $.status = "";
        p1 = $["new"].password;
        p2 = $["new"].password_conf;
        pack = {
          password: $.user.password,
          new_password: p1,
          new_password_confirm: p2
        };
        pack = JSON.stringify(pack);
        if (p1 === p2) {
          $http.post('/change_password', pack).success(function() {
            humane.log('Password Changed Successfully');
            $["new"] = {};
            $.verified = false;
            return $.user = {};
          }).error(function() {
            return humane.log("Password error");
          });
        } else {
          $.status = "error";
          humane.log('Passwords do not match');
          $["new"] = {};
        }
        return console.log(pack);
      };
    }
  ];

  RegisterCtrl = [
    '$scope', '$http', '$location', function($scope, $http, $location) {
      $scope.login = false;
      $scope.check_username = function() {
        var $uname;
        $uname = $scope.user.username;
        console.log($uname);
        if ($uname === void 0) {
          $scope.username_invalid = false;
          $scope.username_valid = false;
          return $scope.username_state = "error";
        } else {
          return $http.get("/check/" + $uname).error(function() {
            $scope.valid = true;
            $scope.username_state = "success";
            $scope.username_valid = true;
            $scope.username_invalid = false;
            return console.log("valid username");
          }).success(function() {
            $scope.valid = false;
            $scope.username_state = "error";
            $scope.username_invalid = true;
            $scope.username_valid = false;
            return console.log("username already taken");
          });
        }
      };
      $scope.confirm = function() {
        if ($scope.user.password !== void 0) {
          if ($scope.user.password === $scope.user.password_confirm) {
            $scope.password_state = "success";
            $scope.password_valid = true;
            return console.log("equal");
          } else {
            $scope.password_state = "error";
            $scope.password_valid = false;
            return console.log("not equal");
          }
        } else {
          $scope.password_state = "error";
          return $scope.password_valid = false;
        }
      };
      return $scope.submit = function() {
        var pack;
        $scope.profile.birthday = "" + $scope.profile.bday.month + "/" + $scope.profile.bday.day + "/" + $scope.profile.bday.year;
        pack = {
          user: $scope.user,
          profile: $scope.profile
        };
        pack = JSON.stringify(pack);
        $http.post('/user', pack).success(function(data) {
          $scope.user = {};
          $scope.profile = {};
          return $scope.login = true;
        }).error(function() {
          return $scope.failed = true;
        });
        return console.log(pack);
      };
    }
  ];

  ads.controller('RegisterCtrl', RegisterCtrl);

  ads.controller('MenuCtrl', MenuCtrl);

  rest = angular.module('restService', ['ngResource']);

  rest.factory('Product', [
    '$resource', function($resource) {
      return $resource('/product/:id.json', {
        id: '@id'
      }, {
        query: {
          method: 'GET',
          params: {
            id: 'all'
          },
          isArray: true
        }
      });
    }
  ]);

  rest.factory('Brand', [
    '$resource', function($resource) {
      return $resource('/brand/:id.json/:products', {
        id: '@id'
      }, {
        query: {
          method: 'GET',
          params: {
            id: 'all'
          },
          isArray: true
        },
        products: {
          method: 'GET',
          params: {
            products: 'products'
          },
          isArray: true
        }
      });
    }
  ]);

  rest.factory('Company', [
    '$resource', function($resource) {
      return $resource('/company/:id.json/:products', {
        id: '@id'
      }, {
        query: {
          method: 'GET',
          params: {
            id: 'all'
          },
          isArray: true
        },
        products: {
          method: 'GET',
          params: {
            products: 'products'
          },
          isArray: true
        }
      });
    }
  ]);

  rest.factory('Category', [
    '$resource', function($resource) {
      return $resource('/category/:id.json/:products', {
        id: '@id'
      }, {
        query: {
          method: 'GET',
          params: {
            id: 'all'
          },
          isArray: true
        },
        products: {
          method: 'GET',
          params: {
            products: 'products'
          },
          isArray: true
        }
      });
    }
  ]);

  rest.factory('Profile', [
    '$resource', function($resource) {
      return $resource('/profile', {});
    }
  ]);

  rest.factory('Retex', [
    '$resource', function($resource) {
      return $resource('/return/:id', {
        id: '@id'
      });
    }
  ]);

  rest.factory('Order', [
    '$resource', function($resource) {
      return $resource('/orders/:id', {
        id: '@id'
      });
    }
  ]);

  rest.factory('Item', [
    '$resource', function($resource) {
      return $resource('/items/:id', {
        id: '@id'
      });
    }
  ]);

  rest.factory('Alternative', [
    '$resource', function($resource) {
      return $resource('/alt/:id');
    }
  ]);

  rest.service('localStorageService', [
    function() {
      return {
        prefix: 'ads.',
        isSupported: function() {
          try {
            return 'localStorage' in window && (window['localStorage'] != null);
          } catch (e) {
            return false;
          }
        },
        add: function(key, value) {
          try {
            return localStorage.setItem(this.prefix + key, value);
          } catch (e) {
            console.error(e.Description);
            return -1;
          }
        },
        get: function(key) {
          return localStorage.getItem(this.prefix + key);
        },
        remove: function(key) {
          return localStorage.removeItem(this.prefix + key);
        },
        clearAll: function() {
          var i, keys, prefixLength, q, _i, _len, _results;
          prefixLength = this.prefix.length;
          keys = (function() {
            var _results;
            _results = [];
            for (i in localStorage) {
              if (i.substr(0, prefixLength) === this.prefix) {
                _results.push(i);
              }
            }
            return _results;
          }).call(this);
          _results = [];
          for (_i = 0, _len = keys.length; _i < _len; _i++) {
            q = keys[_i];
            _results.push((function(q) {
              return localStorage.removeItem(q);
            })(q));
          }
          return _results;
        }
      };
    }
  ]);

  rest.factory('Cart', [
    'localStorageService', function(localStorageService) {
      var cart, getCartItems;
      getCartItems = function() {
        var strCart;
        if (localStorageService.get('cart') != null) {
          strCart = localStorageService.get('cart');
          return JSON.parse(strCart);
        } else {
          localStorageService.add('cart', '[]');
          strCart = localStorageService.get('cart');
          return JSON.parse(strCart);
        }
      };
      return cart = {
        persist: function() {
          return localStorageService.add('cart', JSON.stringify(this.items));
        },
        items: getCartItems(),
        add: function(obj) {
          var key, str;
          key = this.items.push(obj);
          str = JSON.stringify(this.items);
          localStorageService.add('cart', str);
          return key;
        },
        get: function(key) {
          return this.items[key];
        },
        getItem: function(obj) {
          var key;
          key = this.items.indexOf(obj);
          if (key >= 0) {
            return key;
          } else {
            return false;
          }
        },
        set: function(key, value) {
          this.items[key] = value;
          this.persist();
          return value;
        },
        store: function(obj) {
          this.items = obj;
          return this.persist();
        },
        remove: function(key) {
          this.items.splice(key, 1);
          return this.persist();
        },
        removeItem: function(obj) {
          var key;
          key = this.items.indexOf(obj);
          return this.remove(key);
        },
        removeById: function(id) {
          var i, obj;
          obj = (function() {
            var _i, _len, _ref, _results;
            _ref = this.items;
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
              i = _ref[_i];
              if (i.id === id) {
                _results.push(i);
              }
            }
            return _results;
          }).call(this);
          console.log(obj);
          return obj;
        },
        clear: function() {
          this.items = [];
          return this.persist();
        }
      };
    }
  ]);

  adminRest = angular.module('AdminServices', ['ngResource']);

  adminRest.factory('adOrder', [
    '$resource', function($resource) {
      return $resource('/orders/:id', {
        id: '@id'
      });
    }
  ]);

  adminRest.factory('adProfiles', [
    '$resource', function($resource) {
      return $resource('/profiles/:id/:orders', {
        id: '@id'
      }, {
        orders: {
          method: 'GET',
          params: {
            orders: 'orders'
          },
          isArray: true
        }
      });
    }
  ]);

  adminRest.factory('Stock', [
    '$resource', function($resource) {
      return $resource('/stocks/:id', {
        id: '@id'
      });
    }
  ]);

  adminRest.factory('Sales', [
    '$resource', function($resource) {
      return $resource('/sales/:id', {
        id: '@id'
      });
    }
  ]);

  adminRest.factory('Dues', [
    '$resource', function($resource) {
      return $resource('/dues');
    }
  ]);

  adminRest.factory('sms', [
    '$resource', function($resource) {
      return $resource('/sms');
    }
  ]);

}).call(this);

// Generated by CoffeeScript 1.5.0-pre
