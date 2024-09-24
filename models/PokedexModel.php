<?php

/**
 * Manages pokemons related information
 * Class pokedexModel
 */


class PokedexModel {
    /**
     * Returns a list of all pokemons in the database
     * @return array All the pokemons in the database
     * 
     * left joining allows the pokedex and users_pokemon database provide the information of which pokemon has been caught by the user
     */
    public function getPokemons($user_id) {
        return Db::queryAll('
            SELECT p.pokemon_id, p.name, p.sprit_url, up.user_id
            FROM pokedex p
            LEFT JOIN (
            SELECT pokemon_id, user_id
            FROM users_pokemon
            WHERE user_id = ?
            ) up ON p.pokemon_id = up.pokemon_id
            ORDER BY pokemon_id ASC
        ', array($user_id));
    }

    /**
     * Returns a pokemon from the database by a URL,
     * The URL represent the pokemon_id,
     * @param string $url The URL
     * 
     * left joining allows the pokedex and users_pokemon database provide the information of which pokemon has been caught by the user
     */
    public function getPokemon($user_id, $url) {
        return Db::queryOne('
			SELECT p.pokemon_id, p.name, p.content, p.type1, p.type2, p.total, p.hp, p.attack, p.defense, p.sp_attack, p.sp_defense, p.speed, p.img_url, p.sprit_url, up.user_id
			FROM pokedex p
            LEFT JOIN (
            SELECT pokemon_id, user_id
            FROM users_pokemon
            WHERE user_id = ?
            ) up ON p.pokemon_id = up.pokemon_id
            WHERE p.pokemon_id = ?
            ORDER BY pokemon_id ASC
		', array($user_id, $url));
    }

    /**
     * Saves a pokemon into the database, pokedex.
     * @param int $url is used to check if a pokemon previously exist for editing,
     * @param int $pokemon_id will be used to update the database,
     * @param array $pokemon consist of the array of values
     * If the $url is false, it inserts a new row, otherwise, it updates the existing row base on the pokemon_id.
     */
    public function savePokemon($url, $pokemon_id, $pokemon) {
        if (!$pokemon_id){
            return array(false, 'Pokemon ID cannot be empty.');
        }
        
        if (!$url) {
            try {
                Db::insert('pokedex', $pokemon);
            }
            catch (PDOException $ex) {
                return array(false, 'Pokemon could not be saved.');
            }
        }
        else {
            try {
                Db::update('pokedex', $pokemon, 'WHERE pokemon_id = ?', array($pokemon_id));
            }
            catch (PDOException $ex) {
                return array(false, 'Pokemon could not be updated');
            }
        }
        return array(true);
    }

    /**
     * Removes a pokemon from database, pokedex.
     * @param int $url The  pokemon_id of the pokemon to be removed
     * @return array|bool[] containing messages of error.
     */
    public function removePokemon($url) {
        try {
            $query = Db::query('
                        DELETE FROM pokedex
                        WHERE pokemon_id = ?
                    ', array($url));
        }
        catch (PDOException $ex) {
            return array(false, 'Pokemon could not be removed');
        }
        // if no rows were affected then let the controller know that the pokemon could not be found
        if ($query === null || $query === 0 ) {
            return array(false, 'This pokemon does not exist and cannot be removed.');
        }
        return array(true);
    }

    /**
     * Updates the catching status of each pokemon in database pokedex base on user
     * There are two catching status caught or uncaught, which will be checked for each update,
     * if already caught, if will update to uncaught, vice versa.
     * It updates the users_pokemon database, which store the information of poekmon caught by users.
     * 
     * @param int $url as the pokemon_id of the pokemon to be updated
     * @param int $user_id as the user_id of the user to update.
     * @param $status anticipated the user_id data from the left join in getPokemon(), a present user_id is equivalent to a boolean true
     * 
     * @return array|bool[] containing messages of error.
     */
    public function userCatchPokemon($url, $user_id, $status){
            if (!$status){ //if the pokemon has not been caught by user
                try {
                    $query = Db::query('
                                INSERT INTO users_pokemon (pokemon_id, user_id) VALUES (?, ?)
                            ', array($url, $user_id));
                }
                catch (PDOException $ex) {
                    return array(false, 'Pokemon catch is not recorded.');
                }
                return array(true);
            } else{ //if the pokemon has been caught by user
                try {
                    $query = Db::query('
                                DELETE FROM users_pokemon
                                WHERE pokemon_id = ? AND user_id = ?
                            ', array($url, $user_id));
                }
                catch (PDOException $ex) {
                    return array(false, 'Pokemon could not be uncaught');
                }
                // if no rows were affected then let the controller know that the pokemon could not be found
                if ($query === null || $query === 0 ) {
                    return array(false, 'This pokemon does not exist and cannot be uncaught.');
                }
                return array(true);
            }
        
            
        }
}