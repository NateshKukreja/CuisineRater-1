SELECT rest.name, loc.first_open_date, rate.post_date
	FROM Restaurant AS rest
	INNER JOIN Location as loc
		ON rest.restaurant_id=loc.restaurant_id
	INNER JOIN Rating rate
		ON loc.location_id=rate.location_id
	WHERE rate.staff < ALL
		(SELECT rate2.staff
			FROM Rating AS rate2
			INNER JOIN Rater AS use2
				ON rate2.user_id=use2.user_id
			WHERE use2.user_id= 1 ) -- Replace '1' with specified id
	ORDER BY rate.post_date DESC;