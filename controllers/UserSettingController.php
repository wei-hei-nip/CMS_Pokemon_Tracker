<?php

/**
 * A controller for the User Setting page
 * Class UserSettingController
 */

class UserSettingController extends Controller {
    public function process($params) {
        $this->authUser(); //only members and admins can use

        // Retrieve data of logged user
        $userModel = new UserModel();
        $user = $userModel->getUser();
        $this->data['user'] = $user;
       
        //Check if parameters indicate change the logged user's profile visibility
        if  (!empty($params['url'][1]) && $params['url'][1] == 'userVisibility'){
            try {
                $visibility = $userModel->changeVisibility($_POST['visibility'], $params['url'][0]);
                if ($visibility[0] === false) {
                    $this->addMessage( $visibility[1] );
                } else {
                    $this->addMessage('Profile visibility changed succefully.');
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
            $this->redirect('user-setting');
        }


        // HTML head
        $this->head['title'] = 'Account Settings';
        $this->head['description'] = 'Settings for Account';

        // Set the template
        $this->view = 'user-setting';
        
    }
}

?>