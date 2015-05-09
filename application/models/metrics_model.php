<?php

/*
 * Copyright 2015 maurerit.
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
 * Description of metrics_model
 *
 * @author maurerit
 */
class Metrics_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('tasks_model');
        $this->load->model('general_model');
    }

    public function getLiquidIsk ( $year, $month ) {
        $corps = $this->general_model->getAllCorps();
        $iskPerPoint = $this->general_model->getIskPerPoint();
        $points = $this->tasks_model->getAllPoints();
        $totalWages = 0.0;

        foreach($corps as $corp) {
            $rearrange = $this->tasks_model->getAllWagesByActivity($iskPerPoint, $corp->corporationID, $year, $month);

            foreach($rearrange as $row) {
                $totalWages += stripslashes($row['wage']);
            }
        }

        return $totalWages;
    }

    public function getInventoryValues ( ) {
        echo 'getInventoryValues'.PHP_EOL;
    }

    public function getRunningJobs ( ) {
        echo 'getRunningJobs'.PHP_EOL;
    }

    public function getRevenue ( ) {
        echo 'getRevenue'.PHP_EOL;
    }
}

?>
