/*
 * Copyright 2014 maurerit.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

'use strict';

/* Controllers */
invTrackerApp.controller('InventoryListCtrl', ['$scope', '$http', 'dialogs', function($scope, $http, dialogs) {
    var rightNow = new Date();

    $scope.month = rightNow.getMonth() + 1;
    $scope.year = rightNow.getFullYear();
    $scope.orderProp = '-needed';
    $scope.filter = {};

    $http.get('/data/matsNeedByMaterial/'+$scope.year+'/'+$scope.month).success(function(data) {
        $scope.result = data;
    });

    $scope.filterMaterialByProductType = function ( mat ) {
        var include = false, product;
        for ( product in mat.requiredFor ) {
            include |= $scope.filter[mat.requiredFor[product].groupName];
        }
        return include || invTrackerApp.noFilter($scope.filter);
    };

    $scope.addToBuyList = function ( mat ) {
        var dlg = dialogs.create('/addToBuyList.html','buyListController',mat,'lg');
    };
}])
.controller('buyListController', function($scope, $modalInstance, data) {
    $scope.number = 0;
    $scope.data = data;

    $scope.cancel = function ( ) {
        $modalInstance.dismiss('Cancelled');
    };

    $scope.save = function ( ) {
        $modalInstance.close($scope.number);
    };

    $scope.hitEnter = function(evt){
        if ( angular.equals(evt.keyCode,13) &&
             !( angular.equals($scope.user.name,null) ||
                angular.equals($scope.user.name,'')))
        {
            $scope.save();
        }
    };
})
.controller('queueController', ['$scope', '$http', function($scope, $http) {
    var rightNow = new Date();

    $scope.month = rightNow.getMonth() + 1;
    $scope.year = rightNow.getFullYear();

    $scope.filter = {};

    $http.get('/data/queue/'+$scope.year+'/'+$scope.month).success(function(data) {
        $scope.result = data;
    });

    $scope.filterQueueByTaskType = function ( queueItem ) {
        var include = $scope.filter[queueItem.activityName];
        return include||invTrackerApp.noFilter($scope.filter);
    };

    $scope.submit = function () {
//        $http.get('/queue');
    };

    $scope.removeQueue = function (queueItem) {

    };
}]);
