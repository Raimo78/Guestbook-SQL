<?php
class Calendar {
 
  private $pdo = null;
  private $stmt = null;
  public $error = "";
  function __construct(){
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, 
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (Exception $ex) { die($ex->getMessage()); }
  }

  function __destruct(){
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  function save ($start, $end, $txt, $color, $id=null) {
    
    $uStart = strtotime($start);
    $uEnd = strtotime($end);
    if ($uEnd < $uStart) {
      $this->error = "End date cannot be earlier than start date";
      return false;
    }

    if ($id==null) {
      $sql = "INSERT INTO `events` (`evt_start`, `evt_end`, `evt_text`, `evt_color`) VALUES (?,?,?,?)";
      $data = [$start, $end, $txt, $color];
    } else {
      $sql = "UPDATE `events` SET `evt_start`=?, `evt_end`=?, `evt_text`=?, `evt_color`=? WHERE `evt_id`=?";
      $data = [$start, $end, $txt, $color, $id];
    }

    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
    return true;
  }

  function del ($id) {
    try {
      $this->stmt = $this->pdo->prepare("DELETE FROM `events` WHERE `evt_id`=?");
      $this->stmt->execute([$id]);
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
    return true;
  }

  function get ($month, $year) {
   
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dayFirst = "{$year}-{$month}-01";
    $dayLast = "{$year}-{$month}-{$daysInMonth}";

    $this->stmt = $this->pdo->prepare("SELECT * FROM `events`
    WHERE `evt_start` BETWEEN ? AND ?
    OR `evt_end` BETWEEN ? AND ?");
    $this->stmt->execute([$dayFirst, $dayLast, $dayFirst, $dayLast]);
    
    $events = ["e" => [], "d" => []];
    while ($row = $this->stmt->fetch()) {
      $eStartMonth = substr($row['evt_start'], 5, 2);
      $eEndMonth = substr($row['evt_end'], 5, 2);
      $eStartDay = $eStartMonth==$month 
                 ? (int)substr($row['evt_start'], 8, 2) 
                 : 1 ;
      $eEndDay = $eEndMonth==$month 
               ? (int)substr($row['evt_end'], 8, 2) 
               : $daysInMonth ;
      for ($d=$eStartDay; $d<=$eEndDay; $d++) {
        if (!isset($events['d'][$d])) { $events['d'][$d] = []; }
        $events['d'][$d][] = $row['evt_id'];
      }
      $events['e'][$row['evt_id']] = $row;
      $events['e'][$row['evt_id']]['first'] = $eStartDay;
    }
    return $events;
  }
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'test.events');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

$CAL = new Calendar();