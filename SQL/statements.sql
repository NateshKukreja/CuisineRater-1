-- c. For each user‐specified category of restaurant, list the manager names together with the date
-- that the locations have opened. The user should be able to select the category (e.g. Italian or
-- Thai) from a list

--CONFIRMED
c)

Select L.manager_name, L.first_open FROM Location L WHERE
	L.restaurantId = (Select R.restaurantId FROM Restaurant R WHERE
		R.varType = 1);

-- d. Given a user‐specified restaurant, find the name of the most expensive menu item. List this
-- information together with the name of manager, the opening hours, and the URL of the
-- restaurant. The user should be able to select the restaurant name (e.g. El Camino) from a list.

--CONFIRMED
Select menu.name, menu.price, L.manager_name, L.hour_open, L.hour_close, R.url FROM 
		Restaurant R, Location L, MenuItem menu WHERE
		menu.price >= all(Select menu1.price FROM MenuItem menu1 WHERE
				menu1.restaurantId = R.restaurantId) AND
			R.restaurantId = L.restaurantId AND
			menu.restaurantId = R.restaurantId AND R.name ='Make You Fat';




-- j. Provide a query to determine whether Type Y restaurants are “more popular” than other
-- restaurants.  (Here, Type Y refers to any restaurant type of your choice, e.g. Indian or Burger.)
-- Yes, this query is open to your own interpretation!

--PLAUSIBLE

SELECT R.Name FROM Restaurant R WHERE R.varType = 1 
ORDER BY(R.rating) LIMIT 5

	-- l. Find the names and reputations of the raters that give the highest overall rating, in terms of the
-- Food or the Mood of restaurants. Display this information together with the names of the
-- restaurant and the dates the ratings were done.

--CONFIRMED

SELECT rater_.name, rater_.signup_day, rater_.reputation, R.name, rating_.vardate FROM Rater rater_, Restaurant R, Rating rating_ WHERE
	rater_.userId IN (SELECT rater_1.userId FROM Rater rater_1 WHERE
		(SELECT AVG(mood) FROM Rating rating_2 WHERE rating_2.userId = rater_1.userId)
			>= ALL(SELECT AVG(mood) FROM Rating rating_3 GROUP BY rating_3.userId)
		OR (SELECT AVG(food) FROM Rating rating_4 WHERE rating_4.userId = rater_1.userId)
			>= ALL(SELECT AVG(food) FROM Rating rating_5 GROUP BY rating_5.userId))
		AND rating_.userId = rater_.userId AND rating_.restaurantId = R.restaurantId;
		
-- o. Find the names, types and emails of the raters that provide the most diverse ratings. Display this
-- information together with the restaurants names and the ratings. For example, Jane Doe may
-- have rated the Food at the Imperial Palace restaurant as a 1 on 1 January 2015, as a 5 on 15
-- January 2015, and a 3 on 4 February 2015.  Clearly, she changes her mind quite often.

-- use standard deviaton



SELECT rater_.name, rater_.type, rater_.email, R.name, rating_.food, rating_.price, 
	rating_.mood, rating_.staff, rating_.comments FROM Rater rater_, Rating rating_, Restaurant R WHERE
		rater_.userId IN (SELECT rater_1.userId FROM Rater rater_1 GROUP BY rater_1.userId HAVING
			(SELECT max(stddev) FROM(SELECT stddev(r8ing.mood + r8ing.staff + r8ing.price +r8ing.food) as stddev 
				FROM Rating r8ing WHERE r8ing.userId = rater_1.userId GROUP BY r8ing.restaurantId) as temp_)
			>= ALL((SELECT max(stddev) FROM (SELECT stddev(r8ing_1.mood + r8ing_1.staff + r8ing_1.price +r8ing_1.food) FROM Rating r8ing_1 GROUP BY r8ing_1.userId, r8ing_1.restaurantId) as temp_)))
	