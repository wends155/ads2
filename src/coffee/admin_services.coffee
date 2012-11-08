adminRest = angular.module('AdminServices',['ngResource'])

adminRest.factory('adOrder',['$resource',($resource)->
	$resource('/orders/:id', {id:'@id'})
])

adminRest.factory('adProfiles',['$resource',($resource)->
	$resource('/profiles/:id/:orders', {id:'@id'},{
		orders:{method:'GET', params: {orders:'orders'},isArray:true}
	})
])