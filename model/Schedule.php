<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
require_once 'Database.php';

class Schedule
{
    private $id;
    private $type;
    private $child_ID; 
    private $message;
    private $recurrence;
    private $expiration;
    private $date;
    private $time;
    private $timeline = false;

    private $nextNotif;


    public function __construct()
    {
        $this->id = -1;
        $this->time = '09:00';
        $this->date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
    }    

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM schedule_events WHERE ID = :id", true, [':id' => $id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->type = $result['type'];
            $this->child_ID = $result['child_ID'];
            $this->message = $result['message'];
            $this->recurrence = $result['recurrence'];
            $this->expiration = $result['expiration'];
            $this->date = $result['date'];
            $this->time = $result['time'];
            $this->setNextNotif();

            if ($this->expiration == '0000-00-00')
            {
                $this->expiration = null;
            }
            return true;
        }
        return false;
    }

    public function loadFromImport($data)
    {
        $this->type = $data['type'];
        $this->child_ID = $data['child_ID'];
        $this->message = $data['message'];
        $this->recurrence = $data['recurrence'];
        $this->expiration = $data['expiration'];
        $this->date = $data['date'];
        $this->time = $data['time'];

        if (!$this->exists())
            $this->add();
    }

    // returns true if the object exists in database, otherwise false
    public function exists()
    {
        $db = new Database();
        $params = [':type' => $this->type,
                   ':child_ID' => $this->child_ID,
                   ':message' => $this->message,
                   ':recurrence' => $this->recurrence,
                   ':expiration' => $this->expiration, 
                   ':date' => $this->date,
                   ':time' => $this->time];
        $result = $db->select("SELECT * FROM schedule_events WHERE ".
                        "type = :type AND child_ID = :child_ID AND message = :message AND " .
                        "recurrence = :recurrence AND expiration = :expiration AND " .
                        "date = :date AND time = :time", true, $params);
        return $result;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'child_ID' => $this->child_ID,
            'message' => $this->message,
            'recurrence' => $this->recurrence,
            'expiration' => $this->expiration,
            'date' => $this->date,
            'time' => $this->time,
            'nextNotif' => $this->nextNotif,
        ];
    }

    public function add()
    {
        $db = new Database();
        $params = [
            ':type' => $this->type,
            ':child_ID' => $this->child_ID,
            ':message' => $this->message,
            ':recurrence' => $this->recurrence,
            ':expiration' => $this->expiration,
            ':time' => $this->time,
            ':date' => $this->date,
        ];
        $res = $db->execute('INSERT INTO schedule_events (type, child_ID, message, recurrence, expiration, time, date) ' . 
                            'VALUES (:type, :child_ID, :message, :recurrence, :expiration, :time, :date)', $params);

        return $res;
    }
    
    public function save()
    {
        $db = new Database();
        $params = [
            ':type' => $this->type,
            ':child_ID' => $this->child_ID,
            ':message' => $this->message,
            ':recurrence' => $this->recurrence,
            ':expiration' => $this->expiration,
            ':time' => $this->time,
            ':date' => $this->date,
            ':id' => $this->id,
            ':nextNotif' => $this->nextNotif,
        ];
        
        $res = $db->execute('UPDATE schedule_events SET `time` = :time, `date` = :date, ' .
            'type = :type, child_ID = :child_ID, message = :message, recurrence = :recurrence, expiration = :expiration, nextNotif = :nextNotif ' .
            'WHERE ID = :id', $params);
        return $res;
    }

    public function delete()
    {
        $db = new Database();
        return $db->execute('DELETE FROM schedule_events WHERE ID = :id', [':id' => $this->id]);
    }

    public function getOneTimeEvents()
    {
        $db = new Database();
        $query = "SELECT * FROM schedule_events WHERE recurrence = 'One-time'";
        $result = $db->select($query, true, []);
        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getNextNotif()
    {
        return $this->nextNotif;
    }

    public function setNextNotif(){
        $dateTime = new DateTime($this->date . ' ' . $this->time);
        switch($this->recurrence){
            case 'One-time':{
                $this->nextNotif = $dateTime->format('Y-m-d H:i'); // Adjust the format as needed
                break;
            }
            case 'Daily':{
                $dateTime->modify('+1 day');
                break;
            }
            case 'Weekly':{
                $dateTime->modify('+1 week');
                break;
            }
            case 'Monthly':{
                $dateTime->modify('+1 month');
                break;
            }
            case 'Yearly':{
                $dateTime->modify('+1 year');
                break;
            }
            default:
                break;
        }
        $this->nextNotif = $dateTime->format('Y-m-d H:i');
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getChildID()
    {
        return $this->child_ID;
    }

    public function setChildID($child_ID)
    {
        $this->child_ID = $child_ID;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getRecurrence()
    {
        return $this->recurrence;
    }

    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
    }
    public function isTimeline()
    {
        return $this->timeline;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

}