angular.module('starter.controllers')

.controller('ClientOrderCtrl',  [
    '$scope', '$state', 'ClientOrder', '$ionicLoading', '$ionicPopup', '$ionicActionSheet',
    function ($scope, $state, ClientOrder, $ionicLoading, $ionicPopup, $ionicActionSheet) {
        
    $scope.items = []; 

    $ionicLoading.show({
        template: '<ion-spinner icon="android"></ion-spinner>'
    });
    
    $scope.doRefresh = function () {
        getOrders().then(function (data) {
            $scope.items = data.data;
            $scope.$broadcast('scroll.refreshComplete');
        }, function (dataError) {
            $ionicLoading.hide();
            $scope.$broadcast('scroll.refreshComplete');
            $ionicPopup.alert({
                title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                template: 'Ocorreu um erro ao atualizar, tente novamente.'
            });
        });
    };
    
    $scope.openOrderDetail = function (order) {
        $state.go('client.view_order', {id: order.id});
    };
    
    function getOrders () {        
        return ClientOrder.query({id: null, orderBy: 'created_at', sortedBy: 'desc'}).$promise;        
    };
    
    getOrders().then(function (data) {
            $scope.items = data.data;
            $scope.$broadcast('scroll.refreshComplete');
        }, function (dataError) {
            $ionicLoading.hide();
            $scope.$broadcast('scroll.refreshComplete');
            $ionicPopup.alert({
                title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                template: 'Ocorreu um erro ao atualizar, tente novamente.'
            });
        });
        
    $scope.showActionSheet = function (order) {
        $ionicActionSheet.show({
            buttons: [
                {text: 'Ver Detalhes'},
                {text: 'Ver Entrega'}
            ],
            titleText: 'Opções',
            cancelText: 'Cancelar',
            cancel: function (){
                
            },
            buttonClicked: function (index) {
                switch (index) {
                    case 0:
                        $state.go('client.view_order', {id: order.id});
                        break;
                    case 1:
                        $state.go('client.view_delivery', {id: order.id});
                        break;
                }
            }
        });
    };
        
    $ionicLoading.hide();
    
}]);
