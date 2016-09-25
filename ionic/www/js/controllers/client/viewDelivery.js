angular.module('starter.controllers')
.controller('ClientViewDeliveryCtrl', [
    '$scope', '$stateParams', '$ionicLoading', '$ionicPopup', 'ClientOrder', 'UserData', '$window', '$map', 'uiGmapGoogleMapApi', '$pusher',
    function ($scope, $stateParams, $ionicLoading, $ionicPopup, ClientOrder, UserData, $window, $map, uiGmapGoogleMapApi, $pusher) {
    
    var icon = 'http://maps.google.com/mapfiles/kml/pal3/';
    
    $scope.order = {};

    $scope.map = $map;
//    $scope.map = {
//        center: {
//            latitude: -23.444,
//            longitude: -46.666
//        },
//        zoom: 12
//    };
    
    $scope.markers = [
//        {
//            id: 1,
//            coords: {
//                latitude: -7.9905491,
//                longitude: -38.2931579
//            },
//            options: {
//                title: "Área de Teste",
//                labelContent: "marker-labels",
//                icon: icon + 'icon39.png'
//          }
//        }
    ];
    
    $ionicLoading.show({
        template: '<ion-spinner icon="android"></ion-spinner>'
    });
    
    uiGmapGoogleMapApi.then(function(maps){
        $ionicLoading.hide();
    },function(){
        $ionicLoading.hide();
    });
    
    ClientOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
        $scope.order = data.data;        
        if(parseInt($scope.order.status, 10) === 1) {
            initMarkers($scope.order);
        }else{
            $ionicPopup.alert({
                title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                template: 'O pedido não está em entrega.'
            });
        }
    });
    
    $scope.$watch('markers.length', function (value) {
        if (value === 2) {
            createBounds();
        }
    });
    
    
    function initMarkers (order) {
        var client = UserData.get().client.data;
        var address = client.zipcode + ', ' + client.address + ', ' + client.city + ' - ' + client.state;
        
        createMarkerClient(address);
        watchPosisitionDelivery(order.hash);
    };
    
    function createMarkerClient (address) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: address
        }, function (results, status) {
            if(status === google.maps.GeocoderStatus.OK) {
                var lat = results[0].geometry.location.lat(); 
                var long = results[0].geometry.location.lng();
                
                $scope.markers.push({
                    id: 'client',
                    coords: {
                        latitude: lat,
                        longitude: long
                    },
                    options: {
                        title: "Local de entrega",
                        icon: icon + 'icon47.png'
                    }
                });
                
            }else{
                $ionicPopup.alert({
                title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                template: 'Não foi possível encontrar seu endereço.'
            });
            }        
        });
    };
    
    function watchPosisitionDelivery (channel) {
        var pusher = $pusher($window.client); 
        var channel = pusher.subscribe(channel);

        channel.bind('CodeDelivery\\Events\\GetLocationDeliveryMan', function (data) {
            var lat = data.geo.lat, 
                long = data.geo.long;
                
            if ($scope.markers.length === 1 || $scope.markers.length === 0) {
                
                $scope.markers.push({
                    id: 'entregador',
                    coords: {
                        latitude: lat,
                        longitude: long
                    },
                    options: {
                        title: "Entregador",
                        icon: icon + 'icon47.png'
                    }
                });
                return;
            }
            for (var key in $scope.markers) {
                if ($scope.markers[key.id] === 'entregador') {
                    $scope.markers[key].coords = {
                        latitude: lat,
                        longitude: long
                    };
                }
            }
        });
        channel.trigger('CodeDelivery\\Events\\GetLocationDeliveryMan', {teste: 'teste'});
    };
    
    function createBounds() {        
        var bounds = new google.maps.LatLngBounds();
        var latLng;
        angular.forEach($scope.markers, function (value) {
            latLng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));
            bounds.extend(latLng);
        });
        
        $scope.map.bounds = {
            northeast: {
                latitude: bounds.getNorthEast().lat(),
                longitude: bounds.getNorthEast().lng()
            },
            southwest: {
                latitude: bounds.getSouthWest().lat(),
                longitude: bounds.getSouthWest().lng()
            }
        };
                
    };

}])
.controller('CvdControlDescentralize', ['$scope','$map',function($scope,$map){
$scope.map = $map;
$scope.fit = function(){
    $scope.map.fit = !$scope.map.fit;
};
}])
.controller('CvdControlReload', ['$scope','$window','$timeout',function($scope,$window,$timeout){
$scope.reload = function(){
    $timeout(function(){
        $window.location.reload(true);
    },100);
};
}]);