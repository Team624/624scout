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
  sum(auto_normal) AS 'auto_normal',
  sum(auto_goalie) AS 'auto_goalie',
  ROUND(avg(auto_high_hot), 1) AS 'auto_high_hot',
  ROUND(avg(auto_high_cold),1) AS 'auto_high_cold',
  ROUND(avg(auto_high_miss),1) AS 'auto_high_miss',
  ROUND(avg(auto_low_hot),1) AS 'auto_low_hot',
  ROUND(avg(auto_low_cold),1) AS 'auto_low_cold',
  ROUND(avg(auto_low_miss),1) AS 'auto_low_miss',
  sum(auto_mobility) AS 'auto_mobility',
  ROUND(avg(auto_block), 1) AS 'auto_block',
  ROUND(avg(auto_block_miss), 1) AS 'auto_block_miss',
  ROUND(avg(auto_block+auto_block_miss), 1) AS 'auto_block_total',
  ROUND(avg(tele_defense_time), 1) AS 'tele_defense_time',
  ROUND(avg(tele_block), 1) AS 'tele_block',
  sum(no_show) AS 'no_show',
  sum(tipped) AS 'tipped',
  sum(lost_comms) AS 'lost_comms',
  sum(broke_down) AS 'broke_down',
  ROUND(avg(fouls) , 1)as 'fouls',
  ROUND(avg(tech_fouls), 1) as 'tech_fouls',
  ROUND(avg(foul_points), 1) as 'foul_points',
  ROUND(avg(case when driving_rating = 0 then null else driving_rating end), 1) as 'driving_rating', -- don't count zeros into these, they mean N/A
  ROUND(avg(case when pushing_rating = 0 then null else pushing_rating end), 1) as 'pushing_rating',
  ROUND(avg(case when defense_rating = 0 then null else defense_rating end), 1) as 'defense_rating',
  ROUND(AVG(possessions),1) as 'possessions',
  ROUND(SUM(tele_high_score) / sum(case when no_show = 0 then 1 end), 1) as 'tele_high_score',
  ROUND(SUM(tele_high_miss) / sum(case when no_show = 0 then 1 end), 1) as 'tele_high_miss',
  ROUND(SUM(tele_high_miss+tele_high_score) / sum(case when no_show = 0 then 1 end), 1) as 'shots_high',
  ROUND(SUM(tele_low_score) / sum(case when no_show = 0 then 1 end), 1) as 'tele_low_score',
  ROUND(SUM(tele_low_miss) / sum(case when no_show = 0 then 1 end), 1) as 'tele_low_miss',
  ROUND(SUM(tele_low_miss+tele_low_score) / sum(case when no_show = 0 then 1 end), 1) as 'shots_low',
  ROUND(SUM(truss) / sum(case when no_show = 0 then 1 end), 1) as 'truss',
  ROUND(SUM(truss_miss) / sum(case when no_show = 0 then 1 end), 1) as 'truss_miss',
  ROUND(SUM(catch) / sum(case when no_show = 0 then 1 end), 1) as 'catch',
  ROUND(SUM(catch_miss) / sum(case when no_show = 0 then 1 end), 1) as 'catch_miss',
  ROUND(SUM(catch+catch_miss)/ sum(case when no_show = 0 then 1 end), 1) as 'matchAvg_catch_miss'
FROM matches_result
INNER JOIN teams ON teams.number = matches_result.team_number
);

SELECT * FROM agg_result;

SELECT 'Somehow this select statement makes the query not fail... some sort of PDO bug';