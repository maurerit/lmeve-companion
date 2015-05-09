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
 * Description of metrics
 *
 * @author maurerit
 */
class Metrics extends CI_Controller {
    function __construct ( ) {
        parent::__construct();
        $this->load->model('metrics_model');
    }

    public function index() {

    }

    public function gather ( ) {
        if ( !$this->input->is_cli_request() ) {
            die;
        }
        $inventoryValues = $this->metrics_model->getInventoryValues();
        $runningJobs = $this->metrics_model->getRunningJobs();
        $revenue = $this->metrics_model->getRevenue();
        $liquidIsk = $this->metrics_model->getLiquidIsk(date('Y'), date('m'));
        echo $liquidIsk .PHP_EOL;
    }

    public function getName() {
        return 'metrics';
    }
}

?>
