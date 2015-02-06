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
 * This is the main entry point of the application.  If the user isn't logged in
 * the login view is loaded.  If the user is logged in, then the users prefered
 * landing view is loaded.
 *
 * @author maurerit
 */
class Main extends LMeve_Controller {

    public function index() {
        if ($this->session->userdata('granted')) {
//            $idx = $this->user_model->getUserDefaultPage($this->data['userID']);
            $this->loadViewById(1);
        } else {
            $this->loadCsrf();
            $this->load->view('login', $this->data);
        }
    }

    public function getName() {
        return 'main';
    }

}

?>