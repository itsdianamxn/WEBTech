<?php

require_once 'Database.php';
// ALTER TABLE `images` ADD `Message` TEXT NULL AFTER `timeline`;

class Picture
{
    private $id;
    private $childID;
    private $picture;
    private $timeline;
    
    private $message;
    private $date;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM images WHERE id = :id", true, [':id'=>$id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->childID = $result['child_ID'];
            $this->picture = $result['Picture'];
            $this->date = $result['uploadDate'];
            $this->timeline = $result['timeline'];
            return true;
        }
        return false;
    }

    public function find($childID)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM images WHERE child_ID = :childID", [':childID'=> $childID]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->childID = $result['child_ID'];
            $this->picture = $result['Picture'];
            $this->date = $result['uploadDate'];
            $this->timeline = $result['timeline'];
            return true;
        }
        return false;
    }

    public function getID()
    {
        return $this->id;
    }
    public function getChildID()
    {
        return $this->childID;
    }
    public function getPicture()
    {
        return $this->picture;
    }
    public function getDate()
    {
        return $this->date;
    }
    
    public function getTimeline(){
        return $this->timeline;
    }

    public function setChildID($id)
    {
        $this->childID = $id;
    }
    public function setPicture($path)
    {
        $this->picture = $path;
    }
    
    public function setTimeline($booleanValue){
        $this->timeline = $booleanValue;
    }

    public function add()
    {
        $db = new Database();
        $params = [
            ':childID' => $this->childID,
            ':picture' => $this->picture,
            ':timeline' => '0',
        ];
        $res = $db->execute('INSERT INTO images (child_ID, Picture, timeline) ' . 
                                       'VALUES (:childID, :picture, :timeline)', $params);

        return $res;
    }
    public function save()
    {
        $db = new Database();
        $params = [
            ':child_ID' => $this->childID,
            ':picture' => $this->picture,
            ':timeline'=> $this->timeline,
        ];
        
        $res = $db->execute('UPDATE images SET ' .
        'child_ID = :child_ID, Picture = :picture , timeline = :timeline' .
        'WHERE ID = ' . $this->id, $params);
        return $res;
    }
    
    public function delete()
    {
        if (file_exists($this->picture)) {
            unlink($this->picture);
        }
        $db = new Database();

        $db->execute('DELETE FROM images WHERE ID = :id', [':id' => $this->id]);

    }
}
?>
