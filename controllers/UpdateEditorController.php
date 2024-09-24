<?php

/**
 * A controller for the update editor
 * Class EditorController
 */
class UpdateEditorController extends Controller {
    /**
     * Handles update-editor requests
     * @param array $params URL parameters
     */
    public function process($params) {
        // Only admins can use the editor
        $this->authUser('admin');
        // Creates a model instance
        $updateModel = new UpdateModel();

        // If the editor form is submitted
        if ($_POST) {
            //Ensure the url has no space in between
            $_POST['url']=str_replace(' ', '-', $_POST['url']);
            // Retrieves the update announcement from POST
            $keys = array('version_number', 'title', 'content', 'url', 'created_at', 'updated_at');
            $update = array_intersect_key($_POST, array_flip($keys));
            // Stores the update announcement into the database
            try {
                
                $save_update = $updateModel->saveUpdate($_POST['update_id'], $update);
                if ($save_update[0] === false) {
                    $this->addMessage( $save_update[1] );
                    
                    $this->redirect('update');
                } else {
                    $this->addMessage('The update was successfully saved.');
                    $this->redirect('update/' . $update['url']);
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
                $this->redirect('update');
            }
        }
        // Is an update announcement URL entered for editing?
        else if (!empty($params['url'][0])) {
            $loadedUpdate = $updateModel->getUpdate($params['url'][0]);
            if ($loadedUpdate) {
                $update = $loadedUpdate;
            }
            else {
                $this->addMessage('The update was not found.');
            }
        }
        // HTML head
        $this->head['title'] = 'Update Editor';
        $this->head['description'] = 'Editor for add and editing update announcement';

        //store the data
        $this->data['update'] = $update;

        //set view
        $this->view = 'update-editor';
    }
}