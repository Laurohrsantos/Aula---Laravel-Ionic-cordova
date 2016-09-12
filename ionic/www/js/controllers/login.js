angular.module('starter.controllers')

.controller('LoginCtrl',  [
    '$scope', 'OAuth', '$cookies', '$ionicPopup', '$state', '$ionicLoading',
    function ($scope, OAuth, $cookies, $ionicPopup, $state, $ionicLoading) {
    
    $scope.user = {
        username: '',
        password: ''
    };
            
    $scope.login = function () {
        $ionicLoading.show({
            template: '<ion-spinner icon="android"></ion-spinner>'
        });
        OAuth.getAccessToken($scope.user)
            .then(function (data){
                $ionicLoading.hide();
                $state.go('client.checkout');
            }, function (responseError) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Credenciais inválidas!'
                });            
            });
    };
}]);

