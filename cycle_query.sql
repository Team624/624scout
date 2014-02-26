SELECT 
        match_number, 
        team_number, 
        cycles.* 
        FROM cycles INNER JOIN match_data ON cycles.match_data_id = match_data.id
        WHERE team_number=:team_number