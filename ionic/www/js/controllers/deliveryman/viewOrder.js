angular.module('starter.controllers')

.controller('DeliverymanViewOrderCtrl', [
    '$scope','$state','$stateParams','$ionicLoading','$ionicPopup','$cordovaGeolocation','DeliverymanOrder',
    function($scope,$state,$stateParams, $ionicLoading,$ionicPopup,$cordovaGeolocation,DeliverymanOrder){

        var watch, lat = null, long;

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

         
        $scope.goToDelivery = function () {
            $ionicPopup.alert({
                title: '<p class="energized"><i class="icon icon-left ion-alert-circled"></i> Atenção</p>',
                template: 'A localização está sendo monitorada, para parar aperte OK!'
            }).then(function () {
                 stopWatchPosition();
            });
            DeliverymanOrder.updateStatus({id: $stateParams.id},{status: 1}, function () {
                var watchOptions = {
                    timeout : 3000,
                    enableHighAccuracy: false  //aprimoracao de posicao, nao usaremos, pois, pode causar erros
                };

                watch = $cordovaGeolocation.watchPosition(watchOptions);
                watch.then(
                    null, 
                    function (responseError) {
                        //
                    }, function (position) {
                        console.log(position);
                        if(!lat) {
                            lat = position.coords.latitude;
                            long = position.coords.longitude;
                        } else {
                            long += 0.000444;
                        }                        
                        DeliverymanOrder.geo({id: $stateParams.id}, {
                            lat: lat,
                            long: long
                        });
                    });

            });
        };
        
        
        function stopWatchPosition () {
            if (watch && typeof watch === 'object' && watch.hasOwnProperty('watchID')) {
                $cordovaGeolocation.clearWatch(watch.watchID);
            }
        };        
            
}]);