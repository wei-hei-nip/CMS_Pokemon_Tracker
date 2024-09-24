<?php


/**
 * A controller for the pokedex editor
 * Class PokedexEditorController
 */
class PokedexEditorController extends Controller {
    /**
     * Handles update-editor requests
     * @param array $params URL parameters
     */
    public function process($params) {
        // Only admins can use the editor
        $this->authUser('admin');
        // Creates a model instance
        $pokedexModel = new PokedexModel();
       
        // If the editor form is submitted
        if ($_POST) {
           
            // Retrieves the update from POST
            $keys = array('pokemon_id', 'name', 'content', 'type1', 'type2', 'total', 'hp', 'attack', 'defense', 'sp_attack', 'sp_defense', 'speed', 'img_url', 'sprit_url');
            $pokemon = array_intersect_key($_POST, array_flip($keys));

           

            // Stores the pokemon into the database
            try {
                $save_pokemon = $pokedexModel->savePokemon($params['url'][0], $_POST['pokemon_id'], $pokemon);
                if ($save_pokemon[0] === false) {
                    $this->addMessage( $save_pokemon[1]);
                    $this->redirect('pokedex');
                } else {
                    $this->addMessage('The pokemon was successfully saved.');
                    $this->redirect('pokedex/'. $pokemon['pokemon_id']);
                }
            }
            catch (Exception $ex) {
                $this->addMessage($ex->getMessage());
                $this->redirect('pokedex');
            }
        }
        // Is a pokemon_id entered for editing?
        else if (!empty($params['url'][0])) {
            $loadedPokemon = $pokedexModel->getPokemon($user['user_id'], $params['url'][0]);
            if ($loadedPokemon) {
                $pokemon = $loadedPokemon;
            }
            else {
                $this->addMessage('Requested pokemon was not found.');
                $this->redirect('pokedex');
            }
        }
        // HTML head
        $this->head['title'] = 'Pokedex Editor';
        $this->head['description'] = 'Editor to add or edit pokemon to the pokedex';

        //store pokemon data
        $this->data['pokemon'] = $pokemon;

        //set view
        $this->view = 'pokedex-editor';
    }
}