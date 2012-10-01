filters = angular.module('phonecatFilters',[])

filters.filter('startFrom', -> 
	(input, start) ->
		if angular.isArray(input)
			return input.slice(start)
		input
	)