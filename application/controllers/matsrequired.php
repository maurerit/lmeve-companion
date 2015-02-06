<?php

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

/**
 * This is the main entry point of the application.  If the user isn't logged in
 * the login view is loaded.  If the user is logged in, then the users prefered
 * landing view is loaded.
 *
 * @author maurerit
 */
class MatsRequired extends LMeve_Controller {

    function __construct ( ) {
        parent::__construct();
        $this->load->model('materials_model');
    }

    public function index() {
        //$tasks = $this->materialsModel->getTasksForMaterialsRequired('2014', '12');

        //$taskMats = array();
        //foreach ( $tasks as $task ) {
        //    $taskMats = $this->materialsModel->getBaseMaterials($task->typeID, $task->runs, null, $task->activityID);
        //}

        //$data['mats'] = $this->getMatsNeed();
        $this->template->load('layout', 'matsrequired', $this->data);
    }

    public function getMatsNeed ( ) {
        return $this->mockMatsNeed();
    }

    private function mockMatsNeed ( ) {
        //        {
//            "id": 1234,
//            "name": "Mat 1",
//            "needed": 2000,
//            "stocked": 1500,
//            "requiredFor": [
        $id1234 = new StdClass();
        $id1234->id = 36;
        $id1234->name = "Mat 1";
        $id1234->needed = 2000;
        $id1234->stocked = 1500;
        $id1234->requiredFor = array();
//                {
//                    "name": "125mm Railgun II",
//                    "runsCompleted": 25,
//                    "runsTotal": 200
//                },
        $rail125 = new StdClass();
        $rail125->name = "125mm Railgun II";
        $rail125->runsCompleted = 10;
        $rail125->runsTotal = 50;
        array_push($id1234->requiredFor, $rail125);
//                {
//                    "name": "150mm Railgun II",
//                    "runsCompleted": 10,
//                    "runsTotal": 50
//                },
        $rail150 = new StdClass();
        $rail150->name = "150mm Railgun II";
        $rail150->runsCompleted = 20;
        $rail150->runsTotal = 50;
        array_push($id1234->requiredFor, $rail150);
//                {
//                    "name": "250mm Railgun II",
//                    "runsCompleted": 10,
//                    "runsTotal": 15
//                }
//            ]
//        }
        $rail250 = new StdClass();
        $rail250->name = "250mm Railgun II";
        $rail250->runsCompleted = 17;
        $rail250->runsTotal = 20;
        array_push($id1234->requiredFor, $rail250);

        return array($id1234);
    }

    public function getName() {
        return 'matsrequired';
    }
}

?>