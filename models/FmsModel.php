<?php
class FmsModel {
  public static $EVENT_CODE = 'Curie';
  public static $trimFields = [
    'QS','assist','auto','trussCatch','teleop'
  ];
  public function getRankings() {
    $text = file_get_contents('http://www2.usfirst.org/2014comp/events/' . self::$EVENT_CODE . '/rankings.html');
    $doc = new DOMDocument();
    @$doc->loadHTML($text);
    $rows = $doc->getElementsByTagName('table')->item(2)->getElementsByTagName('tr');
    $rankings = [];
    $i = 0;
    foreach($rows as $row) {
      if ($i >= 2)  {
        $cols = $row->getElementsByTagName('td');
        $rankingRow = [];
        $rankingRow['seed'] = $cols->item(0)->nodeValue;
        $rankingRow['team'] = $cols->item(1)->nodeValue;
        $rankingRow['QS'] = $cols->item(2)->nodeValue;
        $rankingRow['assist'] = $cols->item(3)->nodeValue;
        $rankingRow['auto'] = $cols->item(4)->nodeValue;
        $rankingRow['trussCatch'] = $cols->item(5)->nodeValue;
        $rankingRow['teleop'] = $cols->item(6)->nodeValue;
        $rankingRow['record'] = $cols->item(7)->nodeValue;
        $rankingRow['DQ'] = $cols->item(8)->nodeValue;
        $rankingRow['played'] = $cols->item(9)->nodeValue;
        foreach(self::$trimFields as $field) {
          $rankingRow[$field] = preg_replace('/\.00$/','',$rankingRow[$field]);
        }
        $rankings[$cols->item(0)->nodeValue] = $rankingRow;
      }
      $i++;
    }
    $ret = [];
    $ret['rankings'] = $rankings;
    $ret['lastPlayed'] = 'Current Match: ' . (intval(substr($rows->item(0)->nodeValue, 25))+1);
 //   echo var_dump($ret);
    return $ret;
  }
  
  public function getResults() {
    $text = file_get_contents('http://www2.usfirst.org/2014comp/events/' . self::$EVENT_CODE . '/matchresults.html');
    $doc = new DOMDocument();
    @$doc->loadHTML($text);
    $rows = $doc->getElementsByTagName('table')->item(2)->getElementsByTagName('tr');
    $results = [];
    $i = 0;
    foreach($rows as $row) {
      if ($i >= 3)  {
        $cols = $row->getElementsByTagName('td');
        $result = [];
        $result['time'] =       $cols->item(0)->nodeValue;
        $result['match'] =      $cols->item(1)->nodeValue;
        $result['red_1'] =      $cols->item(2)->nodeValue;
        $result['red_2'] =      $cols->item(3)->nodeValue;
        $result['red_3'] =      $cols->item(4)->nodeValue;
        $result['blue_1'] =     $cols->item(5)->nodeValue;
        $result['blue_2'] =     $cols->item(6)->nodeValue;
        $result['blue_3'] =     $cols->item(7)->nodeValue;
        $result['red_score'] =  $cols->item(8)->nodeValue;
        $result['blue_score'] = $cols->item(9)->nodeValue;
        $result['redWins'] = intval($result['red_score']) > intval($result['blue_score']);
        $result['tie'] = intval($result['red_score']) === intval($result['blue_score']);
        $results[$result['match']] = $result;
      }
      $i++;
    }
    return $results;
  }
  
  public function getLastMatchPlayed() {
    $results = getResults();
    
  }
}