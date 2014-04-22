DROP TEMPORARY TABLE IF EXISTS regional_avgs;

CREATE TEMPORARY TABLE IF NOT EXISTS regional_avgs ENGINE = MEMORY ( 
SELECT
  count(id) AS 'matches_entries',
  avg(auto_goalie) AS 'auto_goalie',
  avg(auto_high_hot) AS 'auto_high_hot',
  avg(auto_high_cold) AS 'auto_high_cold',
  avg(auto_high_miss) AS 'auto_high_miss',
  avg(auto_low_hot) AS 'auto_low_hot',
  avg(auto_low_cold) AS 'auto_low_cold',
  avg(auto_low_miss) AS 'auto_low_miss',
  avg(auto_mobility) AS 'auto_mobility',
  avg(auto_block) AS 'auto_block',
  avg(auto_block_miss) AS 'auto_block_miss',
  avg(auto_block+auto_block_miss) AS 'auto_block_total',
  avg(tele_defense_time) AS 'tele_defense_time',
  avg(tele_block) AS 'tele_block',
  avg(no_show) AS 'no_show',
  avg(tipped) AS 'tipped',
  avg(lost_comms) AS 'lost_comms',
  avg(broke_down) AS 'broke_down',
  avg(fouls) as 'fouls',
  avg(tech_fouls) as 'tech_fouls',
  avg(case when driving_rating = 0 then null else driving_rating end) as 'driving_rating', -- don't count zeros into these, they mean N/A
  avg(case when pushing_rating = 0 then null else pushing_rating end) as 'pushing_rating',
  avg(case when defense_rating = 0 then null else defense_rating end) as 'defense_rating',
  avg(tele_high_score) as 'tele_high_score',
  avg(tele_high_miss) as 'tele_high_miss',
  avg(tele_high_miss+tele_high_score) as 'shots_high',
  ROUND(avg(tele_high_score)/avg(tele_high_miss+tele_high_score),2) as 'high_accuracy',
  avg(tele_low_score) as 'tele_low_score',
  avg(tele_low_miss) as 'tele_low_miss',
  avg(tele_low_miss+tele_low_score) as 'shots_low',
  ROUND(avg(tele_low_score)/avg(tele_low_miss+tele_low_score),2) as 'low_accuracy',
  avg(truss) as 'truss',
  avg(truss_miss) as 'truss_miss',
  avg(catch) as 'catch',
  avg(catch_miss) as 'catch_miss',
  ROUND(avg(catch+catch_miss)/ avg(case when no_show = 0 then 1 end), 1) as 'matchAvg_catch_miss',
  avg(human_pass) as 'human_pass',
  avg(human_pass_miss) as 'human_pass_miss',
  avg(human_pass+human_pass_miss) as 'human_pass_attempts',
  ROUND(avg(human_pass)/avg(human_pass+human_pass_miss),2) as 'human_pass_accuracy',
  avg(robot_pass) as 'robot_pass',
  avg(robot_pass_miss) as 'robot_pass_miss',
  avg(robot_pass+robot_pass_miss) as 'robot_pass_attempts',
  ROUND(avg(robot_pass)/avg(robot_pass+robot_pass_miss),2) as 'robot_pass_accuracy',
  avg(human_load) as 'human_load',
  avg(human_load_miss) as 'human_load_miss',
  avg(human_load+human_load_miss) as 'human_load_attempts',
  ROUND(avg(human_load)/avg(human_load+human_load_miss),2) as 'human_load_accuracy',
  avg(floor_load) as 'floor_load',
  avg(floor_load_miss) as 'floor_load_miss',
  avg(floor_load+floor_load_miss) as 'floor_load_attempts',
  ROUND(avg(floor_load)/avg(floor_load+floor_load_miss),2) as 'floor_load_accuracy',
  avg(other_possess) as 'other_possess',
  avg(dropped_balls) as 'dropped_balls',
  avg(field_truss) as 'field_truss',
  avg(field_truss_fail) as 'field_truss_fail',
  avg(human_truss) as 'human_truss',
  avg(human_truss_fail) as 'human_truss_fail',
  avg(human_truss_over) as 'human_truss_over'
FROM match_data;
);

SELECT * FROM regional_avgs;

-- SELECT team_number,avg(case when defense_rating = 0 then null else defense_rating end) as defense_rating_avg FROM match_data 
-- GROUP BY team_number 
-- ORDER BY defense_rating_avg DESC;

SELECT 'Somehow this select statement makes the query not fail... some sort of PDO bug';