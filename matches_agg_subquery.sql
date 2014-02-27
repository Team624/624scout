CREATE TEM
SELECT 
	match_number,
	auto_high_miss
	FROM match_data
	INNER JOIN scout.teams ON match_data.team_number = teams.number
	LEFT OUTER JOIN cycles ON cycles.match_data_id = match_data.id
	WHERE team_number = 2158
	GROUP BY match_number;
