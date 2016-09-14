angular.module('starter.controllers')

.controller('ClientCheckoutCtrl',  [
    '$scope', '$state', '$cart', 'ClientOrder', '$ionicLoading', '$ionicPopup', 'Cupom', '$cordovaBarcodeScanner',
    function ($scope, $state, $cart, ClientOrder, $ionicLoading, $ionicPopup, Cupom, $cordovaBarcodeScanner) {
       
       var cart = $cart.get();
       
       $scope.cupom = cart.cupom;
       $scope.items = cart.items;
       $scope.total = $cart.getTotalFinal();

        $scope.removeItem = function(i){
           $cart.removeItem(i);
           $scope.items.splice(i, 1);
           $scope.total = $cart.getTotalFinal();
       };
       
       $scope.openProductDetail = function (i) {
           $state.go('client.checkout_item_detail', {index: i});
       };
       
       $scope.openListProducts = function () {
           $state.go('client.view_products');
       };
       
       $scope.save = function () {
           
           var o = {items: angular.copy($scope.items)};
           angular.forEach(o.items, function(item) {
               item.product_id = item.id;               
           });
           
           $ionicLoading.show({
               template: '<ion-spinner icon="android"></ion-spinner>'
           });
           
           if($scope.cupom.value){
                if($scope.cupom.value > $cart.get().total){
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                        template: 'O valor do cupom é maior que o valor do pedido! Adicione mais itens no pedido ou remova o cupom.'
                    });
                    return;
                }
                o.cupom_code = $scope.cupom.code;
            };
           
           ClientOrder.save({id: null}, o, function (data){
               $ionicLoading.hide();
               $state.go('client.checkout_successful');
           }, function (responseError){
               $ionicLoading.hide();
               $ionicPopup.alert({
                   title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Advertência</p>',
                   template: 'Pedido não realizado, tente novamente!'
               }); 
           });
       };
       
       $scope.readBarCode = function () {
           $cordovaBarcodeScanner
            .scan()
            .then(function(barcodeData) {
                getValueCode(barcodeData.text);
            }, function(error) {
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Não foi possível ler o código! Tente novamente'
                })
            });
       };
       
       $scope.removeCupom = function () {
           $cart.removeCupom();
           $scope.cupom = $cart.get().cupom;
           $scope.total = $cart.getTotalFinal();
       };
       
       /********************
       * 
       * FUNCOES PRIVADAS
       * 
       ********************/
      
       function getValueCode (code) {
           $ionicLoading.show({
                template: '<ion-spinner icon="android"></ion-spinner>'
            });
            Cupom.get({code: code},function(data){
                $cart.setCupom(data.data.code, data.data.value);
                $scope.cupom = $cart.get().cupom;
                $scope.total = $cart.getTotalFinal();
                $ionicLoading.hide();
            },function(responseError){
                $ionicLoading.hide();
                $ionicPopup.alert({
                    title: '<p class="assertive"><i class="icon icon-left ion-alert"></i> Erro</p>',
                    template: 'Cupom inválido!'
                })
            });
       };
    
    
           
}]);
