angular.module('starter.controllers')

.controller('DeliverymanViewOrderCtrl', [
    '$scope','$state','$stateParams','$ionicLoading','$ionicPopup','$cordovaGeolocation','DeliverymanOrder',
    function($scope,$state,$stateParams, $ionicLoading,$ionicPopup,$cordovaGeolocation,DeliverymanOrder){

        var watch;

        $scope.order = {};

        $ionicLoading.show({
            template: '<ion-spinner icon="android"></ion-spinner>'
        });

        DeliverymanOrder.get({id: $stateParams.id,include: "items,cupom"},function(data){
            $scope.order = data.data;
             $ionicLoading.hide();
         },function(responseError){
             $ionicLoading.hide();
         });



            
}]);