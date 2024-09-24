CREATE TABLE IF NOT EXISTS users_pokemon (
    user_id INT,
    pokemon_id INT,
    PRIMARY KEY (user_id, pokemon_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
	FOREIGN KEY (pokemon_id) REFERENCES pokedex(pokemon_id) ON DELETE CASCADE
    );