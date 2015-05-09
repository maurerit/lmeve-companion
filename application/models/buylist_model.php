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
 * Description of buylist_model
 *
 * @author maurerit
 */
class Buylist_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
    }

    public function addToBuyList ( $buylistId, $typeID, $quantity, $quotedPrice ) {
        $this->db->trans_start();
        $data = array($buylistId, $typeID, $quantity, $quotedPrice, 0);
        $this->db->insert('lmcbuylist',$data);
        $this->db->trans_complete();
    }
}

?>
