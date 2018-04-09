SELECT rest.name, rest.url, ct.description, loc.phone_number, loc.phone_number, loc.street_address, loc.hour_open, loc.hour_close
	FROM Restaurant rest
	INNER JOIN CuisineType ct
		ON rest.cuisine=ct.cuisine_id
	INNER JOIN Location loc
		ON rest.restaurant_id=loc.restaurant_id
	WHERE loc.location_id NOT IN
		(SELECT loc2.location_id
			FROM Location loc2
			INNER JOIN Rating rate2
				ON loc2.location_id=rate2.location_id
			WHERE EXTRACT(month from rate2.post_date) = 1 -- Replace '1' with month from 1-12
				AND EXTRACT(year from rate2.post_date) = 2015 ) -- Replace '2015' with year