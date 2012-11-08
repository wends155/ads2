adminRest = angular.module('AdminServices',['ngResource'])

adminRest.factory('adOrder',['$resource',($resource)->
	$resource('/orders/:id', {id:'@id'})
])

adminRest.factory('adProfiles',['$resource',($resource)->
	$resource('/profiles/:id', {id:'@id'})
])