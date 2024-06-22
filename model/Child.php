<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
require_once 'Database.php';
require_once 'Picture.php';
require_once 'Schedule.php';

class Child
{
    private $id;
    private $firstname;
    private $lastname;
    private $dob;
    private $stage;
    private $parentID;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM children WHERE id = :id", true, [':id'=> $id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->dob = $result['dob'];
            $this->stage = $result['stage'];
            $this->parentID = $result['parent_ID'];
            return true;
        }
        return false;
    }

    public function loadFromImport($data, $parentID)
    {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->dob = $data['dob'];
        $this->stage = $data['stage'];
        $this->parentID = $parentID;
        if(!$this->find($this->firstname, $this->lastname, $this->dob))
            $this->add();
        echo json_encode('Child added: ' . $this->firstname);
    }

    public function find($firstname, $lastname, $dob)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM children WHERE firstname = :firstname AND lastname = :lastname AND dob = :dob", true, [':firstname'=>$firstname, ':lastname'=>$lastname, ':dob'=>$dob]);
        if ($result)
        {
            return true;
        }
        return false;
    }

    public function getSchedule(){
        $db = new Database();
        $result = $db->selectAll("SELECT * FROM schedule_events WHERE child_ID = :id", true, [':id' => $this->id]);
        
        $schedules = [];
    
        if($result){
            foreach($result as $row){
                
                $schedule = new Schedule();
                $schedule->load($row['ID']);
                $schedules[] = $schedule->toArray();
            }
        }
        error_log('Schedules loaded: '. json_encode($schedules));
        return $schedules;
    }

    public function getID()
    {
        return $this->id;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function getDOB()
    {
        return $this->dob;
    }
    public function getStage()
    {
        return $this->stage;
    }
    public function getParentID()
    {
        return $this->parentID;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    public function setDOB($dob)
    {
        $this->dob = $dob;
    }
    public function setStage($stage)
    {
        $this->stage = $stage;
    }
    public function setParentID($ParentID)
    {
        $this->parentID = $ParentID;
    }

    public function add()
    {
        $db = new Database();
        $params = [
            ':firstName' => $this->firstname,
            ':lastName' => $this->lastname,
            ':dob' => $this->dob,
            ':stage' => $this->stage,
            ':ParentID' => $this->parentID,
        ];
        $res = $db->execute('INSERT INTO children (firstname, lastname, dob, stage, parent_ID) ' . 
                                       'VALUES (:firstName, :lastName, :dob, :stage, :ParentID)', $params);

        return $res;
    }
    
    public function save()
    {
        $db = new Database();
        $params = [
            ':firstName' => $this->firstname,
            ':lastName' => $this->lastname,
            ':dob' => $this->dob,
            ':stage' => $this->stage,
            ':ParentID' => $this->parentID,
            ':id' => $this->id,
        ];
        
        $res = $db->execute('UPDATE children SET ' .
            'firstname = :firstName, lastname = :lastName, dob = :dob, stage = :stage, parent_ID = :ParentID ' .
            'WHERE ID = :id', $params);
        return $res;
    }
    
    // if $timeline then returns only timeline photos
    public function getPictures($timeline)
    {
        $pictures = [];
        $db = new Database();
        if ($timeline)
            $res = $db->select('SELECT * FROM images where timeline and child_ID = :child', false, [':child'=>$this->id]);
        else
            $res = $db->select('SELECT * FROM images where child_ID = :child', false, [':child'=>$this->id]);
        while ($row = $res->fetch())
        {
            $picture = new Picture();
            if ($picture->load($row['ID']))
            {
                $pictures[$row['ID']] = $picture;
            }
        }
        return $pictures;
    }

    public function getSchedules($type)
    {
        $schedules = [];
        $db = new Database();
        $res = $db->select('SELECT * FROM schedule_events where type = :type and child_ID = :child', 
                           false, [':child' => $this->id, ':type' => $type]);
        while ($row = $res->fetch())
        {
            $schedule = new Schedule();
            if ($schedule->load($row['ID']))
            {
                $schedules[$row['ID']] = $schedule;
            }
        }
        
        return $schedules;
    }

    public function delete()
    {
        if (file_exists('../pics/childrenProfiles/' . $this->id . '.jpg')) {
            unlink('../pics/childrenProfiles/' . $this->id . '.jpg');
        }

        $db = new Database();
        $pictures = $this->getPictures(false);
        foreach($pictures as $picture) {
            $picture->delete();
        }

        $db->execute('DELETE FROM children WHERE ID = :id', [':id' => $this->id]);
    }
}
?>
