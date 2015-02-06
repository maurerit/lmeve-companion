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
 * Description of User
 *
 * @author maurerit
 */
class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->config->load('lmconfig');
    }

    public function getUser($login) {
        $result = $this->db
                ->where('login', $login)
                ->limit(1)
                ->get($this->config->item('USERSTABLE'));
        return $result->row();
    }

    public function authUser($user, $password) {
        $result = $this->db
                ->where('login', $user)
                ->where('pass', md5($this->config->item('LM_SALT') . $password))
                ->limit(1)
                ->get($this->config->item('USERSTABLE'));

        if ($result->num_rows > 0) {
            return $result->row();
        }
        return false;
    }

    public function getCharacters($userID) {
        $ret = array();
        $chars = $this->db
                        ->select("apicorpmembers.characterID")
                        ->from("apicorpmembers")
                        ->join("lmchars", "apicorpmembers.characterID=lmchars.charID")
                        ->where("lmchars.userID", $userID)->get();
        if ($chars->num_rows > 0) {
            $idx = 0;
            foreach ($chars->result() as $char) {
                $ret[$idx++] = $char->characterID;
            }
        }
        return $ret;
    }

    public function getPermissions($userId) {
        return $this->db
                        ->select("lmrights.rightName")
                        ->from($this->config->item('USERSTABLE'))
                        ->join("lmuserroles", $this->config->item('USERSTABLE') . ".userID=lmuserroles.userID")
                        ->join("lmrolerights", "lmuserroles.roleID=lmrolerights.roleID")
                        ->join("lmrights", "lmrolerights.rightID=lmrights.rightID")
                        ->where($this->config->item('USERSTABLE') . ".userID", $userId)
                        ->get()->result();
    }

    public function getUserDefaultPage($userID) {
        return $this->db
                ->select('defaultPage')
                ->where('userID',$userID)
                ->limit(1)
                ->get($this->config->item('USERSTABLE'))
                ->row();
    }

    public function getCss($userID) {
        $sql = "SELECT `css` FROM `lmusers` WHERE `userID`=?;";
        return $this->db->query($sql, array($userID));
    }

    public function getDefaultCss() {
        return $this->config->item('LM_DEFAULT_CSS');
    }

}

?>
