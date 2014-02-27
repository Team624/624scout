SELECT	,
	sum(case when auto_goalie = 0 then 1 else 0 end) AS 'auto_normal',
	ROUND(avg(auto_high_hot), 2) AS 'auto_high_hot',
	ROUND(avg(auto_high_cold),2) AS 'auto_high_cold',
	ROUND(avg(auto_high_miss),2) AS 'auto_high_miss',
	ROUND(avg(auto_low_hot),2) AS 'auto_low_hot',
	ROUND(avg(auto_low_cold),2) AS 'auto_low_cold',
	ROUND(avg(auto_low_miss),2) AS 'auto_low_miss',
	sum(auto_mobility) AS 'auto_mobility',
	ROUND(avg(auto_block), 2) AS 'auto_block',
	ROUND(avg(auto_block_miss), 2) AS 'auto_block_miss',
  ROUND(avg(auto_block+auto_block_miss), 2) AS 'auto_block_total',
	ROUND(avg(tele_defense_time), 2) AS 'tele_defense_time',
	ROUND(avg(tele_block), 2) AS 'tele_block',
	sum(no_show) AS 'no_show',
	sum(tipped) AS 'tipped',
	sum(lost_comms) AS 'lost_comms',
	sum(broke_down) AS 'broke_down',
	ROUND(avg(fouls) , 2)as 'fouls',
	ROUND(avg(tech_fouls), 2) as 'tech_fouls',
	ROUND(avg(fouls*20 + tech_fouls*50), 1) as 'foul_points',
	ROUND(avg(case when driving_rating = 0 then null else driving_rating end), 2) as 'driving_rating', -- don't count zeros into these, they mean N/A
	ROUND(avg(case when pushing_rating = 0 then null else pushing_rating end), 2) as 'pushing_rating',
	ROUND(avg(case when defense_rating = 0 then null else defense_rating end), 2) as 'defense_rating',
	ROUND(avg(case when blocking_rating = 0 then null else blocking_rating end), 2) as 'blocking_rating',
	ROUND(avg(case when control_rating = 0 then null else control_rating end), 2) as 'control_rating',
	ROUND(avg(case when truss_rating = 0 then null else truss_rating end), 2) as 'truss_rating',
	ROUND(avg(case when catch_rating = 0 then null else catch_rating end), 2) as 'catch_rating',
	ROUND(avg(badness_rating), 1) as 'badness_rating', -- except for badness rating, where 0 is meaningful
	ROUND(SUM(get_back) / sum(case when no_show = 0 then 1 end), 2) as 'get_back', -- per match
	ROUND(SUM(get_mid) / sum(case when no_show = 0 then 1 end), 2) as 'get_mid',
	ROUND(SUM(get_back) / sum(case when no_show = 0 then 1 end), 2) as 'get_front',
	ROUND(SUM(move_back) / sum(case when no_show = 0 then 1 end), 2) as 'move_back', -- per match
	ROUND(SUM(move_mid) / sum(case when no_show = 0 then 1 end), 2) as 'move_mid',
	ROUND(SUM(move_back) / sum(case when no_show = 0 then 1 end), 2) as 'move_front',
	ROUND(SUM(get_back OR get_mid OR get_front) / (count(distinct match_number) - sum(no_show)), 2) as 'possession_cycles', -- per match
	ROUND(COUNT(cycle_number) / sum(case when no_show = 0 then 1 end), 2) as 'total_cycles',
	ROUND(SUM(score_high) / sum(case when no_show = 0 then 1 end), 2) as 'score_high',
	ROUND(SUM(miss_high) / sum(case when no_show = 0 then 1 end), 2) as 'miss_high',
	ROUND(SUM(miss_high+score_high) / sum(case when no_show = 0 then 1 end), 2) as 'shots_high',
	ROUND(SUM(score_low) / sum(case when no_show = 0 then 1 end), 2) as 'score_low',
	ROUND(SUM(miss_low) / sum(case when no_show = 0 then 1 end), 2) as 'miss_low',
	ROUND(SUM(miss_low+score_low) / sum(case when no_show = 0 then 1 end), 2) as 'shots_low',
	ROUND(SUM(truss) / sum(case when no_show = 0 then 1 end), 2) as 'truss', -- truss scores per match,
	ROUND(SUM(truss) / COUNT(cycles.id), 2) as 'truss_per_cycle',
	SUM(truss),
	sum(case when no_show = 0 then 1 end)
	FROM match_data
	INNER JOIN scout.teams ON match_data.team_number = teams.number
	INNER JOIN cycles ON cycles.match_data_id = match_data.id
	WHERE team_number = 2158