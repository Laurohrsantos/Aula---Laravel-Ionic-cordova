angular.module('starter.run').run(['$state', 'PermPermissionStore', 'OAuth', 'UserData', 'PermRoleStore', '$rootScope', 'authService', 'httpBuffer',
    function ($state, PermPermissionStore, OAuth, UserData, PermRoleStore, $rootScope, authService, httpBuffer) {
    PermPermissionStore.definePermission('user-permission', function(){
        return OAuth.isAuthenticated();
    });
    PermPermissionStore.definePermission('client-permission', function () {
        var user = UserData.get();
        if (user == null || !user.hasOwnProperty('role')) {
            return false;
        }
        return user.role == 'client';
    });
    PermRoleStore.defineRole('client-role', ['user-permission', 'client-permission']);
    
    PermPermissionStore.definePermission('deliveryman-permission', function () {
        var user = UserData.get();
        if (user == null || !user.hasOwnProperty('role')) {
            return false;
        }
        return user.role == 'deiveryman';
    });
    PermRoleStore.defineRole('deliveryman-role', ['deliveryman-permission', 'client-permission']);
    
    $rootScope.$on('event:auth-loginRequired', function (event, data){
        switch (data.data.error){
            case 'access_denid':
                if(!$rootScope.refreshingToken){
                    $rootScope.refreshingToken = OAuth.getRefreshToken();
                }
                $rootScope.refreshingToken.then(function (data){
                    authService.loginConfirmed();
                    $rootScope.refreshingToken = null;
                },function (responseError){
                    $state.go('logout');
                });
                break;
            case 'invalid_credentials':
                httpBuffer.rejectAll(data);
                break;
            default:
                $state.go('logout');
                break;
        }
        
    });
}]);
