SELECT use.name, use.email, (rate.food+rate.mood+rate.price+rate.staff) total
	FROM Rater use
	INNER JOIN Rating rate
		ON use.user_id=rate.user_id
	WHERE (rate.food+rate.mood+rate.price+rate.staff) < ALL
		(SELECT (rate2.food+rate2.mood+rate2.price+rate2.staff) 
			FROM Rating rate2
			INNER JOIN Rater use2
				ON rate2.user_id=use2.user_id
			WHERE use2.name='Patricia') -- Replace name with user's name to compare to
			-- WHERE use2.user_id= 1 ) -- Replace with user's id to compare to
	order by total, use.name