angular.module('starter.controllers')

.controller('ClientCheckoutSuccessful', [
    '$scope', '$state', '$cart',
    function($scope, $state, $cart){
        
        var cart = $cart.get();
        $scope.items = cart.items;
        $scope.total = $cart.getTotalFinal();
        $scope.cupom = cart.cupom;
        $cart.clear();
        
        $scope.openList = function () {
            
        };
        
}]);