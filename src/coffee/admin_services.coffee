adminRest = angular.module('AdminServices',['ngResource'])

adminRest.factory('adOrder',['$resource',($resource)->
	$resource('/orders/:id', {id:'@id'})
])

adminRest.factory('adProfiles',['$resource',($resource)->
	$resource('/profiles/:id/:orders', {id:'@id'},{
		orders:{method:'GET', params: {orders:'orders'},isArray:true}
	})
])

adminRest.factory('Stock',['$resource',($resource)->
	$resource('/stocks/:id', {id:'@id'})
])

adminRest.factory('Sales',['$resource',($resource)->
	$resource('/sales/:id', {id:'@id'})
])

adminRest.factory('Dues',['$resource',($resource) ->
	$resource('/dues')
])

adminRest.factory('sms',['$resource',($resource)->
	$resource('/sms')
])

