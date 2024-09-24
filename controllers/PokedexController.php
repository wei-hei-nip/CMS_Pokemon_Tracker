<?php
class PokedexController extends Controller {
    public function process($params) {
        // Retrieve data of the logged user
        $userModel = new UserModel();
        $user = $userModel->getUser();
        
        //Retrieve data of pokedex
        $pokedexModel = new PokedexModel();

         //actions depending on url parameters

        //Update catching status of pokemon using $pokedexModel->userCatchPokemon()
        if (!empty($params['url'][1]) && $params['url'][1] == 'catch'){ 
            $this->authUser(); //only user can use
            $pokemon = $pokedexModel->getPokemon($user['user_id'], $params['url'][0]); 

            if (!$pokemon) { //if no pokemon was found return to pokedex
                $this->addMessage('Requested pokemon cannot be found');
                $this->redirect('pokedex');
            } else{ //perform the $pokedexModel->userCatchPokemon() and redirect to thr pokemon page
                $this->data['user_id'] = $pokemon['user_id'];

                try { 
                    $catch_pokemon = $pokedexModel->userCatchPokemon($params['url'][0], $user['user_id'], $this->data['user_id']);
                    if ($catch_pokemon[0] === false) {
                        $this->addMessage( $catch_pokemon[1] );
                    } else {
                        $this->addMessage('Action performed successfully');
                    }
                }
                catch (Exception $ex) {
                    $this->addMessage($ex->getMessage());
                }
                $this->redirect('pokedex/'. $pokemon['pokemon_id']);
                }
        }  //remove a pokemon from pokedex using $pokedexModel->removePokemon()
        else if (!empty($params['url'][1]) && $params['url'][1] == 'remove') {
            $this->authUser('admin'); //only admin can perform action
            try {
                $remove_pokemon = $pokedexModel->removePokemon($params['url'][0]);
                if ($remove_pokemon[0] === false) { // if encountered error, print message
                    $this->addMessage( $remove_pokemon[1] );
                } else { 
                    $this->addMessage('The pokemon was successfully removed');
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
            }
            $this->redirect('pokedex');
        } //retreive information of all pokemons from pokedex
        else if (empty($params['url'][0])) {
            // List all pokemons
            $pokemons = $pokedexModel->getPokemons($user['user_id']);
            // HTML head
            $this->head = array('title' => 'My Pokedex', 
                                'description' => 'User Pokedex with brief information of pokemons');

            
            // Set template variables
            $this->data['pokemons'] = $pokemons;
            $this->data['admin'] = $userModel->isAdmin();
            $this->data['pokeball_icon'] = 'red';
            $this->data['my_pokedex'] = 1; //to distinct from "UserCommuniyController" as My Pokedex

            // Set view
            $this->view = 'pokedex';
        } else {
            // Retrieve pokemon by the URL
            $pokemon = $pokedexModel->getPokemon($user['user_id'], $params['url'][0]);
          
            // If no pokemon was found display an error
            if (!$pokemon) {
                $this->addMessage('Requested pokemon cannot be found');
                $this->redirect('pokedex');
            }
            // HTML head
            $this->head = array(
                'title' => $pokemon['name'],
                'description' => 'Information of pokemon '. $pokemon['name'],
            );
            

            // Set template variables
            $this->data['pokemon_id'] = $pokemon['pokemon_id'];
            $this->data['name'] = $pokemon['name'];
            $this->data['content'] = $pokemon['content'];
            $this->data['type1'] = $pokemon['type1'];
            $this->data['type2'] = $pokemon['type2'];
            $this->data['total'] = $pokemon['total'];
            $this->data['hp'] = $pokemon['hp'];
            $this->data['attack'] = $pokemon['attack'];
            $this->data['defense'] = $pokemon['defense'];
            $this->data['sp_attack'] = $pokemon['sp_attack'];
            $this->data['sp_defense'] = $pokemon['sp_defense'];
            $this->data['speed'] = $pokemon['speed'];
            $this->data['img_url'] = $pokemon['img_url'];
            $this->data['sprit_url'] = $pokemon['sprit_url'];
            $this->data['user_id'] = $pokemon['user_id'];
            $this->data['user'] = $user['user_id'];
            $this->data['admin'] = $userModel->isAdmin();

            // Set our view
            $this->view = 'pokemon';
        }
    }
}