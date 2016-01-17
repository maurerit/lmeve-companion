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
 * Description of data
 *
 * @author maurerit
 */
class Data extends CI_Controller {
    function __construct ( ) {
        parent::__construct();
        $this->load->model('materials_model');
        $this->load->model('marketlistings_model');
        $this->load->model('queue_model');
        $this->load->model('type_model');
        $this->load->model('tasks_model');
    }

    public function matsNeedByMaterial ($year, $month) {
        $mats = $this->materials_model->getMatsNeedByMaterial($year, $month);
        $data = new stdClass();
        $data->mats = $mats;
        $data->types = $this->getTypes($mats);
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
    }

    public function matsNeedForSpreadsheet ( ) {
        $results = $this->materials_model->getMatsForSpreadSheetImport();

        $xml = '<materialsNeeded>';

        foreach ( $results as $row ) {
            $xml = $xml . '<row character="' . $row->character . '"
                task="' . $row->task . '" itemType="' . $row->itemType . '"
                producedType="' . $row->producedType . '" runsCompleted="' . $row->runsCompleted . '" totalRuns="' .
                $row->totalRuns . '" quantityNeeded="' . $row->quantityNeeded . '" />';
        }

        $xml = $xml . '</materialsNeeded>';

        $this->output
                ->set_content_type('application/xml')
                ->set_output($xml);
    }

    public function matsForNextMonth ( ) {
        $results = $this->materials_model->getMatsForNextMonth();

        $xml = '<materialsNeeded>';

        foreach ( $results as $row ) {
            $xml = $xml . '<row character="' . $row->character . '"
                task="' . $row->task . '" itemType="' . $row->itemType . '"
                producedType="' . $row->producedType . '" quantityNeeded="' . $row->quantityNeeded . '" />';
        }

        $xml = $xml . '</materialsNeeded>';

        $this->output
                ->set_content_type('application/xml')
                ->set_output($xml);
    }

    public function marketListingSummary ( ) {
        $data = array();
        $data['marketListings'] = $this->marketlistings_model->getMarketListingSummary();
        $this->load->view('market_listings',$data);
    }

    public function queue ( $year, $month ) {
        if (!$year) {
            $year = date('Y');
            $month = date('m');
        }
        $queueItems = $this->queue_model->getQueue($year, $month);

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($queueItems));
    }

    public function memberBases ( ) {

    }

    private function getTypes ( $mats ) {
        $typesAssoc = array();
        foreach ( $mats as $mat ) {
            foreach ( $mat->requiredFor as $product ) {
                $typesAssoc[$product->groupName] = $product->groupName;
            }
        }

        return array_values($typesAssoc);
    }

    public function getPriceData ( $typeID ) {

    }

    public function typeSearch ( $typeName ) {
        $this->output
                ->set_content_type('application/json')
                ->set_output('[{"typeName":"Test 1"},{"typeName":"Test 2"}]');
    }

    public function getName() {
        return 'data';
    }
}
?>
