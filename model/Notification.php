<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');

require_once 'Database.php';

class Notification{
    private $id;
    private $user_ID;
    private $child_ID;
    private $message;
    private $title;
    private $date_issued;

    private $readN;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id){
        $db = new Database();
        $result = $db->select("SELECT * FROM notifications WHERE ID = :id", true, [':id' => $id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->user_ID = $result['user_ID'];
            $this->child_ID = $result['child_ID'];
            $this->message = $result['message'];
            $this->title = $result['title'];
            $this->date_issued = $result['time_issued'];
            $this->readN = $result['readN'];
            return true;
        }
        return false;
    }

    public function getElapsedTime()
    {
        $date = new DateTime($this->date_issued, new DateTimeZone('Europe/Bucharest'));
        error_log("Elapsed time: " . json_encode($date));
        $current_date = new DateTime(null, new DateTimeZone('Europe/Bucharest'));
        error_log("Current date: " . json_encode($current_date));
        $interval = $date->diff($current_date);
        return $interval;
    }


    public function add(){
        $db = new Database();
        $db->execute("INSERT INTO notifications (user_ID, child_ID, message, title, time_issued, readN) VALUES (:user_ID, :child_ID, :message, :title, :time_issued, :readNN)", [':user_ID' => $this->user_ID, ':child_ID' => $this->child_ID, ':message' => $this->message, ':title' => $this->title, ':time_issued' => $this->date_issued, ':readN' => $this->readN]);
    }

    public function getID(){
        return $this->id;
    }
    public function getUserID(){
        return $this->user_ID;
    }
    public function getChildID(){
        return $this->child_ID;
    }
    public function getMessage(){
        return $this->message;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDateIssued(){
        return $this->date_issued;
    }

    public function getreadN(){
        return $this->readN;
    }

    public function setId($id){
        $this->id = $id;
    }
    public function setUserID($user_ID){
        $this->user_ID = $user_ID;
    }
    public function setChildID($child_ID){
        $this->child_ID = $child_ID;
    }
    public function setMessage($message){
        $this->message = $message;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setDateIssued($date_issued){
        $this->date_issued = $date_issued;
    }

    public function setreadN($readN){
        $this->readN = $readN;
        $db = new Database();
        $db->execute("UPDATE notifications SET `readN` = :readN WHERE ID = :id", [':readN' => $readN, ':id' => $this->id]);
    }


}

?>