
CREATE TABLE Rater (

    UserID INTEGER,
    email VARCHAR(255) NOT NULL UNIQUE, 
    name VARCHAR(255) NOT NULL UNIQUE,
    signup_day DATE NOT NULL, 
    type INTEGER NOT NULL, 
    passwrd TEXT NOT NULL,
    PRIMARY KEY (UserID),
    FOREIGN KEY (type) REFERENCES RaterCredibility(type)
);

CREATE TABLE RaterCredibility (

    type INTEGER,
    description TEXT NOT NULL,
    PRIMARY KEY (type)

);


CREATE TABLE Rating (

    UserID INTEGER,
    varDate DATE,
    Food VARCHAR(255),
    Comments VARCHAR(255),
    RestaurantID INTEGER,
    PRIMARY KEY (UserID, varDate)

);

CREATE TABLE Restaurant (

    RestaurantID INTEGER,
    Name VARCHAR(255) NOT NULL UNIQUE, 
    varType INTEGER,
    URL VARCHAR(255),
    PRIMARY KEY (RestaurantID),
    FOREIGN KEY (varType) REFERENCES Cuisine(typeID)
    
);


CREATE TABLE CUISINE 
(

    typeID INTEGER NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (typeID)

);


CREATE TABLE Location (

    LocationID INTEGER,
    first_open DATE NOT NULL,
    manager_name VARCHAR(255),
    phone_number VARCHAR(12) NOT NULL,
    street_address VARCHAR(255),
    hour_open INTEGER,
    hour_close INTEGER,
    RestaurantID INTEGER NOT NULL,
    PRIMARY KEY (LocationID),
    FOREIGN KEY(RestaurantID) REFERENCES Restaurant(RestaurantID)

);

CREATE TABLE MenuItem
(

    ItemID INTEGER, 
    name VARCHAR(255) NOT NULL,
    varType INTEGER NOT NULL,
    category VARCHAR(255),
    description VARCHAR(255),
    price DECIMAL(5,2),
    RestaurantID INTEGER NOT NULL,
    PRIMARY KEY (ItemID),
    FOREIGN KEY (RestaurantID) REFERENCES Restaurant(RestaurantID)
    
);



CREATE TABLE RatingItem 
(

    UserID INTEGER NOT NULL,
    varDate DATE NOT NULL,
    ItemID INTEGER NOT NULL,
    rating INTEGER,
    comments TEXT,
    PRIMARY KEY (UserID, varDate, ItemID),
    FOREIGN KEY (UserID) REFERENCES Rater(UserID),
    FOREIGN KEY (ItemID) REFERENCES MenuItem(varType),
    CONSTRAINT rating CHECK (rating >=0 AND rating <=5)

);


#a) Display all the information about a user‐specified restaurant. That is, the user should select the name of the restaurant from a list, and the information as contained in the restaurant and location tables should then displayed on the screen.

SELECT * FROM Restaurant R, Location L WHERE
L.LocationID = "__" AND L.RestaurantID = R.RestaurantID

#b) Display the full menu of a specific restaurant. That is, the user should select the name of the restaurant from a list, and all menu items, together with their prices, should be displayed on the screen. The menu should be displayed based on menu item categories.

SELECT * FROM Restaurant R, MenuItem MI WHERE
R.RestaurantID = "__" AND R.RestaurantID = MI.RestaurantID

#c) For each user‐specified category of restaurant, list the manager names together with the date that the locations have opened. The user should be able to select the category (e.g. Italian or Thai) from a list.

SELECT L.LocationID, R.Name, L.street_address, L.manager_name, L.first_open
	FROM Restaurant AS R
    INNER JOIN Cuisine AS C
		ON R.varType=C.typeID
	INNER JOIN Location AS L
		ON R.restaurant_id=L.restaurant_id
	ORDER BY L.first_open DESC, R.Name;

#d) Given a user‐specified restaurant, find the name of the most expensive menu item. List this information together with the name of manager, the opening hours, and the URL of the restaurant. The user should be able to select the restaurant name (e.g. El Camino) from a list.

Select M.name, MI.price, L.manager_name, H.weekdayOpen, H.weekendOpen, R.url FROM 
		final_project.Restaurant R, final_project.Location L, final_project.Hours H, final_project.MenuItem MI WHERE
		MI.price >= all(Select MI1.price FROM final_project.MenuItem MI1 WHERE
				MI1.restaurantId = R.restaurantId) AND
			R.restaurantId = L.restaurantId AND L.hoursId = H.hoursId AND
			MI.restaurantId = R.restaurantId AND R.name ='Make You Fat';

#e) For each type of restaurant (e.g. Indian or Irish) and the category of menu item (appetiser, main or desert), list the average prices of menu items for each category.

#f)

#g)

#h)

#i)

#j)

