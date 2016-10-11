angular.module('starter.run').run(['PermPermissionStore', 'OAuth', 'UserData', 'PermRoleStore',
    function (PermPermissionStore, OAuth, UserData, PermRoleStore) {
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
}]);
