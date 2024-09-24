<?php


/**
 * A controller for the administration page
 * Class AdminController
 */
class AdminController extends Controller {
    public function process($params) {
        // Only registered users can access the admin page
        $this->authUser();

        // Retrieve data of the logged user
        $userModel = new UserModel();
        if (isset($params['url']) && !empty($params['url'][0]) && $params['url'][0] == 'logoff')  {
            $userModel->logoff();
            $this->redirect('login');
        }
        $user = $userModel->getUser();
        $this->data['name'] = $user['name'];
        $this->data['user_group'] = $user['user_group'];
        $this->data['admin'] = $userModel->isAdmin();

        if (isset($this->data['admin']) && $this->data['user_group']!='admin'){ //if logged in not admin redirect to home page
            $this->redirect('home');
        } else{
            // HTML head
            $this->head['title'] = 'Administration';
            $this->head['description'] = 'Administration Control';
            

            // Set the template
            $this->view = 'admin';
        }
    }
}