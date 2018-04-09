SELECT use.name, rt.description, use.email, rest.name, MAX(temp.rateTotal) rate_max, MIN(temp.rateTotal) rate_min
	FROM Rater use
	INNER JOIN RaterType rt
		ON use.type_id=rt.type_id
	INNER JOIN Rating rate
		ON use.user_id=rate.user_id
	INNER JOIN Location loc
		ON loc.location_id=rate.location_id
	INNER JOIN Restaurant rest
		ON loc.restaurant_id=rest.restaurant_id
	INNER JOIN
		(SELECT rate2.user_id r2_uid, rate2.post_date r2_pd, rate2.location_id r2_lid, (rate2.food+rate2.price+rate2.staff+rate2.mood) rateTotal
			FROM Rating rate2) temp
		ON rate.user_id=temp.r2_uid AND rate.post_date=temp.r2_pd AND rate.location_id=temp.r2_lid
	GROUP BY use.name, rt.description, use.email, rest.name
	HAVING MAX(temp.rateTotal) - MIN(temp.rateTotal) >= 12
	ORDER BY use.name;