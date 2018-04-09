--#a) 'Display all the information about a user‐specified restaurant. That is, the user should select the name of the

SELECT * FROM Restaurant R, Location L WHERE
L.LocationID = "__" AND L.RestaurantID = R.RestaurantID;

--#b) 'Display the full menu of a specific restaurant. That is, the user should select the name of the restaurant from a list,
--and all menu items, together with their prices, should be displayed on the screen. The menu should be displayed based on menu item categories.'

SELECT * FROM Restaurant R, MenuItem MI WHERE
R.RestaurantID = "__" AND R.RestaurantID = MI.RestaurantID;

-- #c) 'For each user‐specified category of restaurant, list the manager names together with the date
--that the locations have opened. The user should be able to select the category (e.g. Italian or
--Thai) from a list'

Select L.manager_name, L.first_open FROM Location L WHERE
	L.restaurantId = (Select R.restaurantId FROM Restaurant R WHERE
		R.varType = 1);

--#d) 'Given a user‐specified restaurant, find the name of the most expensive menu item. List this information together
--with the name of manager, the opening hours, and the URL of the restaurant.
--The user should be able to select the restaurant name (e.g. El Camino) from a list.'

Select M.name, MI.price, L.manager_name, H.weekdayOpen, H.weekendOpen, R.url FROM
        final_project.Restaurant R, final_project.Location L, final_project.Hours H, final_project.MenuItem MI WHERE
        MI.price >= all(Select MI1.price FROM final_project.MenuItem MI1 WHERE
                MI1.restaurantId = R.restaurantId) AND
            R.restaurantId = L.restaurantId AND L.hoursId = H.hoursId AND
            MI.restaurantId = R.restaurantId AND R.name ='Pure Kitchen';


--#e)'For each type of restaurant (e.g. Indian or Irish) and the category of menu item (appetiser, main
--or desert), list the average prices of menu items for each category.'
SELECT Restaurant.varType, MenuItem.varType, AVG(MenuItem.price)
	FROM Restaurant
	INNER JOIN MenuItem
		ON MenuItem.RestaurantID=MenuItem.RestaurantID
	WHERE Restaurant.varType= 1 --Replace '1' with user-specified cuisine type
	GROUP BY Restaurant.varType, MenuItem.varType
	ORDER BY Restaurant.varType, MenuItem.varType;

--#f)
--'Find the total number of rating for each restaurant, for each rater. That is, the data should be
--grouped by the restaurant, the specific raters and the numeric ratings they have received.'

SELECT Rater.name, Restaurant.name, COUNT(Rating.varDate), AVG((Rating.food+Rating.price+Rating.mood+Rating.staff)/4.0)
    FROM Restaurant
    INNER JOIN Location
        ON Restaurant.RestaurantID=Location.RestaurantID
    INNER JOIN Rating
        ON Location.LocationID=Rating.RestaurantID
    INNER JOIN Rater
        ON Rating.UserID=Rater.UserID
    GROUP BY Restaurant.name, Rater.name
    ORDER BY Rater.name, Restaurant.name;

--#g)'Display the details of the restaurants that have not been rated in January 2015.
--That is, you should display the name of the restaurant together with the phone number and the type of food.'
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
                ON location2.LocationID=rating2.RestaurantID
            WHERE EXTRACT(month from rating2.varDate) = 1
                AND EXTRACT(year from rating2.varDate) = 2015 )
--#h)
--'Find the names and opening dates of the restaurants that obtained Staff rating that is lower
--than any rating given by rater X. Order your results by the dates of the ratings. (Here, X refers to
--any rater of your choice.)'
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
--#i)
--'List the details of the Type Y restaurants that obtained the highest Food rating. Display the
--restaurant name together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y
--refers to any restaurant type of your choice, e.g. Indian or Burger.)'
SELECT Cuisine.description, Restaurant.name, Rater.name, temp.avgRate
    FROM Restaurant
    INNER JOIN Cuisine
        ON Restaurant.varType=Cuisine.typeID
    INNER JOIN Location
        ON Restaurant.RestaurantID=Location.RestaurantID
    INNER JOIN Rating
        ON Location.RestaurantID=Rating.RestaurantID
    INNER JOIN Rater
        ON Rater.UserID=Rater.UserID
    INNER JOIN
        (SELECT location2.LocationID locationid2, AVG(rating2.food) avgRate
            FROM Rating rating2
            INNER JOIN Location location2
                ON rating2.RestaurantID =location2.LocationID
            GROUP BY locationid2) temp
        ON Location.LocationID=locationid2
    WHERE temp.avgRate >= ALL
        (SELECT AVG(rating2.food) avgRate
            FROM Rating rating2
            INNER JOIN Location location2
                ON rating2.RestaurantID=location2.LocationID
            INNER JOIN Restaurant restaurant2
                ON restaurant2.RestaurantID=location2.RestaurantID
            INNER JOIN Cuisine cuisine2
                ON restaurant2.varType=cuisine2.typeID
            WHERE cuisine2.typeID=Cuisine.typeID
            GROUP BY location2.LocationID)
    ORDER BY Cuisine.description
--#j)
--'Provide a query to determine whether Type Y restaurants are “more popular” than other
--restaurants.  (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.)
--Yes, this query is open to your own interpretation!'
SELECT R.Name FROM Restaurant R WHERE R.varType = 1
ORDER BY(R.rating) LIMIT 5

--#k)'Find the names, join‐date and reputations of the raters that give the highest overall rating, in terms of the
--Food and the Mood of restaurants. Display this information together with the names of the restaurant and the dates the ratings were done.'
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

--#l)'Find the names and reputations of the raters that give the highest overall rating, in terms of the
--Food or the Mood of restaurants. Display this information together with the names of the
--restaurant and the dates the ratings were done.'
SELECT rater_.name, rater_.signup_day, rater_.reputation, R.name, rating_.vardate FROM Rater rater_, Restaurant R, Rating rating_ WHERE
	rater_.userId IN (SELECT rater_1.userId FROM Rater rater_1 WHERE
		(SELECT AVG(mood) FROM Rating rating_2 WHERE rating_2.userId = rater_1.userId)
			>= ALL(SELECT AVG(mood) FROM Rating rating_3 GROUP BY rating_3.userId)
		OR (SELECT AVG(food) FROM Rating rating_4 WHERE rating_4.userId = rater_1.userId)
			>= ALL(SELECT AVG(food) FROM Rating rating_5 GROUP BY rating_5.userId))
		AND rating_.userId = rater_.userId AND rating_.restaurantId = R.restaurantId;

--#m)'Find the names and reputations of the raters that rated a specific restaurant (say Restaurant Z)
--the most frequently. Display this information together with their comments and the names and
--prices of the menu items they discuss. (Here Restaurant Z refers to a restaurant of your own
--choice, e.g. Ma Cuisine).'
SELECT Rater.name, Rating.Comments, MenuItem.name, MenuItem.price, temp.rateCount
FROM Rater
INNER JOIN Rating
  ON Rater.UserID=Rating.UserID
INNER JOIN RatingItem itemRate
  ON Rater.UserID=itemRate.UserID
INNER JOIN MenuItem
  ON MenuItem.ItemID=itemRate.ItemID
INNER JOIN
  (SELECT Rater2.UserID uuid, COUNT(Rating2.UserID) rateCount
    FROM Rater Rater2
    INNER JOIN Rating Rating2
      ON Rater2.UserID=Rating2.UserID
    INNER JOIN Location
      ON Rating2.LocationID=Location.LocationID
    WHERE Location.LocationID = 1 --Replace '1' with location
    GROUP BY Rater2.UserID
    ORDER BY rateCount) temp
  ON Rater.UserID=temp.uuid



--#n)'Find the names and emails of all raters who gave ratings that are lower than that of a rater with
--a name called John, in terms of the combined rating of Price, Food, Mood and Staff. (Note that
--there may be more than one rater with this name).'
SELECT Rater.name, Rater.email, (Rating.food+Rating.mood+Rating.price+Rating.staff) total
	FROM Rater
	INNER JOIN Rating
		ON Rater.UserID=Rating.UserID
	WHERE (Rating.food+Rating.mood+Rating.price+Rating.staff) < ALL
		(SELECT (Rating2.food+Rating2.mood+Rating2.price+Rating2.staff)
			FROM Rating Rating2
			INNER JOIN Rater Rater2
				ON Rating2.UserID=Rater2.UserID
			WHERE Rater2.name='Patricia') -- Replace name with user's name to compare to
			-- WHERE Rater2.UserID= 1 ) -- Replace with user's id to compare to
	order by total, Rater.name

--#o)
--'Find the names, types and emails of the raters that provide the most diverse ratings. Display this
--information together with the restaurants names and the ratings. For example, Jane Doe may
--have rated the Food at the Imperial Palace restaurant as a 1 on 1 January 2015, as a 5 on 15
--January 2015, and a 3 on 4 February 2015.  Clearly, she changes her mind quite often.'


SELECT rater_.name, rater_.type, rater_.email, R.name, rating_.food, rating_.price,
	rating_.mood, rating_.staff, rating_.comments FROM Rater rater_, Rating rating_, Restaurant R WHERE
		rater_.userId IN (SELECT rater_1.userId FROM Rater rater_1 GROUP BY rater_1.userId HAVING
			(SELECT max(stddev) FROM(SELECT stddev(r8ing.mood + r8ing.staff + r8ing.price +r8ing.food) as stddev
				FROM Rating r8ing WHERE r8ing.userId = rater_1.userId GROUP BY r8ing.restaurantId) as temp_)
			>= ALL((SELECT max(stddev) FROM (SELECT stddev(r8ing_1.mood + r8ing_1.staff + r8ing_1.price +r8ing_1.food) FROM Rating r8ing_1 GROUP BY r8ing_1.userId, r8ing_1.restaurantId) as temp_)))
