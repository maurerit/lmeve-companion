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
 * Description of Queue
 *
 * @author maurerit
 */
class Queue_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->config->load('lmconfig');
    }

    public function getQueueItem($id) {
        return $this->db
                        ->select("lmqueue.*,invTypes.typeName")
                        ->from('lmqueue')
                        ->join("`" . $this->config->item('LM_EVEDB') . "`.invTypes", "lmqueue.typeID = invTypes.typeID")
                        ->where('queueId', $id)->get()->row();
    }

    public function getQueue($year, $month) {
        $sql = $this->queueQuery($year, $month);
        $queueItems = $this->db->query($sql)->result();

        $taskTypes = array();

        foreach ( $queueItems as $queueItem ) {
            $taskTypes[$queueItem->activityName] = $queueItem->activityName;
        }

        $result = new stdClass();
        $result->queue = $queueItems;
        $result->taskTypes = array_values($taskTypes);

        return $result;
    }

    public function updateQueueItem($queueId, $typeId, $activityId, $quantity, $singleton) {

        $this->db
                ->where('queueId', $queueId)
                ->update('lmqueue', array('typeId' => $typeId,
                    'activityId' => $activityId,
                    'runs' => $quantity,
                    'singleton' => $singleton)
        );
    }

    public function createQueueItem($typeId, $activityId, $quantity, $singleton) {
        $this->db
                ->insert('lmqueue', array('typeId' => $typeId,
                    'activityId' => $activityId,
                    'runs' => $quantity,
                    'singleton' => $singleton)
        );
    }

    public function delete($queueId) {
        $this->db
                ->where('queueId',$queueId)
                ->delete('lmqueue');
    }

    private function queueQuery($year, $month) {
        return "SELECT a.*, b.runsDone,b.jobsDone,c.jobsSuccess,d.jobsCompleted,e.runsCompleted
                  FROM (
                        SELECT itp.typeName, lmt.typeID, lmt.queueId, rac.activityName, lmt.activityID, lmt.runs
                          FROM lmqueue AS lmt
                          JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes AS itp ON lmt.typeID = itp.typeID
                          JOIN `" . $this->config->item('LM_EVEDB') . "`.ramActivities AS rac ON lmt.activityID=rac.activityID
                         WHERE ((singleton=1 AND lmt.queueCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                        ) as a
                  LEFT JOIN (
                             SELECT lmt.queueId, SUM(aij.runs)*itp.portionSize AS runsDone, COUNT(*) AS jobsDone
                               FROM lmqueue AS lmt
                               JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes AS itp ON lmt.typeID=itp.typeID
                               JOIN apiindustryjobs aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID
                              WHERE (beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01'))
                                AND ((singleton=1 AND lmt.queueCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                              GROUP BY lmt.typeID, lmt.activityID, lmt.queueId
                             ) AS b ON a.queueId = b.queueId
                  LEFT JOIN (
                             SELECT lmt.queueId, COUNT(*) AS jobsSuccess
                               FROM lmqueue AS lmt
                               JOIN apiindustryjobs AS aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID
                              WHERE aij.completed=1 AND aij.completedStatus=1 AND (beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01'))
                                AND ((singleton=1 AND lmt.queueCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                              GROUP BY lmt.typeID, lmt.activityID, lmt.queueId
                             ) AS c on a.queueId = c.queueId
                  LEFT JOIN (
                             SELECT lmt.queueId, COUNT(*) AS jobsCompleted, SUM(aij.runs) * itp.portionSize AS runsCompleted
                               FROM lmqueue AS lmt
                               JOIN apiindustryjobs AS aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID
                               JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                              WHERE aij.completed=1 AND (beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01'))
                                AND ((singleton=1 AND lmt.queueCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                              GROUP BY lmt.typeID, lmt.activityID, lmt.queueId
                             ) AS d on a.queueId = d.queueId
                  LEFT JOIN (
                             SELECT lmt.queueId, SUM(aij.runs) * itp.portionSize AS runsCompleted
                               FROM lmqueue AS lmt
                               JOIN apiindustryjobs AS aij ON lmt.typeID=aij.outputTypeID AND lmt.activityID=aij.activityID
                               JOIN `" . $this->config->item('LM_EVEDB') . "`.invTypes itp ON lmt.typeID=itp.typeID
                              WHERE (beginProductionTime BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) AND aij.endProductionTime < UTC_TIMESTAMP()
                                AND ((singleton=1 AND lmt.queueCreateTimestamp BETWEEN '${year}-${month}-01' AND LAST_DAY('${year}-${month}-01')) OR (singleton=0))
                              GROUP BY lmt.typeID, lmt.activityID, lmt.queueId
                             ) AS e on a.queueId = e.queueId
                 ORDER BY  a.typeName, a.activityName";
    }

}

?>
