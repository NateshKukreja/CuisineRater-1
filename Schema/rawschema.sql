

CREATE TABLE RaterType
(
	type_id INTEGER,
	description TEXT NOT NULL,
	PRIMARY KEY (type_id)
);

CREATE TABLE Rater
(
	user_id SERIAL,
	email VARCHAR(90) NOT NULL UNIQUE,
	name TEXT NOT NULL UNIQUE,
	join_date TIMESTAMP NOT NULL,
	type_id SMALLINT NOT NULL,
	reputation SMALLINT NOT NULL DEFAULT 1,
	password TEXT NOT NULL,
	PRIMARY KEY (user_id),
	FOREIGN KEY (type_id) REFERENCES RaterType(type_id)
		ON UPDATE CASCADE ON DELETE RESTRICT, --What do we want?
	CONSTRAINT rep_bounds CHECK (reputation >= 1 AND reputation <= 5),
	CONSTRAINT valid_email CHECK (email ~* '^[a-z0-9._-]+@[a-z0-9.-]+[.][a-z]+$'),
		--Alphanumeric (with dot, underscore dash), 1 or more
		--then @
		--then alphanumeric (with dot, dash), 1 or more
		--then .
		--then alphabetic domain end (com, ca, etc.)
	CONSTRAINT valid_name CHECK (name ~* '^[a-zàâçéèêëîïôûùüÿñ][a-z0-9àâçéèêëîïôûùüÿñ _-]*$')
		--Alphanumeric (with space, dash, underscore), starts with a letter
);

CREATE TABLE CuisineType
(
	cuisine_id INTEGER,
	description TEXT NOT NULL,
	PRIMARY KEY (cuisine_id)
);

CREATE TABLE Restaurant
(
	restaurant_id SERIAL,
	name TEXT NOT NULL UNIQUE,
	cuisine SMALLINT NOT NULL,
	url TEXT, -- allow restaurant to have no URL
	PRIMARY KEY (restaurant_id),
	FOREIGN KEY (cuisine) REFERENCES CuisineType(cuisine_id)
		ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT valid_name CHECK (name ~* '^[a-z''àâçéèêëîïôûùüÿñ][a-z0-9 ''àâçéèêëîïôûùüÿñ-]*$')
		--Starts with letter, then alphanumeric with spaces
		-- TODO: Add ' to viable names, and french accents?
);

CREATE TABLE Location
(
	location_id SERIAL,
	first_open_date TIMESTAMP NOT NULL,
	manager_name TEXT, 
	phone_number VARCHAR(16),
	street_address TEXT, --not sure about this
	hour_open DECIMAL(4,0), -- 24h format (eg 0630 is 6:30 am)
	hour_close DECIMAL(4,0), -- 24h format (eg 1801 is 6:01 pm)
	restaurant_id INTEGER NOT NULL,
	PRIMARY KEY (location_id),
	FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
		ON UPDATE CASCADE ON DELETE CASCADE, -- no restaurant = no location
	CONSTRAINT valid_phone CHECK (phone_number ~* E'^1?\\d{10}(x\\d{1,4}|)$')
		-- When user inputs phone number in text field, before we put it in the database
		-- we get rid of any spaces, dashes, etc. and just check if it's 10 digits with/without 1 at the start and extension at end
		-- Accepts following formats: 16135550123 / 6135550123 / 6135550123x00 / 16135550123x1234
);

CREATE TABLE Rating
(
	user_id INTEGER NOT NULL DEFAULT 0,
	post_date TIMESTAMP NOT NULL,
	price SMALLINT NOT NULL DEFAULT 0,
	food SMALLINT NOT NULL DEFAULT 0,
	mood SMALLINT NOT NULL DEFAULT 0,
	staff SMALLINT NOT NULL DEFAULT 0,
	comments TEXT NOT NULL,
	location_id INTEGER NOT NULL,
	PRIMARY KEY (user_id, post_date),
	FOREIGN KEY (user_id) REFERENCES Rater(user_id)
		ON UPDATE CASCADE ON DELETE SET DEFAULT,
	FOREIGN KEY (location_id) REFERENCES Location(location_id)
		ON UPDATE CASCADE ON DELETE CASCADE, -- no restaurant, no ratings
	CONSTRAINT price_valid_rating CHECK (price >=0 AND price <= 5),
	CONSTRAINT food_valid_rating CHECK (food >= 0 AND food <= 5),
	CONSTRAINT mood_valid_rating CHECK (mood >= 0 AND mood <= 5),
	CONSTRAINT staff_valid_rating CHECK (staff >= 0 AND staff <= 5),
	CONSTRAINT comments_min_length CHECK (comments ~* '.{50,}')
);

CREATE TABLE ItemType
(
	type_id INTEGER,
	description TEXT NOT NULL,
	PRIMARY KEY (type_id)
);

CREATE TABLE MenuItem
(
	item_id SERIAL,
	name TEXT NOT NULL,
	type_id SMALLINT NOT NULL, -- entree, main meal, beverage, dessert, etc.
	description TEXT, --not sure about this
	price DECIMAL(4,2),
	restaurant_id INTEGER NOT NULL,
	PRIMARY KEY (item_id),
	FOREIGN KEY (restaurant_id) REFERENCES Restaurant(restaurant_id)
		ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (type_id) REFERENCES ItemType(type_id)
);

CREATE TABLE RatingItem
(
	user_id INTEGER NOT NULL,
	post_date TIMESTAMP NOT NULL,
	item_id INTEGER NOT NULL,
	rating SMALLINT NOT NULL,
	comments TEXT,
	PRIMARY KEY (user_id, post_date, item_id),
	FOREIGN KEY (user_id) REFERENCES Rater(user_id)
		ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (item_id) REFERENCES MenuItem(item_id)
		ON UPDATE CASCADE ON DELETE CASCADE, 
	CONSTRAINT valid_rating CHECK (rating >= 1 AND rating <= 5)
);

CREATE TABLE Contact
(
	contact_id SERIAL,
	name TEXT,
	email TEXT,
	comments TEXT,
	PRIMARY KEY(contact_id)
);