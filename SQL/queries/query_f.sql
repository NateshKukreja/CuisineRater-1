SELECT use.name, rest.name, COUNT(rate.post_date), AVG((rate.food+rate.price+rate.mood+rate.staff)/4.0)
	FROM Restaurant AS rest
	INNER JOIN Location AS loc
		ON rest.restaurant_id=loc.restaurant_id
	INNER JOIN Rating as rate
		ON loc.location_id=rate.location_id
	INNER JOIN Rater AS use
		ON rate.user_id=use.user_id
	GROUP BY rest.name, use.name
	ORDER BY use.name, rest.name;