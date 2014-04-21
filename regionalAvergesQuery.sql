DROP TEMPORARY TABLE IF EXISTS matches_result;
DROP TEMPORARY TABLE IF EXISTS agg_result;

CREATE TEMPORARY TABLE IF NOT EXISTS matches_result ENGINE = MEMORY(
	SELECT 
	match_data.match_number,
	match_data.team_number,
    no_show,
    scouts.name as 'scout_name',
    auto_goalie,
    (auto_goalie = 0) AS 'auto_normal',
    auto_location,
    auto_high_hot,
    auto_high_cold,
    auto_high_miss,
    auto_low_hot,
    auto_low_cold,
    auto_low_miss,
    auto_mobility,
    auto_block,
    auto_block_miss,
    (human_load + floor_load + other_possess + catch) AS 'possessions',
    tele_high_score,
    tele_high_miss,
    tele_low_score,
    tele_low_miss,
    (human_truss+human_truss_over+field_truss) AS 'truss',
    (field_truss_fail + human_truss_fail) AS 'truss_miss',
    catch,
    catch_miss,
    human_truss AS 'human_pass',
    field_truss,
    field_truss_fail,
    human_truss,
    human_truss_fail,
    human_truss_over,
    (human_truss_over + human_truss_fail) AS 'human_pass_miss',
    robot_pass,
    robot_pass_miss,
    human_load,
    human_load_miss,
    floor_load,
    floor_load_miss,
    other_possess,
    dropped_balls,
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
    defense_rating
    
	FROM match_data
	INNER JOIN scouts ON match_data.scout_id = scouts.id
	WHERE match_data.team_number = :team_number
	GROUP BY match_number
);
SELECT * FROM matches_result;

CREATE TEMPORARY TABLE IF NOT EXISTS agg_result ENGINE = MEMORY ( 
  SELECT
  teams.name AS 'name',
  :team_number AS 'team_number',
  count(matches_result.auto_normal) AS 'matches_played',
  sum(auto_normal) AS 'auto_normal',
  sum(auto_goalie) AS 'auto_goalie',
  sum(auto_high_hot) AS 'auto_high_hot',
  sum(auto_high_cold) AS 'auto_high_cold',
  sum(auto_high_miss) AS 'auto_high_miss',
  sum(auto_low_hot) AS 'auto_low_hot',
  sum(auto_low_cold) AS 'auto_low_cold',
  sum(auto_low_miss) AS 'auto_low_miss',
  sum(auto_mobility) AS 'auto_mobility',
  sum(auto_block) AS 'auto_block',
  sum(auto_block_miss) AS 'auto_block_miss',
  sum(auto_block+auto_block_miss) AS 'auto_block_total',
  sum(tele_defense_time) AS 'tele_defense_time',
  sum(tele_block) AS 'tele_block',
  sum(no_show) AS 'no_show',
  sum(tipped) AS 'tipped',
  sum(lost_comms) AS 'lost_comms',
  sum(broke_down) AS 'broke_down',
  sum(fouls) as 'fouls',
  sum(tech_fouls) as 'tech_fouls',
  sum(foul_points) as 'foul_points',
  ROUND(avg(case when driving_rating = 0 then null else driving_rating end), 1) as 'driving_rating', -- don't count zeros into these, they mean N/A
  ROUND(avg(case when pushing_rating = 0 then null else pushing_rating end), 1) as 'pushing_rating',
  ROUND(avg(case when defense_rating = 0 then null else defense_rating end), 1) as 'defense_rating',
  sum(possessions) as 'possessions',
  sum(tele_high_score) as 'tele_high_score',
  sum(tele_high_miss) as 'tele_high_miss',
  sum(tele_high_miss+tele_high_score) as 'shots_high',
  ROUND(sum(tele_high_score)/sum(tele_high_miss+tele_high_score),2) as 'high_accuracy',
  sum(tele_low_score) as 'tele_low_score',
  sum(tele_low_miss) as 'tele_low_miss',
  sum(tele_low_miss+tele_low_score) as 'shots_low',
  ROUND(sum(tele_low_score)/sum(tele_low_miss+tele_low_score),2) as 'low_accuracy',
  sum(truss) as 'truss',
  sum(truss_miss) as 'truss_miss',
  sum(catch) as 'catch',
  sum(catch_miss) as 'catch_miss',
  ROUND(SUM(catch+catch_miss)/ sum(case when no_show = 0 then 1 end), 1) as 'matchAvg_catch_miss',
  sum(human_pass) as 'human_pass',
  sum(human_pass_miss) as 'human_pass_miss',
  sum(human_pass+human_pass_miss) as 'human_pass_attempts',
  ROUND(SUM(human_pass)/sum(human_pass+human_pass_miss),2) as 'human_pass_accuracy',
  sum(robot_pass) as 'robot_pass',
  sum(robot_pass_miss) as 'robot_pass_miss',
  sum(robot_pass+robot_pass_miss) as 'robot_pass_attempts',
  ROUND(SUM(robot_pass)/sum(robot_pass+robot_pass_miss),2) as 'robot_pass_accuracy',
  sum(human_load) as 'human_load',
  sum(human_load_miss) as 'human_load_miss',
  sum(human_load+human_load_miss) as 'human_load_attempts',
  ROUND(SUM(human_load)/sum(human_load+human_load_miss),2) as 'human_load_accuracy',
  sum(floor_load) as 'floor_load',
  sum(floor_load_miss) as 'floor_load_miss',
  sum(floor_load+floor_load_miss) as 'floor_load_attempts',
  ROUND(SUM(floor_load)/sum(floor_load+floor_load_miss),2) as 'floor_load_accuracy',
  sum(other_possess) as 'other_possess',
  sum(dropped_balls) as 'dropped_balls',
  sum(field_truss) as 'field_truss',
  sum(field_truss_fail) as 'field_truss_fail',
  sum(human_truss) as 'human_truss',
  sum(human_truss_fail) as 'human_truss_fail',
  sum(human_truss_over) as 'human_truss_over'
FROM matches_result
INNER JOIN teams ON teams.number = matches_result.team_number
);

SELECT * FROM agg_result;

-- SELECT team_number,avg(case when defense_rating = 0 then null else defense_rating end) as defense_rating_avg FROM match_data 
-- GROUP BY team_number 
-- ORDER BY defense_rating_avg DESC;

SELECT 'Somehow this select statement makes the query not fail... some sort of PDO bug';