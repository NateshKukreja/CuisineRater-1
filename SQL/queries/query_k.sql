SELECT use.name, use.join_date, COUNT(rate.user_id), AVG(temp.innerAvg) as avgRate
	FROM Rater use
	INNER JOIN Rating rate
		ON use.user_id=rate.user_id
	INNER JOIN 
		(SELECT rate2.user_id r2_uid, rate2.post_date r2_pd, (rate2.food+rate2.mood)/2.0 innerAvg
			FROM Rating rate2) temp
		ON rate.user_id=temp.r2_uid AND rate.post_date=temp.r2_pd
	GROUP BY use.name, use.join_date
	ORDER BY avgRate DESC;