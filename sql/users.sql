CREATE TABLE IF NOT EXISTS users (
    user_id SERIAL,
    name varchar(255) NOT NULL UNIQUE,
    password varchar(255) DEFAULT NULL,
    user_group varchar(32) DEFAULT 'member',
	visibility BOOLEAN DEFAULT false,
    PRIMARY KEY (user_id)
    );
