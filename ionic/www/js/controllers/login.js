angular.module('starter.controllers',[])

.controller('LoginCtrl',  [
    '$scope', 'OAuth', '$cookies', '$ionicPopup', '$state',
    function ($scope, OAuth, $cookies, $ionicPopup, $state) {
    
    $scope.user = {
        username: '',
        password: ''
    };
            
    $scope.login = function () {
        OAuth.getAccessToken($scope.user)
            .then(function (data){
                $state.go('home');
            }, function (responseError) {
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Credenciais inválidas!'
                });            
            });
    };
}])

.controller('HomeCtrl',  ['$scope', 'OAuth',
    function($scope){
        //Aqui vai o código para pegar os dados mas não sei como :C
        $scope.user = {
            username: 'Usuário logado.'            
        };
    }
]);

