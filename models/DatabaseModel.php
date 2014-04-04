<?php
class DatabaseModel {
  protected static $conn;
  protected static $matchDataCols = [
    'match_number',
    'team_number',
    'scout_id',
    'auto_goalie',
    'auto_location',
    'auto_high_hot',
    'auto_high_cold',
    'auto_high_miss',
    'auto_low_hot',
    'auto_low_cold',
    'auto_low_miss',
    'auto_mobility',
    'auto_block',
    'auto_block_miss',
    'tele_high_score',
    'tele_high_miss',
    'tele_low_score',
    'tele_low_miss',
    'truss',
    'truss_miss',
    'catch',
    'catch_miss',
    'human_pass',
    'human_pass_miss',
    'robot_pass',
    'robot_pass_miss',
    'human_load',
    'human_load_miss',
    'floor_load',
    'floor_load_miss',
    'other_possess',
    'dropped_balls',
    'tele_defense_time',
    'tele_block',
    'no_show',
    'tipped',
    'lost_comms',
    'broke_down',
    'fouls',
    'tech_fouls',
    'driving_rating',
    'pushing_rating',
    'defense_rating',
    'blocking_rating',
    'control_rating',
    'pickup_rating',
    'truss_rating',
    'catch_rating',
    'badness_rating'
  ];
  protected static $cycleCols = [
    'match_data_id',
    'cycle_number',
    'get_back',
    'get_mid',
    'get_front',
    'move_back',
    'move_mid',
    'move_front',
    'truss',
    'catch',
    'miss_catch',
    'human_pass',
    'score_low',
    'miss_low',
    'score_high',
    'miss_high',
    'possess_time'
  ];
  public function __construct() {
      try {
        if (!isset(self::$conn)) {
          $config = $GLOBALS['config'];
            self::$conn = (new PDO($config->get('dbpath'), 
                                   $config->get('dbuser'), 
                                   $config->get('dbpass'), 
                                   array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")));
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
      } catch (PDOException $ex) {
        die('Database connection failed.');
      }
    }
    public function submitMatch($data) {
    $trans = self::$conn->inTransaction();
      if(!$trans) self::$conn->beginTransaction();
      $cols = "";
      $params = "";
      foreach($data as $col => $val) {
        if(in_array($col, self::$matchDataCols)) {
          $cols .= ($cols=="")? '' : ', ';
          $cols .= $col;
          $params .= ($params=='')? '' : ', ';
          $params .= ":$col";
        }
      }
      $sql = "INSERT INTO match_data ($cols) VALUES ($params)";
      $query = self::$conn->prepare($sql);
      foreach ($data as $col => $val) {
        if(in_array($col, self::$matchDataCols)) {
          $query->bindValue(":$col", $val);
        }
      }
      //$query->debugDumpParams();
      $query->execute();
      
      $matchDataId = self::$conn->lastInsertId();
      

      if(isset($data['note'])) {
        $query->closeCursor();
        $sql = 'INSERT INTO notes (team, match_number, text) VALUES (:team, :match_number, :text)';
        $query = self::$conn->prepare($sql);
        $query->bindValue(':match_number', $data['match_number']);
        $query->bindValue(':team', $data['team_number']);
        $query->bindValue(':text', $data['note']);
        $query->execute();
      }
           if(!$trans) self::$conn->commit();
    return true;
    }
    
    public function updateMatch($data) {
      self::$conn->beginTransaction();
      $sql = "DELETE FROM match_data WHERE team_number=:team_number AND match_number=:match_number";
      $query = self::$conn->prepare($sql);
      $query->bindValue(':team_number', $data['team_number']);
      $query->bindValue(':match_number', $data['match_number']);
      $query->execute();
      $this->submitMatch($data);
      self::$conn->commit();
    }
    
    public function getSchedule() {
      $sql = "SELECT 
        schedule.*,
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.red_1, 0)>0, 1,0)) as 'has_red_1',
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.red_2, 0)>0, 1,0)) as 'has_red_2',
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.red_3, 0)>0, 1,0)) as 'has_red_3',
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.blue_1, 0)>0, 1,0)) as 'has_blue_1',
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.blue_2, 0)>0, 1,0)) as 'has_blue_2',
        SUM(IF(IFNULL(match_data.id AND match_data.team_number = schedule.blue_3, 0)>0, 1,0)) as 'has_blue_3'
      FROM schedule
      LEFT JOIN match_data ON match_data.match_number = schedule.match_number
      GROUP BY schedule.match_number";
      $stmt = self::$conn->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $ret = [];
      foreach($res as $row) {
        $ret[$row['match_number']] = $row;
      }
      
      return $ret;
    }
    
    public function getTeams() {
      $stmt = self::$conn->prepare('SELECT * FROM teams');
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $ret = [];
      foreach($res as $row) {
        $ret[$row['number']] = $row['name'];
      }
      return $ret;
    }
    
    public function getScouts() {
      $stmt = self::$conn->prepare('SELECT * FROM scouts');
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $ret = [];
      foreach ($res as $row) {
        $ret[$row['id']] = $row['name'];
      }
      return $ret;
    }
    
    
    public function setSchedule($schedule) {
      self::$conn->beginTransaction();
      $dropState = self::$conn->prepare('DELETE FROM schedule');
      $dropState->execute();
      
      $sql = ('INSERT INTO schedule (match_number, time, red_1, red_2, red_3, blue_1, blue_2, blue_3) VALUES ');
      $frist = true;
      foreach ($schedule as $row) {
        if(!$frist) $sql .= ',';
        $sql .= '(?,?,?,?,?,?,?,?)';
        $frist = false;
      }
      $stmt = self::$conn->prepare($sql);
      $params = [];
      foreach ($schedule as $row) {
        array_push($params, $row['match_number'],$row['time'], $row['red_1'], $row['red_2'], $row['red_3'], $row['blue_1'], $row['blue_2'], $row['blue_3']);
      }
      $stmt->execute($params);
      
      self::$conn->commit();
    }
    
    public function setTeamList($teams) {
      self::$conn->beginTransaction();
      $dropTeams = self::$conn->prepare('DELETE FROM schedule');
      $dropTeams->execute();
      
      $sql = 'INSERT INTO teams (number, name) VALUES ';
      $firstVal = true;
      foreach($teams as $number=>$name) {
        if($firstVal) $firstVal = false;
        else $sql .= ',';
        $sql .= '(?,?)';
      }
      $stmt = self::$conn->prepare($sql);
      $params = [];
      foreach($teams as $number=>$name) {
        array_push($params, $number, $name);
      }
      $stmt->execute($params);
      
      self::$conn->commit();
    } 
    
    public function getTeamData($team,$includeAggrigated = TRUE) {
    
      $fileRoot = $GLOBALS['fileRoot'];
     
      self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
      $sql = file_get_contents($fileRoot . 'UberQueryDOrlando.sql');
      $query = self::$conn->prepare($sql);
      
     // $query->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
      $query->bindValue(':team_number', $team);
      //TODO make sure the non-aggrigated table creation does not happen when it is turned off
      $query->execute();  
      
      $query->nextRowset();
      $query->nextRowset();
      
      $query->nextRowset();
      ////$query->nextRowset(); // skip CREATE TABLE
      //$cycles = $query->fetchAll(PDO::FETCH_ASSOC); //get first select     
      ////$query->nextRowset(); //move on
      ////$query->nextRowset(); //skip CREATE TABLE 
      $matches = null;   
      if($includeAggrigated) $matches = $query->fetchAll(PDO::FETCH_ASSOC);
      
      $query->nextRowset();
      $query->nextRowset();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      $query->closeCursor();
      
      $noteSql = 'SELECT match_number, team, text FROM notes WHERE team = :team';
      $noteQuery = self::$conn->prepare($noteSql);
      $noteQuery->bindValue(':team', $team);
      $noteQuery->execute();
      $data['notes'] = $noteQuery->fetchAll(PDO::FETCH_ASSOC);
      
      $data['num_matches'] = count($matches);
      $data['matches'] = $matches;
      return $data;
      
    }
    
    public function getAllTeamData() {
      $fileRoot = $GLOBALS['fileRoot'];
      $sql = file_get_contents($fileRoot . 'TeamsQuery.sql');
      $query = self::$conn->prepare($sql);
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      $teams = [];
      foreach($result as $row) {
        $teams[$row['team_number']] = $row;
      }
      return $teams;
    }
    public function getMatchData($match) {
    
      $fileRoot = $GLOBALS['fileRoot'];
      self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
      $sql = "SELECT * FROM schedule WHERE match_number=$match";
      $query = self::$conn->prepare($sql);
      $query->execute();  
      
      $data = $query->fetch(PDO::FETCH_ASSOC);
      $data['teamDatas'] = array(
        $data['red_1'] => $this->getTeamData($data['red_1'],FALSE),
        $data['red_2'] => $this->getTeamData($data['red_2'],FALSE),
        $data['red_3'] => $this->getTeamData($data['red_3'],FALSE),
        $data['blue_1'] => $this->getTeamData($data['blue_1'],FALSE),
        $data['blue_2'] => $this->getTeamData($data['blue_2'],FALSE),
        $data['blue_3'] => $this->getTeamData($data['blue_3'],FALSE)
      );
      //$teamDatas = array(
      
      /*$data['num_matches'] = count($matches);
      $data['matches'] = $matches;
      echo "-->";*/
      return $data;
      
    }
    public function getRawMatchData() {
      $sql = 'SELECT * FROM match_data ORDER BY match_number';
      $query = self::$conn->prepare($sql);
     // $query->bindValue(':team', $team);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRawCycleData() {
      $sql = 'SELECT cycles.* FROM cycles INNER JOIN match_data ON match_data.id = cycles.match_data_id ORDER BY match_number';
      $query = self::$conn->prepare($sql);
     // $query->bindValue(':team', $team);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function submitNote($data) {
      $sql = 'INSERT INTO notes (team, text) VALUES (:team, :text)';
      $query = self::$conn->prepare($sql);
      $query->bindValue(':team', $data['team']);
      $query->bindValue(':text', $data['text']);
      $query->execute();
      return true;
    }
    
    public function obliterate($pw) {
      if($pw === '624obliterationpassword') {
        self::$conn->beginTransaction();
          self::$conn->query('DELETE FROM notes');
          self::$conn->query('DELETE FROM match_data');
          self::$conn->query('DELETE FROM schedule');
          self::$conn->query('DELETE FROM teams');
        self::$conn->commit();
        return true;
      } else {
        return false;
      }
    }
  }