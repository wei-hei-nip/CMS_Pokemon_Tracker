<?php


/**
 * A controller for logging users in
 * Class LoginController
 */
class LoginController extends Controller {
    /**
     * Handles logging users in
     * @param array $params The URL params
     */
    public function process($params) {
        $userModel = new UserModel();
        // if a user requests this page but is already logged on, do not display the login page and redirect to admin
        if ($userModel->getUser()) {
            $this->redirect('admin');
        }
        // if login form is submitted
        if ($_POST) {
            try {
                $userModel->login($_POST['name'], $_POST['password']);
                $this->addMessage('You were successfully logged in.');
                $this->redirect('admin');
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
        }
        // HTML head
        $this->head['title'] = 'Login';
        $this->head['description'] = 'Login';
        // Sets the template
        $this->view = 'login';
    }
}