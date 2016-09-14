angular.module('starter.controllers')

.controller('DeliverymanOrderCtrl', [
    '$scope', '$state', '$ionicLoading', 'DeliverymanOrder', '$ionicPopup',
    function($scope, $state, $ionicLoading, DeliverymanOrder, $ionicPopup){
        
        $scope.orders = [];

        $ionicLoading.show({
            template: '<ion-spinner icon="android"></ion-spinner>'
        });

        $scope.doRefresh = function(){
            getOrders().then(function (data){
                $scope.orders = data.data;
                $scope.$broadcast('scroll.refreshComplete');
            }, function (dataError) {
                $scope.$broadcast('scroll.refreshComplete');
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Ocorreu um erro ao atualizar, tente novamente.'
                });
            });
        };

        $scope.openOrderDetail = function(order){
            $state.go('deliveryman.view_order',{id: order.id});
        };

        function getOrders(){
            return DeliverymanOrder.query({id: null, orderBy: 'created_at', sortedBy: 'desc' }).$promise;
        };

        getOrders().then(function (data){
            $scope.orders = data.data;
            $scope.$broadcast('scroll.refreshComplete');
            $ionicLoading.hide();
        }, function (dataError) {
            $ionicLoading.hide();
            $scope.$broadcast('scroll.refreshComplete');
            $ionicPopup.alert({
                title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                template: 'Ocorreu um erro ao atualizar, tente novamente.'
            });
        });
}]);