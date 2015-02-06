<?php

/**
 * Description of CorpsModel
 *
 * @author maurerit
 */
class General_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->config('lmconfig');
    }

    public function getAllCorps() {
        return $this->db->get('apicorps')->result();
    }

    public function getIskPerPoint() {
        return $this->db->select('itemValue')->where('itemLabel', 'iskPerPoint')->limit(1)->get('lmconfig')->row()->itemValue;
    }

    public function getActivities() {
        return $this->db
                        ->select('activityID, activityName')
                        ->from($this->config->item('LM_EVEDB') . ".ramActivities")
                        ->where('published', 1)
                        ->where('activityID >', 0)
                        ->order_by('activityName')
                        ->get()
                        ->result();
    }

}
