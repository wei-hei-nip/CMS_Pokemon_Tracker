<?php

/**
 * A controller for the home page
 * Class HomeController
 */


class HomeController extends Controller {
    public function process($params) {
        // Retrieve data of the logged user
        $userModel = new UserModel();

        $user = $userModel->getUser();
        $this->data['name'] = $user['name'];
        $this->data['user_group'] = $user['user_group'];
        $this->data['admin'] = $userModel->isAdmin();

        //HTML head
        $this->head = array('title' => 'Home',
                            'description' => 'Home page and description of user access');

        //Set template
        $this->view = 'home';

    }
}

?>