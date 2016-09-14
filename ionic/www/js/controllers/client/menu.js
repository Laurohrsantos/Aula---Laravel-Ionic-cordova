angular.module('starter.controllers')

.controller('ClientMenuCtrl',  [
    '$scope', '$state', 'User', '$ionicLoading', 'UserData',
    function ($scope, $state, User, $ionicLoading, UserData) {
        
    $scope.user = UserData.get();

}]);
