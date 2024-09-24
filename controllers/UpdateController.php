<?php

class UpdateController extends Controller {
    public function process($params) {
        // Creating a model instance which allows us to access update announcements
        $updateModel = new UpdateModel();
        // Retrieve data of the logged user
        $userModel = new UserModel();

        /* If the URL is empty (no update announcement url) then we display the list of updates.
         * If there is a parameter we use it as a url to search in the database with the help of our model. */
        // The URL for update announcement removal is entered
        if (!empty($params['url'][1]) && $params['url'][1] == 'remove') {
            $this->authUser('admin');
            try {
                $remove_update = $updateModel->removeUpdate($params['url'][0]);
                if ($remove_update[0] === false) {
                    $this->addMessage( $remove_update[1] );
                } else {
                    $this->addMessage('The update was successfully removed');
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
            $this->redirect('update');
        }
        elseif (empty($params['url'][0])) {
            // List all update announcements
            $updates = $updateModel->getUpdates();
            // HTML head
            $this->head = array('title' => 'Update');
            $this->head = array('description' => 'Update announcements of pokedex tracker');

            // Set template variables
            $this->data['updates'] = $updates;
            $this->data['admin'] = $userModel->isAdmin();
            // Set our view
            $this->view = 'updates';
        } else {
            // Retrieve an update announcement by the URL
            $update = $updateModel->getUpdate($params['url'][0]);
            // If no update announcement was found display an error
            if (!$update) {
                die('Requested update was not found');
            }
            // HTML head
            $this->head = array(
                'title' => $update['title'],
                'description' => "Content of Update". $update['version_number']
            );
            // Set template variables
            $this->data['version_number'] = $update['version_number'];
            $this->data['title'] = $update['title'];
            $this->data['content'] = $update['content'];
            $this->data['url'] = $update['url'];
            $this->data['created_at'] = $update['created_at'];
            $this->data['updated_at'] = $update['updated_at'];
            $this->data['admin'] = $userModel->isAdmin();

            // Set our view
            $this->view = 'update';
        }
    }
}