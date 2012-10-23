rest = angular.module('restService', ['ngResource'])
rest.factory('Product', ($resource)->
	$resource('/product/:id.json',{id:'@id'},{
		query: {method:'GET',params:{id:'all'}, isArray:true}
	})
)

rest.factory('Brand',($resource)->
	$resource('/brand/:id.json/:products',{id:'@id'},{
		query: {method:'GET', params:{id:'all'}, isArray: true},
		products: {method: 'GET', params:{products: 'products'}, isArray: true}
		})
)