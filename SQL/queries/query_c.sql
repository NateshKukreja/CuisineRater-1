SELECT loc.manager_name, loc.first_open_date
	FROM Restaurant AS rest
	INNER JOIN Location AS loc
		ON rest.restaurant_id=loc.restaurant_id
	WHERE rest.cuisine= 1 --Replace '1' with cuisine type selected by user
	ORDER BY rest.name, loc.first_open_date;