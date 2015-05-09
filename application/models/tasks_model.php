<?php

/**
 * Description of TasksModel
 *
 * @author maurerit
 */
class Tasks_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->config->load('lmconfig');
    }

    public function getAllPoints() {
        $sql = "SELECT rac.`activityName`,cpt.* FROM `" . $this->config->item('LM_EVEDB') . "`.`ramActivities` rac JOIN `cfgpoints` cpt ON rac.`activityID`=cpt.`activityID` ORDER BY `activityName`";
        return $this->db->query($sql)->result();
    }

    public function getAllStats($corp, $year, $month) {
        $sql = "SELECT `activityName`, COUNT(*) AS jobs, SUM(TIME_TO_SEC(TIMEDIFF(`endProductionTime`,`beginProductionTime`))/3600) AS hours
	FROM `apiindustryjobs` aij
	JOIN `" . $this->config->item('LM_EVEDB') . "`.`ramActivities` rac
	ON aij.activityID=rac.activityID
	WHERE date_format(beginProductionTime, '%Y%m') = '${year}${month}'
	AND aij.corporationID='$corp'
	GROUP BY `activityName`
	ORDER BY `activityName`;";
        return $this->db->query($sql)->result();
    }

    public function getAllWagesByActivity($onepointValue, $corporationId, $year, $month) {
        $sql = "SELECT *,ROUND((points*$onepointValue),2) as wage FROM (
      SELECT `characterID`,`name`,`activityName`,SUM(TIME_TO_SEC(TIMEDIFF(`endProductionTime`,`beginProductionTime`))/3600)/hrsPerPoint AS points
      FROM `apiindustryjobs` aij
      JOIN `" . $this->config->item('LM_EVEDB') . "`.`ramActivities` rac
      ON aij.activityID=rac.activityID
      JOIN cfgpoints cpt
      ON aij.activityID=cpt.activityID
      JOIN apicorpmembers acm
      ON aij.installerID=acm.characterID
      WHERE date_format(beginProductionTime, '%Y%m') = '${year}${month}'
      AND aij.corporationID=$corporationId
      GROUP BY `characterID`,`name`,`activityName`
      ORDER BY `name`,`activityName`) AS wages;";

        $data = $this->db->query($sql)->result();

        $rearrange = array();

        foreach ($data as $row) {
            $rearrange[$row->characterID]['activities'][stripslashes($row->activityName)]['points'] = stripslashes($row->points);
            $rearrange[$row->characterID]['activities'][stripslashes($row->activityName)]['activityName'] = stripslashes($row->activityName);
            $rearrange[$row->characterID]['totalpoints']+=stripslashes($row->points);
            $rearrange[$row->characterID]['wage']+=stripslashes($row->wage);
            $rearrange[$row->characterID]['name'] = stripslashes($row->name);
            $rearrange[$row->characterID]['characterID'] = $row->characterID;
        }

        return $rearrange;
    }

    public function getWorkersForTypeID ( $typeID, $year, $month ) {

    }
}
