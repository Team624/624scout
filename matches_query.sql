    SELECT 
      match_data.*, 
      count(cycles.id) AS 'cycle_count',
      sum(truss) as 'truss',
      sum(catch) as 'catch',
      sum(miss_catch) as 'miss_catch',
      sum(human_pass) as 'human_pass',
      sum(score_low) as 'score_low',
      sum(miss_low) as 'miss_low',
      sum(score_high) as 'score_high',
      sum(miss_high) as 'miss_high',
      sum(possess_time) as 'possess_time',
      sum(get_back) AS 'get_back',
      sum(get_mid) AS 'get_mid',
      sum(get_front) AS 'get_front',
      sum(move_back) AS 'move_back',
      sum(move_mid) as 'move_mid',
      sum(move_front) as 'move_front'
    FROM match_data 
    INNER JOIN cycles on cycles.match_data_id = match_data.id 
		WHERE team_number=:team_number
	  GROUP BY match_number
		
