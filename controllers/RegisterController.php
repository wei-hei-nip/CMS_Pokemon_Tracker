<?php


/**
 * A controller for registering new users
 * Class RegisterController
 */
class RegisterController extends Controller {
    /**
     * Handles user registration requests
     * @param array $params
     */
    public function process($params) {
        $userModel = new UserModel();
        // if a user requests this page but is already logged on, do not display the registration page and redirect to articles
        if ($userModel->getUser()) {
            $this->redirect('article');
        }
        // if registration form is submitted
        if ($_POST) {
            try {
                $register = $userModel->register($_POST['name'], $_POST['password'], $_POST['password_repeat'], $_POST['antispam'], $_POST['visibility']);
                if ($register[0] === false) {
                    $this->addMessage( $register[1] );
                    $this->redirect('register');
                } else {
                    $userModel->login($_POST['name'], $_POST['password']);
                    $this->addMessage('You were successfully registered.');
                }
                $this->redirect('admin');
            }
            catch (Exception $ex)  {
                $this->addMessage($ex->getMessage());
            }
        }
        // HTML head
        $this->head['title'] = 'Register';
        $this->head['description'] = 'User registration';

        // Sets the template
        $this->view = 'register';
    }
}