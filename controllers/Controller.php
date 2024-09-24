<?php

/**
 * A common controller for our CMS
 * Class Controller
 */

abstract class Controller {
    /**
     * @var array An array which indexes will be accessible as variables in template
     */
    protected $data = array();
    /**
     * @var string A template name without the extension
     */
    protected $view = '';
    /**
     * @var array The HTML head
     */
    protected $head = array('title' => '', 'description' => '');

    /**
     * Renders the view
     */
    public function renderView() {
        if ($this->view) {
            extract($this->data);

            // Instruct browsers not to cache any content to avoid session issues
            header('Expires: Sun, 01 Jan 2022 00:00:00 GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Pragma: no-cache');

            require_once('views/' . $this->view . '.php');
        }
    }

    /**
     * @param string $url Redirects to a given URL
     */
    public function redirect($url) {
        header('Location: ' . BASE_PATH . '/' . $url);
        header('Connection: close');
        die();
    }

    /**
     * Adds a flash message for the user
     * @param string $message The text of the message
     */
    public function addMessage($message) {
        if (isset($_SESSION['messages'])) {
            $_SESSION['messages'][] = $message;
        }
        else {
            $_SESSION['messages'] = array($message);
        }
    }

    /**
     * Gets all user flash messages
     * @return array All the user flash messages
     */
    public function getMessages() {
        if (isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        }
        else {
            return array();
        }
    }

    /**
     * Checks whether the user is logged in and whether a particular user group is required to allow access.
     * Otherwise, redirect to the login page.
     * We have set admins to be able to access all areas, even those restricted to specific user groups other than 'admin'
     * @param bool $admin Whether we need the user to be an administrator
     */
    public function authUser($group = false) {
        $userModel = new UserModel();
        $user = $userModel->getUser();

        if (!$user || (!$userModel->isAdmin() && $group && $user['user_group'] !== $group)) {
            $this->addMessage('You are not authorised for this action.');
            $this->redirect('login');
        }
    }

    /**
    * The main controller method
    * @param array $params parameters
    */
    abstract function process($params);

    /** Set time zone for datetime */
}