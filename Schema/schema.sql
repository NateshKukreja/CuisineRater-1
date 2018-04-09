CREATE TABLE RaterCredibility (

    type INTEGER,
    description TEXT NOT NULL,
    PRIMARY KEY (type)

);


CREATE TABLE Rater (

    UserID INTEGER,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL UNIQUE,
    signup_day TIMESTAMP NOT NULL,
    type INTEGER NOT NULL,
    reputation INTEGER NOT NULL,
    password VARCHAR(255) not null,
    PRIMARY KEY (UserID),
    FOREIGN KEY (type) REFERENCES RaterCredibility(type)
);


CREATE TABLE Rating (

    UserID INTEGER,
    varDate TIMESTAMP,
    Price INTEGER,
    Food INTEGER,
    Mood INTEGER,
    Staff INTEGER,
    Comments VARCHAR(255),
    RestaurantID INTEGER,
    PRIMARY KEY (UserID, varDate)

);

CREATE TABLE Cuisine
(

    typeID INTEGER NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (typeID)

);

CREATE TABLE Restaurant (

    RestaurantID INTEGER,
    Name VARCHAR(255) NOT NULL UNIQUE,
    varType INTEGER,
    Rating DECIMAL(1, 2),
    URL VARCHAR(255),
    PRIMARY KEY (RestaurantID),
    FOREIGN KEY (varType) REFERENCES Cuisine(typeID)

);


CREATE TABLE Location (

    LocationID INTEGER,
    first_open TIMESTAMP NOT NULL,
    manager_name VARCHAR(255),
    phone_number VARCHAR(20) NOT NULL,
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
    varDate TIMESTAMP NOT NULL,
    ItemID INTEGER NOT NULL,
    rating INTEGER,
    comments TEXT,
    PRIMARY KEY (UserID, varDate, ItemID),
    FOREIGN KEY (UserID) REFERENCES Rater(UserID),
    FOREIGN KEY (ItemID) REFERENCES MenuItem(ItemID),
    CONSTRAINT rating CHECK (rating >=0 AND rating <=5)

);

