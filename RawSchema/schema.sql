
CREATE TABLE Rater (

    UserID INTEGER,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL UNIQUE,
    signup_day DATE NOT NULL,
    type INTEGER NOT NULL,
    reputation DECIMAL(1,2) NOT NULL,
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


CREATE TABLE Cuisine
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
    rating VARCHAR(255),
    comments TEXT,
    PRIMARY KEY (UserID, varDate, ItemID),
    FOREIGN KEY (UserID) REFERENCES Rater(UserID),
    FOREIGN KEY (ItemID) REFERENCES MenuItem(varType),
    CONSTRAINT rating CHECK (rating >=0 AND rating <=5)

);


#a) Display all the information about a user‐specified restaurant. That is, the user should select the name of the restaurant from a list, and the information as contained in the restaurant and location tables should then displayed on the screen.

SELECT * FROM Restaurant R, Location L WHERE
L.LocationID = "__" AND L.RestaurantID = R.RestaurantID;

#b) Display the full menu of a specific restaurant. That is, the user should select the name of the restaurant from a list, and all menu items, together with their prices, should be displayed on the screen. The menu should be displayed based on menu item categories.

SELECT * FROM Restaurant R, MenuItem MI WHERE
R.RestaurantID = "__" AND R.RestaurantID = MI.RestaurantID;
list the manager names together with the date that the locations have opened. The user should be able to select the category (e.g. Italian or Thai) from a list.



#d)

#e)

#f)
'Find the total number of rating for each restaurant, for each rater. That is, the data should be
grouped by the restaurant, the specific raters and the numeric ratings they have received.'

SELECT Rater.name, Restaurant.name, COUNT(Rating.post_date), AVG((Rating.food+Rating.price+Rating.mood+Rating.staff)/4.0)
	FROM Restaurant
	INNER JOIN Location
		ON Restaurant.RestaurantID=Location.RestaurantID
	INNER JOIN Rating
		ON Location.LocationID=Rating.LocationID
	INNER JOIN Rater
		ON Rating.UserID=Rater.UserID
	GROUP BY Restaurant.name, Rater.name
	ORDER BY Rater.name, Restaurant.name;

#g)'Display the details of the restaurants that have not been rated in January 2015. That is, you
should display the name of the restaurant together with the phone number and the type of
food.'
SELECT Restaurant.name, Restaurant.url, Cuisine.description, Location.phone_number, Location.phone_number, Location.street_address, Location.hour_open, Location.hour_close
	FROM Restaurant
	INNER JOIN Location
		ON Restaurant.RestaurantID=Location.RestaurantID
  INNER JOIN Cuisine
  	ON Restaurant.varType=Cuisine.typeID
	WHERE Location.LocationID NOT IN
		(SELECT location2.LocationID
			FROM Location location2
			INNER JOIN Rating rating2
				ON location2.LocationID=rating2.LocationID
			WHERE EXTRACT(month from rating2.varDate) = 1 -- Replace '1' with month from 1-12
				AND EXTRACT(year from rating2.varDate) = 2015 ) -- Replace '2015' with year

#h)
'Find the names and opening dates of the restaurants that obtained Staff rating that is lower
than any rating given by rater X. Order your results by the dates of the ratings. (Here, X refers to
any rater of your choice.)'
SELECT Restaurant.name, Location.first_open_date, Rating.varDate
	FROM Restaurant
	INNER JOIN Location
		ON Restaurant.RestaurantID=Location.RestaurantID
	INNER JOIN Rating
		ON Location.LocationID=Rating.LocationID
	WHERE Rating.staff < ALL
		(SELECT Rating2.staff
			FROM Rating AS Rating2
			INNER JOIN Rater AS Rater2
				ON Rater2.UserID=Rater2.UserID
			WHERE Rater2.UserID= 1 ) -- Replace '1' with specified id
ORDER BY Rater.varDate DESC;

#i)
'List the details of the Type Y restaurants that obtained the highest Food rating. Display the
restaurant name together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y
refers to any restaurant type of your choice, e.g. Indian or Burger.)'

SELECT Cuisine.description, Restaurant.name, Rater.name, temp.avgRate
	FROM Restaurant
	INNER JOIN Cuisine
		ON Restaurant.varType=ct.typeID
	INNER JOIN Location
		ON Restaurant.RestaurantID=Location.RestaurantID
	INNER JOIN Rating
		ON loc.RestaurantID=Rating.RestaurantID
	INNER JOIN Rater
		ON Rater.UserID=Rater.UserID
	INNER JOIN
		(SELECT loction2.LocationID locationid2, AVG(rate2.food) avgRate
			FROM Rating rating2
			INNER JOIN Location loction2
				ON rating2.location_id=location2.LocationID
			GROUP BY locationid2) temp
		ON Location.LocationID=locationid2
	WHERE temp.avgRate >= ALL
		(SELECT AVG(rating2.food) avgRate
			FROM Rating rating2
			INNER JOIN Location loction2
				ON rating2.LocationID=loc2.LocationID
			INNER JOIN Restaurant restaurant2
				ON restaurant2.RestaurantID=location2.RestaurantID
			INNER JOIN Cuisine cuisine2
				ON restaurant2.varType=cuisine2.typeID
			WHERE cuisine2.varType=Cuisine.typeID
			GROUP BY location2.LocationID)
	ORDER BY Cuisine.description

#j)

#k)'Find the names, join‐date and reputations of the raters that give the highest overall rating, in
terms of the Food and the Mood of restaurants. Display this information together with the
names of the restaurant and the dates the ratings were done.'
SELECT Rater.name, Rater.signup_day, COUNT(Rating.user_id), AVG(temp.innerAvg) as avgRate
	FROM Rater
	INNER JOIN Rating
		ON Rater.UserID=Rating.UserID
	INNER JOIN
		(SELECT rating2.user_id r2_uid, rating2.post_date r2_pd, (rating2.food+rating2.mood)/2.0 innerAvg
			FROM Rating rating2) temp
		ON Rating.user_id=temp.r2_uid AND Rating.varDate=temp.r2_pd
	GROUP BY Rater.name, Rater.signup_day
	ORDER BY avgRate DESC;
