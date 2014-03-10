DROP TEMPORARY TABLE IF EXISTS matches_result;

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
    defense_rating,
    
	FROM match_data
	INNER JOIN scouts ON match_data.scout_id = scouts.id
	LEFT JOIN cycles_result ON cycles_result.match_data_id = match_data.id
	WHERE match_data.team_number = :team_number
	GROUP BY match_number
);
SELECT * FROM matches_result;

CREATE TEMPORARY TABLE IF NOT EXISTS agg_result ENGINE = MEMORY ( 
  SELECT
  teams.name AS 'name',
  count(matches_result.auto_normal) AS 'matches_played',
  sum(auto_normal) AS 'auto_normal',
  sum(auto_goalie) AS 'auto_goalie',
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
  ROUND(avg(foul_points), 1) as 'foul_points',
  ROUND(avg(case when driving_rating = 0 then null else driving_rating end), 2) as 'driving_rating', -- don't count zeros into these, they mean N/A
  ROUND(avg(case when pushing_rating = 0 then null else pushing_rating end), 2) as 'pushing_rating',
  ROUND(avg(case when defense_rating = 0 then null else defense_rating end), 2) as 'defense_rating',
  ROUND(avg(badness_rating), 1) as 'badness_rating', -- except for badness rating, where 0 is meaningful
  ROUND(SUM(get_back) / sum(case when no_show = 0 then 1 end), 2) as 'get_back', -- per match
  ROUND(SUM(get_mid) / sum(case when no_show = 0 then 1 end), 2) as 'get_mid',
  ROUND(SUM(get_back) / sum(case when no_show = 0 then 1 end), 2) as 'get_front',
  ROUND(SUM(move_back) / sum(case when no_show = 0 then 1 end), 2) as 'move_back', -- per match
  ROUND(SUM(move_mid) / sum(case when no_show = 0 then 1 end), 2) as 'move_mid',
  ROUND(SUM(move_back) / sum(case when no_show = 0 then 1 end), 2) as 'move_front',
  ROUND(AVG(possessions),2) as 'possessions',
  ROUND(AVG(cycles_played),2) as 'cycles',
  ROUND(SUM(score_high) / sum(case when no_show = 0 then 1 end), 2) as 'score_high',
  ROUND(SUM(miss_high) / sum(case when no_show = 0 then 1 end), 2) as 'miss_high',
  ROUND(SUM(miss_high+score_high) / sum(case when no_show = 0 then 1 end), 2) as 'shots_high',
  ROUND(SUM(score_low) / sum(case when no_show = 0 then 1 end), 2) as 'score_low',
  ROUND(SUM(miss_low) / sum(case when no_show = 0 then 1 end), 2) as 'miss_low',
  ROUND(SUM(miss_low+score_low) / sum(case when no_show = 0 then 1 end), 2) as 'shots_low',
  ROUND(SUM(truss) / sum(case when no_show = 0 then 1 end), 2) as 'truss',
  ROUND(100 * SUM(truss) / SUM(cycles_played), 0) as 'truss_percent',
  ROUND(SUM(catch) / sum(case when no_show = 0 then 1 end), 2) as 'catch',
  ROUND(SUM(miss_catch) / sum(case when no_show = 0 then 1 end), 2) as 'miss_catch',
  ROUND(SUM(catch_total) / sum(case when no_show = 0 then 1 end), 2) as 'catch_total',
FROM matches_result
INNER JOIN teams ON teams.number = matches_result.team_number
);

SELECT * FROM agg_result;

SELECT 'Somehow this select statement makes the query not fail... some sort of PDO bug';