SELECT rest.cuisine, item.type_id, AVG(item.price)
	FROM Restaurant rest
	INNER JOIN MenuItem item
		ON rest.restaurant_id=item.restaurant_id
	WHERE rest.cuisine= 1 --Replace '1' with user-specified cuisine type
	GROUP BY rest.cuisine, item.type_id
	ORDER BY rest.cuisine, item.type_id;