<!--
Copyright 2014 maurerit.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<!doctype html>
<html lang="en" ng-app="invTrackerApp">
    <head>
        <meta charset="utf-8">
        <title>LMeve Inventory Tracker</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <script src="/js/libs/jquery.min.js"></script>
        <script src="/js/libs/bootstrap.min.js"></script>
        <script src="/js/app-ingame.js"></script>
        <script src="/js/app-functions.js"></script>
    </head>
    <body ng-controller="InventoryListCtrl">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Materials Needed</h3>
            </div>
            <ul class="list-group">
                <?php foreach($mats as $mat): ?>
                    <li class="list-group-item">
                        <a id="<?php echo $mat->id; ?>" onclick="invTrackerApp.openEveMarket(this.id);"><?php echo $mat->name; ?></a>
                        <span>
                        <?php
                            echo '&nbsp;(';
                            echo ($mat->needed - $mat->stocked);
                            echo ')';
                        ?>
                        </span>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info active" role="progressbar" aria-valuenow="<?php echo $mat->stocked; ?>" aria-valuemin="0" aria-valuemax="<?php echo $mat->needed; ?>" style="width: <?php echo (($mat->stocked / $mat->needed) * 100); ?>%">
                                <span class="sr-only"><?php echo (($mat->stocked / $mat->needed) * 100); ?> Stocked</span>
                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </body>
</html>