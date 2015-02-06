<div class="container-fluid" ng-controller="queueController">
    <div class="panel panel-default">
        <div id="mainHeading" class="panel-heading">
            <h3 class="panel-title">Queue Items</h3>
        </div>
        <div class="col-md-3">
            <div id="add-queue" class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Add Queue Item</h2>
                </div>
                    <angucomplete id="type-search"
                                  placeholder="Type Name"
                                  pause="400"
                                  selectedobject="itemType"
                                  url="/data/typeSearch/"
                                  titlefield="typeName"></angucomplete>
                    <button onclick="invTrackerApp.onExpanderClick(this)" type="button" class="btn btn-info btn-sm">
                        Add
                    </button>
            </div>
            <div id="filters" class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Task Type Filters</h2>
                </div>
                <div class="col-md-12">
                    <div class="row" ng-repeat="taskType in result.taskTypes">
                        <input type="checkbox" ng-model="filter[taskType]">{{taskType}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <ul class="list-group">
                <li ng-repeat="queueItem in result.queue | filter:query | filter:filterQueueByTaskType" class="list-group-item">
                    <span>{{queueItem.typeName}}</span>
                    <!--<span ng-if="queueItem.activityName==='Manufacturing'" class="pull-left label label-success">Manufacturing</span>
                    <span ng-if="queueItem.activityName==='Invention'" class="pull-left label label-info">Invention</span>-->
                    <span class="badge">{{queueItem.runsDone}}/{{queueItem.runs}}</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info"style="width: {{(queueItem.runsCompleted/queueItem.runs) * 100}}%">
                            <span class="sr-only">{{(queueItem.runsCompleted/queueItem.runs) * 100}} Complete</span>
                        </div>
                        <div ng-if="queueItem.runsDone-queueItem.runsCompleted>0" class="progress-bar progress-bar-warning" style="width: {{((queueItem.runsDone-queueItem.runsCompleted)/queueItem.runs)*100}}%">
                            <span class="sr-only">{{((queueItem.runs-queueItem.runsCompleted)/queueItem.runs)*100}} Pending</span>
                        </div>
                    </div>
                    <button onclick="invTrackerApp.onExpanderClick(this)" ng-attr-id="{{'expander-' + queueItem.queueId}}" type="button" class="btn btn-info btn-sm">
                        Show Assignee's <span class="badge">{{mat.requiredFor.length}}</span><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
                    </button>
                    <?php if (has_permission($permissions, "Administrator")): ?>
                    <button ng-click="" ng-attr-id="{{'update-' + queueItem.queueId}}" type="button" class="btn btn-success btn-sm">
                        Update <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </button>
                    <button ng-click="" ng-attr-id="{{'delete-' + queueItem.queueId}}" type="button" class="btn btn-danger btn-sm">
                        Delete <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                    </button>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</div>
