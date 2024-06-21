<?php

require_once 'Database.php';
require_once 'Picture.php';


class Child
{
    private $id;
    private $firstname;
    private $lastname;
    private $dob;
    private $stage;
    private $parentID;
    private $pictures;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM children WHERE id = :id", true, [':id'=>$id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->dob = $result['dob'];
            $this->stage = $result['stage'];
            $this->parentID = $result['parent_ID'];;
            return true;
        }
        return false;
    }

    public function find($parentID)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM children WHERE parent_ID = :parentID", true, [':parentID'=> $parentID]);
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
        $this->ParentID = $ParentID;
    }

    public function add()
    {
        $db = new Database();
        $params = [
            ':firstName' => $this->firstname,
            ':lastName' => $this->lastname,
            ':dob' => $this->dob,
            ':stage' => $this->stage,
            ':ParentID' => $this->ParentID,


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
            ':ParentID' => $this->ParentID,
        ];
        
        $res = $db->execute('UPDATE children SET ' .
        'firstname = :firstName, lastname = :lastName, dob = :dob, stage = :stage, parent_ID = :ParentID ' .
        'WHERE ID = ' . $this->id, $params);
        return $res;
    }
    
    public function getPictures()
    {
        $this->pictures = [];
        $db = new Database();
        $res = $db->select('SELECT * FROM images where child_ID = :child', false, [':child'=>$this->id]);
        while ($row = $res->fetch())
        {
            $picture = new Picture();
            if($picture->load($row['ID']))
            {
                $this->pictures[$row['ID']] = $picture;
            }

        }
        return $this->pictures;
    }

    public function delete()
    {
        if (file_exists('../pics/childrenProfiles/' . $this->id . '.jpg')) {
            unlink('../pics/childrenProfiles/' . $this->id . '.jpg');
        }
        $db = new Database();
        $this->getPictures();
        foreach ($this->pictures as $picture) {
            $picture->delete();
        }
        // $db->execute('DELETE FROM images WHERE child_ID = :id', [':id' => $this->id]);
        $db->execute('DELETE FROM children WHERE ID = :id', [':id' => $this->id]);

    }
}
?>
