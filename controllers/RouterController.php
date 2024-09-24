<?php

/*
 * Router is a special kind of controller which calls appropriate
 * controller according to the user's URL address. The router renders the view
 * of this particular controller into the layout template
 * Class RouterController
 */
class RouterController extends Controller {
    /**
     * @var $subcontroller The sub controller instance
     */
    protected $subcontroller;

    /**
     * Parses the URL address using slashes and returns params as array
     * @param string $url The URL address to be parsed
     * @return array The URL parameters
     */
    private function parseUrl($url) {
        // Remove the base path from the URL address
        $parsed_url = str_replace(BASE_PATH, '',$url);
        // Parses URL parts into an associative array
        $parsed_url = parse_url($parsed_url);
        // Removes the leading slash
        $parsed_url['path'] = ltrim($parsed_url['path'], '/');
        // Removes white-spaces around the address
        $parsed_url['path'] = trim($parsed_url['path']);
        // Splits the address by slashes
        $exploded_url = explode('/', $parsed_url['path']);
        return $exploded_url;
    }

    /**
     * Converts dashed controller name from URL into a CamelCase class name
     * @param string $text The controller name using dashes like article-list
     * @return string The class name of the controller like ArticleList
     */
    private function dashesToCamel($text) {
        $text = str_replace('-', ' ', $text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return $text;
    }

    /**
     * Parses the URL address and creates appropriate controller
     * @param array $params The URL address as an array of a single element
     */
    public function process($params) {
        $parsed_url = $this->parseUrl($params['url']);
        if (empty($parsed_url[0])) {
            $this->redirect('home');
        }
        // The controller name is the first URL parameter
        $controller_class = $this->dashesToCamel(array_shift($parsed_url)) . 'Controller';

        // Make sure that the controller file exists and dynamically instantiate the object
        if (file_exists(getcwd() . '/controllers/' . $controller_class . '.php')) {
            $this->subcontroller = new $controller_class;
        }
        else {
            die('Request page not found');
        }

        // Check whether the user is logged on and if so make the name of the user available to our layout view
        $userModel = new UserModel();
        $user = $userModel->getUser();
        if ($user !== null && isset($user['name'])) {
            $this->data['name'] = $user['name'];
        }

        // Calls the subcontroller and passes the uri for further processing of the request
        $this->subcontroller->process(array('url' => $parsed_url));
        // Sets template variables
        $this->data['title'] = $this->subcontroller->head['title'];
        $this->data['description'] = $this->subcontroller->head['description'];
        $this->data['messages'] = $this->getMessages();
        $this->data['group'] = $user['user_group'];
        $this->data['admin'] = $userModel->isAdmin();
        // Sets the main template
        $this->view = 'layout';
    }
}