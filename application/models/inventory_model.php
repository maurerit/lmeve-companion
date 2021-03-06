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
 * Description of InventoryModel
 *
 * @author maurerit
 */
class Inventory_model  extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
    }

    public function getNumberStocked ( $typeID, $corporationID ) {
        $result = 0;
        $queryResult = $this->db->query("select sum(quantity) as quantity from apiassets where typeID = $typeID and corporationID = $corporationID");
        if ( $queryResult->num_rows() > 0 ) {
            $result = $queryResult->row();
        }

        return $result;
    }
}

?>
