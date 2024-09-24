<?php

class UsersController extends Controller {
    public function process($params) {
        // Only registered users can access the admin page
        $this->authUser('admin');

        

        // Retrieve data of all logged user
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        $this->data['users'] = $users;

        //get data of current user
        $user = $userModel->getUser();
       
       

        //Check if parameters indicate remove users
        if (!empty($params['url'][1]) && $params['url'][1] == 'remove') {

            try {
                $remove_user = $userModel->removeUser($params['url'][0]);
                if ($remove_user[0] === false) {
                    $this->addMessage( $remove_user[1] );
                } else {
                    $this->addMessage('User (ID: '. $params["url"][0] .') was successfully removed');
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
            $this->redirect('users');
        } //Check if parameters indicate assign user group 
        else if  (!empty($params['url'][1]) && $params['url'][1] == 'assignUser'){
            try {
                $assign_user = $userModel->assignUser($_POST['assignUser'], $params['url'][0]);
                if ($assign_user[0] === false) {
                    $this->addMessage( $assign_user[1] );
                } else {
                    $this->addMessage('User (ID: '. $params["url"][0] .') was successfully assigned to '. $_POST['assignUser']);
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
            $this->redirect('users');
        }


        // HTML head
        $this->head['title'] = 'Users';
        $this->head['description'] = 'Users detail and account management';
    
        // Set the template
        $this->view = 'users';
        
    }
}