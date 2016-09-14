angular.module('starter.controllers')

.controller('HomeCtrl',  [
    '$scope', 'OAuth', '$cookies', '$ionicPopup', '$state', 'Home', '$ionicLoading',
    function ($scope, OAuth, $cookies, $ionicPopup, $state, Home, $ionicLoading) {
    
    
    $ionicLoading.show({
        template: '<ion-spinner icon="android"></ion-spinner>'
    });
    
    Home.query({}, function (data) {
        $scope.user = data;        
        $ionicLoading.hide();
    }, function (dataError) {
         $ionicLoading.hide();
    });
    
}]);
