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
       //     $query->debugDumpParams();
      $query->execute();
      
      $matchDataId = self::$conn->lastInsertId();
      if(isset($data['cycles'])) { //insert each cycle
        foreach($data['cycles'] as $cycle) {
          $cycle['match_data_id'] = $matchDataId;
          $cols = "";
          $params = "";
          foreach ($cycle as $col=>$val) {
            if(in_array($col, self::$cycleCols)) {
              $cols .= ($cols=="")? '' : ', ';
              $cols .= $col;
              $params .= ($params=='')? '' : ', ';
              $params .= ":$col";
            }
          }
          $sql = "INSERT INTO cycles ($cols) VALUES ($params)";
          $query = self::$conn->prepare($sql);
          foreach ($cycle as $col => $val) {
            if(in_array($col, self::$cycleCols)) {
              $query->bindValue(":$col", $val);
            }
          }
          $query->execute();
        }
      }
      
     if(!$trans) self::$conn->commit();
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
      $stmt = self::$conn->prepare('SELECT * FROM schedule');
      $stmt->execute();
      $res = $stmt->fetchAll();
      $ret = [];
      foreach($res as $row) {
        $ret[$row['match_number']] = $row;
      }
      return $ret;
    }
    
    public function getTeams() {
      $stmt = self::$conn->prepare('SELECT * FROM teams');
      $stmt->execute();
      $res = $stmt->fetchAll();
      $ret = [];
      foreach($res as $row) {
        $ret[$row['number']] = $row['name'];
      }
      return $ret;
    }
    
    public function getScouts() {
      $stmt = self::$conn->prepare('SELECT * FROM scouts');
      $stmt->execute();
      $res = $stmt->fetchAll();
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
    
    public function getTeamData($team) {
      $fileRoot = $GLOBALS['fileRoot'];
      /*$aggSql = file_get_contents($fileRoot . 'aggregate_query.sql');
      $aggQuery = self::$conn->prepare($aggSql);
      $aggQuery->bindValue(':team_number', $team);
      $aggQuery->execute();
      $data = $aggQuery->fetch(PDO::FETCH_ASSOC);
      
      $matchSql = file_get_contents($fileRoot . 'matches_query.sql');
      $matchQuery = self::$conn->prepare($matchSql);
      $matchQuery->bindValue(':team_number', $team);
      $matchQuery->execute();
      $matches = $matchQuery->fetchAll(PDO::FETCH_ASSOC);
      
      $cyclesSql = file_get_contents($fileRoot . 'cycle_query.sql');
      $cyclesQuery = self::$conn->prepare($cyclesSql);
      $cyclesQuery->bindValue(':team_number', $team);
      $cyclesQuery->execute();
      $cycles = $cyclesQuery->fetchAll(PDO::FETCH_ASSOC);*/
      self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
      $sql = file_get_contents($fileRoot . 'UberQuery.sql');
      $query = self::$conn->prepare($sql);
     // $query->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
      $query->bindValue(':team_number', $team);
      $query->execute();
      $query->nextRowset(); // skip CREATE TABLE
      $cycles = $query->fetchAll(PDO::FETCH_ASSOC); //get first select
      $query->nextRowset(); //move on
      $query->nextRowset(); //skip CREATE TABLE
      $matches = $query->fetchAll(PDO::FETCH_ASSOC);
     // echo var_dump($matches);
      $query->nextRowset();
      $query->nextRowset();
      $data = $query->fetch();
     // echo var_dump($data);
      foreach($matches as &$match) { //zip cycles into each match
        echo " zip ";
        $matchCycles = [];
        foreach($cycles as $cycle) {
          echo '<i>boink </i>';
          if($cycle['match_number'] == $match['match_number']) {
            echo '<b>pling</b> ';
            $matchCycles[] = $cycle;
          }
        }
        $match['num_cycles'] = count($matchCycles);
        $match['cycles'] = $matchCycles;
      }
      $data['num_matches'] = count($matches);
      $data['matches'] = $matches;
      
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
  }