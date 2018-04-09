SELECT use.name, rate.comments, item.name, item.price, temp.rateCount
	FROM Rater use
	INNER JOIN Rating rate
		ON use.user_id=rate.user_id
	INNER JOIN RatingItem itemRate
		ON use.user_id=itemRate.user_id
	INNER JOIN MenuItem item
		ON item.item_id=itemRate.item_id
	INNER JOIN
		(SELECT use2.user_id uuid, COUNT(rate2.user_id) rateCount
			FROM Rater use2
			INNER JOIN Rating rate2
				ON use2.user_id=rate2.user_id
			INNER JOIN Location loc2
				ON rate2.location_id=loc2.location_id
			WHERE loc2.location_id = 1 --Replace '1' with location
			GROUP BY use2.user_id
			ORDER BY rateCount) temp
		ON use.user_id=temp.uuid


