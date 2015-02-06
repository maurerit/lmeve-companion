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
 * Description of MarketListingsModel
 *
 * @author maurerit
 */
class MarketListings_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
    }

    public function getMarketListingSummary ( ) {
        return $this->db->query("SELECT acm.`name` , itp.`typeName` , sta.`stationName` , mss.`solarSystemName`, sum(amo.volRemaining) as remaining, sum(amo.volEntered) as total, sum(amo.volRemaining*amo.price)/sum(amo.volRemaining) as avgPrice, count(*) as ords
                                   FROM apimarketorders amo
                                   JOIN apicorpmembers acm ON amo.`charID` = acm.`characterID`
                                   JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON amo.`typeID` = itp.`typeID`
                                   JOIN `" . $this->config->item('LM_EVEDB') . "`.staStations sta ON amo.`stationID` = sta.`stationID`
                                   JOIN `" . $this->config->item('LM_EVEDB') . "`.mapSolarSystems mss ON sta.solarSystemID = mss.solarSystemID
                                  WHERE amo.bid =0
                                    AND amo.orderState =0
                                    AND amo.volRemaining >0
                                  GROUP BY acm.`name` , itp.`typeName` , sta.`stationName` , mss.`solarSystemName`")->result();
    }
}

?>
