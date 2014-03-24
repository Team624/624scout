<?php class Predictor {
  public $coeffs = [
    'auto_high_hot' => 0,
    'auto_high_cold' => 0,
    'auto_low_hot' => 0,
    'auto_low_cold' => 0,
    'auto_mobility' => 0,
    'tele_high_score' => 0,
    'tele_low_score' => 0,
    'truss' => 0,
    'catch' => 0,
    'tele_high_score' => 0,
    'human_pass' => 0,
    'robot_pass' => 0,
    'foul_points' => 0,
    'pushing_rating' => 0,
    'driving_rating' => 0,
  ];
  public $lastKey = '';
  public $lastChange = 0;
  public function mutate() {
    $keys = array_keys($this->coeffs);
    $key = $keys[mt_rand(0, count($keys)-1)];
    $change = mt_rand(1,8)/4; //0.25 between +2 and -2
    if (mt_rand(0,1) === 1) {
      $change *= -1;
    }
    $this->coeffs[$key] +=  $change;
    $this->lastKey = $key;
    $this->lastChange = $change;
    echo "changing $key by $change";
  }
  public function unmutate() {
    $this->coeffs[$this->lastKey] -= $this->lastChange;
  }
  public function calcPS($data) {
    $ps = 0;
    foreach($this->coeffs as $key => $coeff) {
      //echo var_dump($data);
      $ps += $data[$key] * $coeff;
    }
    return $ps;
  }
  public function predictMatch($r1, $r2, $r3, $b1, $b2, $b3) {
    $red = $this->calcPS($r1) + $this->calcPS($r2) + $this->calcPS($r3);
    $blue = $this->calcPS($b1) + $this->calcPS($b2) + $this->calcPS($b3);
    $redWins = $red > $blue;
    return [
      'red' => $red,
      'blue' => $blue,
      'redWins' => $redWins
    ];
  }
  
  public function predictSchedule($schedule, $teams) {
    $results = [];
    foreach($schedule as $match) {
      $result = $this->predictMatch($teams[$match['red_1']], $teams[$match['red_2']], $teams[$match['red_3']], $teams[$match['blue_1']], $teams[$match['blue_2']], $teams[$match['blue_3']]);
      $result['match_number'] = $match['match_number'];
      $results[] = $result;
    }
    return $results;
  }
  public function checkAccuracy($predicted, $actual) {
    $correct = 0;
    foreach($predicted as $predMatch) {
      if($predMatch['redWins'] === $actual[$predMatch['match_number']]['redWins']) {
        $correct++;
      }
    }
    return $correct;
  }
}