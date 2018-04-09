SELECT ct.description, rest.name, use.name, temp.avgRate
	FROM Restaurant AS rest
	INNER JOIN CuisineType ct
		ON rest.cuisine=ct.cuisine_id
	INNER JOIN Location AS loc
		ON rest.restaurant_id=loc.restaurant_id
	INNER JOIN Rating AS rate
		ON loc.location_id=rate.location_id
	INNER JOIN Rater AS use
		ON rate.user_id=use.user_id
	INNER JOIN
		(SELECT loc2.location_id locid2, AVG(rate2.food) avgRate
			FROM Rating rate2
			INNER JOIN Location loc2
				ON rate2.location_id=loc2.location_id
			GROUP BY locid2) temp
		ON loc.location_id=locid2
	WHERE temp.avgRate >= ALL
		(SELECT AVG(rate2.food) avgRate
			FROM Rating rate2
			INNER JOIN Location loc2
				ON rate2.location_id=loc2.location_id
			INNER JOIN Restaurant rest2
				ON rest2.restaurant_id=loc2.restaurant_id
			INNER JOIN CuisineType ct2
				ON rest2.cuisine=ct2.cuisine_id
			WHERE ct2.cuisine_id=ct.cuisine_id
			GROUP BY loc2.location_id)
	ORDER BY ct.description