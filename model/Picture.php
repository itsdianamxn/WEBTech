<?php

require_once 'Database.php';

class Picture
{
    private $id;
    private $childID;
    private $picture;
    private $date;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM images WHERE id = :id", [':id'=>$id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->childID = $result['child_ID'];
            $this->picture = $result['Picture'];
            $this->date = $result['uploadDate'];

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
    
    public function setChildID($id)
    {
        $this->childID = $id;
    }
    public function setPicture($path)
    {
        $this->picture = $path;
    }

    public function add()
    {
        $db = new Database();
        $params = [
            ':childID' => $this->childID,
            ':picture' => $this->picture,
        ];
        $res = $db->execute('INSERT INTO images (child_ID, Picture) ' . 
                                       'VALUES (:childID, :picture)', $params);

        return $res;
    }
    public function save()
    {
        $db = new Database();
        $params = [
            ':child_ID' => $this->childID,
            ':picture' => $this->picture,
        ];
        
        $res = $db->execute('UPDATE images SET ' .
        'child_ID = :child_ID, Picture = :picture ' .
        'WHERE ID = ' . $this->id, $params);
        return $res;
    }
}
?>
