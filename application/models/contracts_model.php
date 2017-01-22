<?php

/*
 * Copyright 2017 maurerit.
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
 * Description of Contracts_model
 *
 * @author maurerit
 */
class Contracts_model  extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
    }

    public function getContracts ( $lastContractSent ) {
        $result = $this->db->query("SELECT lmb.*,apc.issuerID,apc.status,apc.type,apc.dateIssued,apc.price
                        FROM `lmbuyback` lmb
                        JOIN `" . $this->config->item('USERSTABLE') . "` lmu
                        ON lmb.`userID`=lmu.`userID`
                        LEFT JOIN `apicontracts` apc
                        ON lmb.`shortHash`=apc.`title`
                        WHERE lmb.orderID >= " . $lastContractSent)->result();

        $contracts = [];

        foreach ( $result as $row ) {
            $contents = unserialize($row->orderSerialized);
            $contract = new stdClass();

            $contract->items = [];
            foreach ( $contents as $deserializedItem ) {
                $item = new stdClass();
                $item->typeID = $deserializedItem['typeID'];
                $item->quantity = $deserializedItem['quantity'];
                $item->unitPrice = $deserializedItem['unitprice'];

                array_push($contract->items, $item);
            }

            $contract->shortHash = $row->shortHash;
            $contract->issuerID = $row->issuerID;
            $contract->status = $row->status;
            $contract->dateIssued = $row->dateIssued;
            $contract->price = $row->price;

            array_push($contracts, $contract);
        }

        return $contracts;
    }
}

?>
