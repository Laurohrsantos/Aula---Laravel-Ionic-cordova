angular.module('starter.controllers')

.controller('LoginCtrl',  [
    '$scope', '$state', '$ionicPopup', 'UserData', '$ionicLoading', 'User', 'OAuth', 'OAuthToken',
    function ($scope, $state, $ionicPopup, UserData, $ionicLoading, User, OAuth, OAuthToken) {
    
    $scope.user = {
        username: '',
        password: ''
    };
            
    $scope.login = function () {
        
        $ionicLoading.show({
            template: '<ion-spinner icon="android"></ion-spinner>'
        });
        
        var promise = OAuth.getAccessToken($scope.user);            
            promise
            .then(function (data){
                return User.authenticated({include: 'client'}).$promise;
//                $ionicLoading.hide();
//                $state.go('client.checkout');
            }).then(function (data) {
                $ionicLoading.hide();
                UserData.set(data.data);
                $state.go('client.checkout');
            }, function (respondeError) {
                $ionicLoading.hide();
                UserData.set(null);
                OAuthToken.removeToken();
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Credenciais inválidas!'
                });
                console.log(responseError);
            });
    };
}]);
