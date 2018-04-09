SELECT item.name, item.description, item.price, loc.manager_name, loc.hour_open, loc.hour_close, rest.url
	FROM Restaurant AS rest
	INNER JOIN Location AS loc
		ON rest.restaurant_id=loc.restaurant_id
	INNER JOIN MenuItem AS item
		ON rest.restaurant_id=item.restaurant_id
	WHERE rest.restaurant_id= 0 --Replace '0' with user-specified restaurant id
		AND item.price >= ALL 
		(SELECT item2.price 
			FROM MenuItem as item2
			WHERE item2.restaurant_id= 1 ); --Replace '1' with user-specified restaurant id
