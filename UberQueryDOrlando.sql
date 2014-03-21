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
    truss,
    truss_miss,
    catch,
    catch_miss,
    human_pass,
    human_pass_miss,
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
  count(matches_result.auto_normal) AS 'matches_played',
  avg(auto_normal) AS 'auto_normal',
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
  sum(no_show) AS 'no_show',
  avg(tipped) AS 'tipped',
  avg(lost_comms) AS 'lost_comms',
  avg(broke_down) AS 'broke_down',
  avg(fouls) as 'fouls',
  avg(tech_fouls) as 'tech_fouls',
  avg(foul_points) as 'foul_points',
  ROUND(avg(case when driving_rating = 0 then null else driving_rating end), 1) as 'driving_rating', -- don't count zeros into these, they mean N/A
  ROUND(avg(case when pushing_rating = 0 then null else pushing_rating end), 1) as 'pushing_rating',
  ROUND(avg(case when defense_rating = 0 then null else defense_rating end), 1) as 'defense_rating',
  avg(possessions) as 'possessions',
  avg(tele_high_score) as 'tele_high_score',
  avg(tele_high_miss) as 'tele_high_miss',
  avg(tele_high_miss+tele_high_score) as 'shots_high',
  ROUND(sum(tele_high_score)/sum(tele_high_miss+tele_high_score),2) as 'high_accuracy',
  avg(tele_low_score) as 'tele_low_score',
  avg(tele_low_miss) as 'tele_low_miss',
  avg(tele_low_miss+tele_low_score) as 'shots_low',
  ROUND(sum(tele_low_score)/sum(tele_low_miss+tele_low_score),2) as 'low_accuracy',
 avg(truss) as 'truss',
  avg(truss_miss) as 'truss_miss',
  avg(catch) as 'catch',
  avg(catch_miss) as 'catch_miss',
  ROUND(SUM(catch+catch_miss)/ sum(case when no_show = 0 then 1 end), 1) as 'matchAvg_catch_miss',
  avg(human_pass) as 'human_pass',
  avg(human_pass_miss) as 'human_pass_miss',
  avg(human_pass+human_pass_miss) as 'human_pass_attempts',
  ROUND(SUM(human_pass)/sum(human_pass+human_pass_miss),2) as 'human_pass_accuracy',
  avg(robot_pass) as 'robot_pass',
  avg(robot_pass_miss) as 'robot_pass_miss',
  avg(robot_pass+robot_pass_miss) as 'robot_pass_attempts',
  ROUND(SUM(robot_pass)/sum(robot_pass+robot_pass_miss),2) as 'robot_pass_accuracy',
  avg(human_load) as 'human_load',
  avg(human_load_miss) as 'human_load_miss',
  avg(human_load+human_load_miss) as 'human_load_attempts',
  ROUND(SUM(human_load)/sum(human_load+human_load_miss),2) as 'human_load_accuracy',
  avg(floor_load) as 'floor_load',
  avg(floor_load_miss) as 'floor_load_miss',
  avg(floor_load+floor_load_miss) as 'floor_load_attempts',
  ROUND(SUM(floor_load)/sum(floor_load+floor_load_miss),2) as 'floor_load_accuracy',
  avg(other_possess) as 'other_possess',
  avg(dropped_balls) as 'dropped_balls'
FROM matches_result
INNER JOIN teams ON teams.number = matches_result.team_number
);

SELECT * FROM agg_result;

SELECT 'Somehow this select statement makes the query not fail... some sort of PDO bug';