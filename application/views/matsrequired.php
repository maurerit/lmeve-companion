        <div class="container-fluid" ng-controller="InventoryListCtrl">
            <div class="panel panel-default">
                <div id="mainHeading" class="panel-heading">
                    <h3 class="panel-title">Materials Needed<span class="glyphicon glyphicon-shopping-cart pull-right"></span></h3>
                </div>
                <div class="col-md-3">
                    <!--<div id="search" class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Search</h2>
                        </div>-->
                        <!--Sidebar content-->
                        <!--Search: <input ng-model="query">-->
                        <!--No real use for the below just yet, just doesn't work like I'd want it to-->
                        <!--<br/>
                        Sort by:
                        <select ng-model="orderProp">
                            <option value="-needed">Needed (desc)</option>
                            <option value="needed">Needed (asc)</option>
                        </select>
                        <br/>-->
                        <!--Month:
                        <select ng-model="month">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <br/>
                        Year:
                        <select ng-model="year">
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                        </select>
                        <br/>
                        <button ng-click="refreshToBuy()" id="refreshToBuyBtn" type="button" class="btn btn-info btn-sm">
                            Refresh
                        </button>-->
                    <!--</div>-->
                    <div id="filters" class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Type Filters</h2>
                        </div>
                        <div class="col-md-12">
                            <div class="row" ng-repeat="type in result.types">
                                <input type="checkbox" ng-model="filter[type]">{{type}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul class="list-group">
                        <li ng-repeat="mat in result.mats | filter:query | filter:filterMaterialByProductType |orderBy:orderProp" class="list-group-item">
                            <span>{{mat.name}}</span>
                            <span class="badge">{{mat.needed | number}} needed / {{mat.stocked || 0 | number}} in stock</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info active" role="progressbar" aria-valuenow="{{mat.stocked}}" aria-valuemin="0" aria-valuemax="{{mat.needed}}" style="width: {{(mat.stocked / mat.needed) * 100}}%">
                                    <span class="sr-only">{{(mat.stocked / mat.needed) * 100}} Stocked</span>
                                </div>
                            </div>
                            <button onclick="invTrackerApp.onExpanderClick(this)" ng-attr-id="{{'expander-' + mat.id}}" type="button" class="btn btn-info btn-sm">
                                Show Items <span class="badge">{{mat.requiredFor.length}}</span><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                            </button>
                            <button ng-click="addToBuyList(mat)" ng-attr-id="{{'add-' + mat.id}}" type="button" class="btn btn-info btn-sm">
                                Add to Buy List <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            <ul ng-attr-id="{{'sublist-' + mat.id}}" class="list-group collapse collapsable">
                                <li ng-repeat="required in mat.requiredFor" class="list-group-item">
                                    <span>{{required.name}}</span>
                                    <span class="badge pull-right">{{required.runsTotal}}</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success active" role="progressbar" aria-valuenow="{{required.runsCompleted}}" aria-valuemin="0" aria-valuemax="{{required.runsTotal}}" style="width: {{(required.runsCompleted/required.runsTotal) * 100}}%">
                                            <span class="sr-only">{{(required.runsCompleted/required.runsTotal) * 100}}% Completed</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>