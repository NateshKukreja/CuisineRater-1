
CREATE TABLE Rater (

    UserID INTEGER,
    email VARCHAR(255) NOT NULL UNIQUE, 
    name VARCHAR(255) NOT NULL UNIQUE,
    signup_day DATE NOT NULL, 
    type INTEGER NOT NULL, 
    reputation INTEGER NOT NULL,
    PRIMARY KEY (UserID),
    CONSTRAINT reputation_bound CHECK (reputation >=0 AND reputation <=5),
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
    Price DECIMAL(4,2),
    Food VARCHAR(255),
    Mood VARCHAR(255),
    Staff VARCHAR(255),
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



#d)

#e)

#f)

#g)

#h)

#i)

#j)

