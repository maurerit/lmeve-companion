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
 * Description of MaterialsModel
 *
 * @author maurerit
 */
class Materials_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
        $this->load->model('inventory_model');
    }

    public function getMatsNeedByMaterial($year, $month) {
        $tasks = $this->getTasksForMaterialsRequired($year, $month);

        $mats = array();
        foreach ( $tasks as $task ) {
            $runs = $task->runs-$task->runsDone;
            //TODO: Hmm, was I high when I wrote this?
            if ($portionSize=$this->getPortionSize($task->typeID)) {
                $runs = $runs/$portionSize;
            }

            $taskMats = $this->getBaseMaterials($task->typeID, $runs, null, $task->activityID);
            foreach ( $taskMats as $taskMat ) {
                $mat = $mats[$taskMat->typeID];

                //Don't care about Data Interfaces at all
                if (strpos($taskMat->typeName,'Data Interface')!==false) continue;

                if (!$mat) {
                    //TODO: find a way to have this passed from the front end.
                    $corporationID = 1211383288;
                    $stocked = $this->inventory_model->getNumberStocked($taskMat->typeID, $corporationID);
                    //if its still null then we have 0 stocked and need to purchase some
                    if (!$stocked) {
                        $stocked = new stdClass();
                        $stocked->quantity = 0;
                    }
                    $stockedMats[$taskMat->typeID] = $stocked;

                    $mat = new stdClass();
                    $mat->id = $taskMat->typeID;
                    $mat->name = $taskMat->typeName;
                    $mat->needed = $taskMat->notperfect;
                    $mat->stocked = $stocked->quantity;
                    $mat->requiredFor = array();

                    $mats[$taskMat->typeID] = $mat;
                }
                else {
                    $mat->needed += $taskMat->notperfect;
                }

                if ( $mat ) {
                    $product = new stdClass();
                    $product->name = $task->typeName;
                    $product->runsCompleted = $task->runsDone;
                    $product->runsTotal = $task->runs;
                    $product->groupName = $task->groupName;

                    array_push($mat->requiredFor, $product);
                }
            }
        }

        foreach ( $mats as $matKey => $mat ) {
            if ( ($mat->needed-$mat->stocked) <= 0 ) {
                unset($mats[$matKey]);
            }
        }

        return array_values($mats);
    }

    public function getMatsForSpreadSheetImport ( ) {
        $tasks = $this->getTasksForSpreadSheet(date('Y'), date('m'));
        $results = [];

        foreach ( $tasks as $task ) {
            $runs = $task->runs-$task->runsDone;
            //TODO: Hmm, was I high when I wrote this?
            if ($portionSize=$this->getPortionSize($task->typeID)) {
                $runs = $runs/$portionSize;
            }

            $taskMats = $this->getBaseMaterials($task->typeID, $runs, null, $task->activityID);

            foreach ( $taskMats as $taskMat ) {
                $result = new stdClass();
                $result->character = $task->name;
                $result->task = $task->activityName;
                $result->itemType = $taskMat->typeName;
                $result->runsCompleted = $task->runsDone;
                $result->totalRuns = $task->runs;
                $result->quantityNeeded = ($taskMat->notperfect < 0 ? 0: $taskMat->notperfect);

                array_push($results, $result);
            }
        }

        return $results;
    }

    public function getTasksForMaterialsRequired($year, $month) {
        return $this
                        ->db
                        ->query("SELECT a.typeName, a.groupName, a.activityName, a.typeID,a.activityID,sum(a.runs) as runs,sum(b.runsDone) as runsDone
                            FROM (
                                  SELECT acm.name, grps.groupName, lmt.characterID, itp.typeName, lmt.typeID, rac.activityName, lmt.activityID, lmt.taskID, lmt.runs
                                    FROM lmtasks lmt
                                    JOIN apicorpmembers acm ON acm.characterID=lmt.characterID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.ramActivities rac ON lmt.activityID=rac.activityID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.invGroups grps ON itp.groupID = grps.groupID
                                   WHERE ((singleton=1 AND lmt.taskCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                                  ) AS a
                            LEFT JOIN (
                                       SELECT lmt.taskID, SUM(aij.runs)*itp.portionSize AS runsDone, COUNT(*) AS jobsDone
                                         FROM lmtasks lmt
                                         JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                                         JOIN apiindustryjobs aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID AND lmt.characterID=aij.installerID
                                        WHERE beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')
                                          AND ((singleton=1 AND lmt.taskCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                                        GROUP BY lmt.characterID, lmt.typeID, lmt.activityID, lmt.taskID
                                  ) AS b ON a.taskID=b.taskID
                           group by a.typeID, a.activityID
                           order by a.typeID asc")->result();
    }

    //TODO: I really don't care if this is c&p'ed from above... lets hack this shit... I'm abandoning it anyway :P
    public function getTasksForSpreadSheet($year, $month) {
        return $this
                        ->db
                        ->query("SELECT a.name, a.typeName, a.groupName, a.activityName, a.typeID,a.activityID,sum(a.runs) as runs,sum(b.runsDone) as runsDone
                            FROM (
                                  SELECT acm.name, grps.groupName, lmt.characterID, itp.typeName, lmt.typeID, rac.activityName, lmt.activityID, lmt.taskID, lmt.runs
                                    FROM lmtasks lmt
                                    JOIN apicorpmembers acm ON acm.characterID=lmt.characterID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.ramActivities rac ON lmt.activityID=rac.activityID
                                    JOIN `" . $this->config->item('LM_EVEDB') . "`.invGroups grps ON itp.groupID = grps.groupID
                                   WHERE ((singleton=1 AND lmt.taskCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                                  ) AS a
                            LEFT JOIN (
                                       SELECT lmt.taskID, SUM(aij.runs)*itp.portionSize AS runsDone, COUNT(*) AS jobsDone
                                         FROM lmtasks lmt
                                         JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                                         JOIN apiindustryjobs aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID AND lmt.characterID=aij.installerID
                                        WHERE beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')
                                          AND ((singleton=1 AND lmt.taskCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                                        GROUP BY lmt.characterID, lmt.typeID, lmt.activityID, lmt.taskID
                                  ) AS b ON a.taskID=b.taskID
                           group by a.typeID, a.activityID, a.name
                           order by a.typeID asc")->result();
    }

    public function getBaseMaterials($typeID, $runs = 1, $melvl_override = null, $activityID = 1) {
        $bpo = $this->getBlueprintByProduct($typeID);
        $techLevel = $bpo->techLevel;

        $materials = $this->db->query("SELECT rtr.`requiredTypeID` AS typeID, itp.`typeName`, rtr.`quantity`, rtr.`damagePerJob`, rtr.`recycle`
        FROM `" . $this->config->item('LM_EVEDB') . "`.`ramTypeRequirements` rtr
        JOIN `" . $this->config->item('LM_EVEDB') . "`.`invTypes` itp
        ON rtr.`requiredTypeID` = itp.`typeID`
        WHERE rtr.`typeID` = $typeID
        AND `activityID` = $activityID
        ORDER BY rtr.`requiredTypeID`;")->result();

        if ($set = $this->getMEPE($typeID)) {
            $melevel = $set->me;
            $pelevel = $set->pe;
        }
        switch ($techLevel) {
            case 2:
                if (!isset($melevel))
                    $melevel = 0;
                if (!isset($pelevel))
                    $pelevel = 0;
                break;
            case 3:
                if (!isset($melevel))
                    $melevel = 0;
                if (!isset($pelevel))
                    $pelevel = 0;
                break;
            default:
                if (!isset($melevel))
                    $melevel = 0;
                if (!isset($pelevel))
                    $pelevel = 0;
        }
        if (!is_null($melvl_override)) {
            $melevel = $melvl_override;
        }

        //new formulas (post-Crius)
        if ($melevel > 10)
            $melevel = 10;
        $multiplier = 1 - (0.01 * $melevel);
        $waste = $melevel;
        $materialsResult = array();

        foreach ($materials as $i => $row) {
            $materialsResult[$i] = new StdClass();
            $materialsResult[$i]->typeID = $row->typeID;
            $materialsResult[$i]->typeName = $row->typeName;
            $materialsResult[$i]->quantity = $runs * $row->quantity;
            $materialsResult[$i]->notperfect = $runs * round($row->quantity * $multiplier);
            $materialsResult[$i]->waste = $waste;
        }
        //end ME modification
        return $materialsResult;
    }

    /**
     * Finds blueprint typeID for product typeID
     *
     * @global type $LM_EVEDB - static data dump schema
     * @param $typeID - blueprint typeID
     */
    public function getBlueprintByProduct($typeID) {
        $blueprint = $this->db->query("SELECT * FROM `" . $this->config->item('LM_EVEDB') . "`.`invBlueprintTypes` WHERE `productTypeID` = $typeID;")->result();
        //$techLevel=$blueprint[0][4];
        //$wasteFactor=$blueprint[0][11]/100;
        if (count($blueprint) == 1) {
            return $blueprint[0];
        } else { //blueprint not found... maybe given typeID is a blueprint itself??
            $blueprint = $this->db->query("SELECT * FROM `" . $this->config->item('LM_EVEDB') . "`.`invBlueprintTypes` WHERE `blueprintTypeID` = $typeID;")->result();
            if (count($blueprint) == 1) {
                //ha! it's blueprint all right! told you!!
                return $blueprint[0];
            } else {
                //not found either... mkay, return false
                return FALSE;
            }
        }
    }

    public function getMEPE($typeID) {
        $settings = $this->db->query("SELECT * FROM `cfgbpo` WHERE `typeID` = $typeID;")->result();
        if (count($settings) == 1) {
            return $settings[0];
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the refine/reprocess portion size
     *
     * @global type $LM_EVEDB - static data dump schema
     * @param type $typeID - typeID of the item in question
     * @return mixed portion size or false if not found
     */
    public function getPortionSize($typeID) {
        $portionSize = $this->db->query("SELECT `portionSize` FROM `" . $this->config->item('LM_EVEDB') . "`.`invTypes` WHERE `typeID`=$typeID");
        if ($portionSize->num_rows() == 1) {
            return $portionSize->row()->portionSize;
        } else {
            return FALSE;
        }
    }

}

?>
