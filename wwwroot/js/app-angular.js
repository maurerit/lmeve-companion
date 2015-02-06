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

var invTrackerApp = angular.module('invTrackerApp', ['ui.bootstrap','dialogs.main','angucomplete']);

$(function() {
//    $('#mainHeading').popover({content: "Help", title: "Popover", trigger: 'hover', placement: 'bottom'});
});

invTrackerApp.onExpanderClick = function ( button ) {
    var btnId = button.id.split('-')[1];
    var button = $('#expander-' + btnId);

    if(button.children('span.glyphicon').hasClass('glyphicon-arrow-down')) {
        this.expand(button, btnId);
    }
    else {
        this.collapse(button, btnId);
    }
};

invTrackerApp.collapse = function ( button, id ) {
    button.children('span.glyphicon').removeClass('glyphicon-arrow-up');
    button.children('span.glyphicon').addClass('glyphicon-arrow-down');
    $('#sublist-' + id).slideToggle("slow");
    $('#sublist-' + id).removeClass("collapse");
};

invTrackerApp.expand = function ( button, id ) {
    button.children('span.glyphicon').removeClass('glyphicon-arrow-down');
    button.children('span.glyphicon').addClass('glyphicon-arrow-up');
    $('#sublist-' + id).slideToggle("slow");
    $('#sublist-' + id).removeClass("collapse");
};

invTrackerApp.noFilter = function (filterObj) {
    for (var key in filterObj) {
        if (filterObj[key]) {
            return false;
        }
    }
    return true;
};
