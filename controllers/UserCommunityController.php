<?php

/**
 * A controller for the User Community page
 * Class UserCommunityController
 */

class UserCommunityController extends Controller {
    public function process($params) {
        $this->authUser(); //only members and admins can use

        // Retrieve data of all users
        $userModel = new UserModel();
        $users = $userModel->getUsers($visibility = "public");
        $this->data['users'] = $users;
       
        // Retrieve data of pokemons
        $pokedexModel = new PokedexModel();

        //Check if parameters indicate user profile
        if (!empty($params['url'][1]) && $params['url'][1] == 'profile') {
            $user = $userModel->getUser($params['url'][0]);
            
            // List the pokemons of the url user_id
            $pokemons = $pokedexModel->getPokemons($params['url'][0]);

            
            // HTML head
            $this->head = array('title' => $user['name']. "'s Pokedex",
                                'description' => "Pokemon catching status of ". $user['name']. "'s Pokedex");

            
            // Set template variables
            $this->data['pokemons'] = $pokemons;
            $this->data['pokeball_icon'] = 'blue'; //set pokeball icon paths for other user's icon

            // Set our view
            $this->view = 'pokedex';
        } else{
            // HTML head
            $this->head['title'] = 'User Community';
            $this->head['description'] = 'Information of public users and accessto profiles';

        
            // Set the template
            $this->view = 'user-community';
        }
    }
}

?>