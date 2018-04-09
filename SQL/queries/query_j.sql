SELECT ct.description, temp.avgRate
FROM CuisineType ct
LEFT JOIN
	(SELECT ct2.cuisine_id ct2_cid, AVG(innerT.innerAvg) avgRate
		FROM CuisineType ct2
		INNER JOIN Restaurant rest2
			ON ct2.cuisine_id=rest2.cuisine
		INNER JOIN Location loc2
			ON rest2.restaurant_id=loc2.restaurant_id
		INNER JOIN Rating rate2
			ON loc2.location_id=rate2.location_id
		INNER JOIN
			(SELECT rate3.user_id r3_uid, rate3.post_date r3_pd, (rate3.food+rate3.price+rate3.staff+rate3.mood)/4.0 innerAvg
				FROM Rating rate3) innerT
			ON rate2.user_id=innerT.r3_uid AND rate2.post_date=innerT.r3_pd
		GROUP BY ct2.cuisine_id) temp
	ON ct.cuisine_id=temp.ct2_cid
	ORDER BY temp.avgRate DESC