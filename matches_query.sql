
SELECT 
	match_number,
	no_show,
	scouts.name as 'scout_name',
	auto_goalie,
	case when auto_goalie = 0 then 1 else 0 end AS 'auto_normal',
	auto_high_hot AS 'auto_high_hot',
	auto_high_cold AS 'auto_high_cold',
	auto_high_miss AS 'auto_high_miss',
	auto_high_hot AS 'auto_high_hot',
	auto_high_cold AS 'auto_high_cold',
	auto_high_miss AS 'auto_high_miss',
	auto_mobility AS 'auto_mobility',
	auto_block,
	auto_block_miss,
	tele_defense_time,
	tele_block,
	tipped,
	lost_comms,
	broke_down,
	fouls,
	tech_fouls,
	(fouls * 20 + tech_fouls * 50) as foul_points,
	driving_rating,
	pushing_rating,
	defense_rating,
	blocking_rating,
	control_rating,
	truss_rating,
	catch_rating,
	badness_rating
FROM scout.match_data
	INNER JOIN cycles
		ON cycles.match_data_id = match_data.id
	INNER JOIN scouts
		ON match_data.scout_id = scouts.id
WHERE team_number = :team_number
GROUP BY match_number
ORDER BY match_number
