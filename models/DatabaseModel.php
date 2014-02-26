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
      $matchSql = "
        SELECT 
          match_data.*, 
          count(cycles.id) AS 'cycle_count' 
        FROM match_data 
        INNER JOIN cycles on cycles.match_data_id = match_data.id 
        WHERE team_number=2158;
      ";
      $data = [];
      $data['team'] = $team;
      
    }
  }