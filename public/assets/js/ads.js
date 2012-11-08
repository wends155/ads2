// Generated by CoffeeScript 1.3.3
(function() {
  var BrandCtrl, BrandDetailCtrl, CategoryCtrl, CategoryDetailCtrl, ChangePassCtrl, CompanyCtrl, CompanyDetailCtrl, MenuCtrl, PhoneDetailCtrl, ProductCtrl, ProductDetailCtrl, ProductListCtrl, RegisterCtrl, UserCartCtrl, UserCatalogCtrl, UserIndexCtrl, UserOrderCtrl, UserProfileCtrl, admin, ads, filters, rest;

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
      }).otherwise({
        redirectTo: '/'
      });
    }
  ]);

  admin = angular.module('admin', ['restService']);

  admin.config([
    '$routeProvider', function($routeProvider) {
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
      }).when('/catalog').when('/orders').when('/dealers').when('/reports').when('/sms').otherwise({
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

  UserCatalogCtrl = [
    '$scope', 'Company', 'Category', 'Product', 'Cart', '$location', function($scope, Company, Category, Product, Cart, $location) {
      $scope.companies = Company.query();
      $scope.categories = Category.query();
      $scope.products = Product.query(function(data) {
        return $scope.spinner = true;
      });
      return $scope.add = function(product) {
        product.quantity = 1;
        Cart.add(product);
        return $location.path('/cart');
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
        order = new Order();
        order.date = Date.now() / 1000;
        order.items = $scope.items;
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
    '$scope', 'Order', function($scope, Order) {
      window.order = Order;
      return Order.query(function(data) {
        $scope.orders = data;
        return console.log($scope.orders);
      });
    }
  ];

  UserProfileCtrl = [
    '$scope', '$http', function($scope, $http) {
      $http.get('/profile').success(function(data) {
        return $scope.profile = data;
      });
      return $scope.submit = function() {
        return $http.post('/profile', JSON.stringify($scope.profile)).success(function(data) {
          $scope.profile = data;
          $scope.saved = true;
          humane.log('Profile Saved');
          return console.log(data);
        });
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
      return $scope.logout = function() {
        $rootScope.$broadcast('logout', {});
        $location.path('/logout');
        return Cart.clear();
      };
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
    '$scope', '$http', function($scope, $http) {
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

  rest.factory('Order', [
    '$resource', function($resource) {
      return $resource('/orders/:id', {
        id: '@id'
      });
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
          console.log(localStorageService.get('cart'));
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

}).call(this);
