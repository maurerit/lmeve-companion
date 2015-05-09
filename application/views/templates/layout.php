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
        <title>LMeve Companion</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/js/libs/dialogs/4.2.0/min.css">
        <link rel="stylesheet" href="/js/libs/angucomplete/angucomplete.css">
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/js/libs/bootstrap-slider/4.5.0/min.css">
        <script src="/js/libs/jquery.min.js"></script>
        <!--<script src="/js/libs/angular.min.js"></script>
        <script src="/js/libs/angular-route.min.js"></script>-->
        <script src="//code.angularjs.org/1.2.16/angular.min.js"></script>
        <script src="//code.angularjs.org/1.2.16/angular-sanitize.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bower-angular-translate/2.0.1/angular-translate.min.js"></script>
        <script src="/js/libs/bootstrap.min.js"></script>
        <script src="/js/libs/ui-bootstrap/0.12/min.js"></script>
        <script src="/js/libs/dialogs/4.2.0/full.js"></script>
        <script src="/js/libs/angucomplete/angucomplete.js"></script>
        <script src="/js/libs/bootstrap-slider/4.5.0/min.js"></script>
        <script src="/js/app-angular.js"></script>
        <script src="/js/controllers.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/main.html">LMeve Companion</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo $LMEVE_LINK ?>">LMeve</a></li>
                        <!--<li><a href="#">Link</a></li>-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pages <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <!--<li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="#">One more separated link</a></li>-->
                                <?php echo $pages ?>
                            </ul>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" ng-model="query" placeholder="Search">
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/main/logout.html">Logout</a></li>
                        <!--<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php echo $body ?>
    </body>
</html>
