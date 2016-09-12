angular.module('starter.services')

.factory('Home',['$resource', 'appConfig', function($resource, appConfig){
    return $resource(appConfig.baseUrl+'/api/authenticated',{},{
        query: {
            isArray: false
        }
    });
}]);
