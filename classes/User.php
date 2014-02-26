<?php
class User {
  protected $database;
  public $id;
  public $username;
  public $password;
  public $fname;
  public $lname;
  public $studentId;
  public $email;
  public $phone;
  public $cell;
  public $address;
  public $grade;
  public $shirt_size;
  public $parent_names;
  public $parent_email;
  public $parent_phone;
  public $parent_alt_phone;
  public $is_student;
  public $is_approved;
  public $is_editor;
  public $is_sponsor;
  public $is_admin;
  public $has_forms;
  public $has_paid;
  public $has_stims;
  public $has_safety_training;
  public function __construct($database, $data) {
    $this->database = $database;
  
    foreach($data as &$val) {
      if (!isset($val)) $val = null;
    }
    $data['id'] = (int) $data['id'];
    $data['is_student'] = (bool) $data['is_student'];
    $data['is_approved'] = (bool) $data['is_approved'];
    $data['is_editor'] = (bool) $data['is_editor'];
    $data['is_admin'] = (bool) $data['is_admin'];
    $data['is_sponsor'] = (bool) $data['is_sponsor'];
    $data['grade'] = (int) $data['grade'];
    
    $this->id = $data['id'];
    $this->username = $data['username'];
    $this->password = $data['password'];
    $this->fname = $data['fname'];
    $this->lname = $data['lname'];
    $this->studentId = $data['student_id'];
    $this->email = $data['email'];
    $this->phone = $data['phone'];
    $this->cell = $data['cell'];
    $this->address = $data['address'];
    $this->grade = $data['grade'];
    $this->shirt_size = $data['shirt_size'];
    $this->parent_names = $data['parent_names'];
    $this->parent_email = $data['parent_email'];
    $this->parent_phone = $data['parent_phone'];
    $this->parent_alt_phone = $data['parent_alt_phone'];
    $this->is_student = $data['is_student'];
    $this->is_sponsor = $data['is_sponsor'];
    $this->is_approved = $data['is_approved'];
    $this->is_editor = $data['is_editor'];
    $this->is_admin = $data['is_admin'];
    $this->has_paid = (bool) $data['has_paid'];
    $this->has_forms = (bool) $data['has_forms'];
    $this->has_stims = (bool) $data['has_stims'];
    $this->has_safety_training = (bool) $data['has_safety_training'];
  }
  
  public function checkPassword($checkPass) {
    return (new PasswordHash($this->username, $checkPass))->verify($this->password);
  }
  
  public function approve() {
    return ($this->database->approveUser($this->id));
  }
  
  public function setData($array) {
    if ($this->database->setUserData($this->id, $array)) {
      return true;
    } else return false;
  }
  
}