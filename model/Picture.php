<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');
require_once 'Database.php';
// ALTER TABLE `images` ADD `Message` TEXT NULL AFTER `timeline`;

class Picture
{
    private $id;
    private $childID;
    private $picture;
    private $timeline = false;
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
            $this->message = $result['Message'];

            return true;
        }
        return false;
    }

    public function loadFromImport($data)
    {
        error_log('Picture loadFromImport called with data: ' . json_encode($data));
        $this->childID = $data['childID'];
        $this->picture = $data['path'];
        $this->date = $data['date'];
        $this->timeline = $data['timeline'];
        $this->message = $data['message'];
        $db = new Database();
        $params = [
            ':child_ID' => $this->childID,
            ':picture' => $this->picture,
            ':uploadDate' => $this->date,
            ':timeline' => $this->timeline,
            ':message' => $this->message
        ];
        $res = null;
        if(!$this->find($this->childID, $this->picture, $this->date))
        {
            $imageData = base64_decode($data['base64']);  
            file_put_contents($this->picture . ".jpg" ,$imageData);   
            $res = $db->execute('INSERT INTO images (child_ID, Picture, uploadDate, timeline, Message) ' . 
                                        'VALUES (:child_ID, :picture, :uploadDate, :timeline, :message)', $params);                                  
            error_log($res);
        }
        return $res;
    }

    public function find($childId, $picture, $date){
        $db = new Database();
        $result = $db->select("SELECT * FROM images WHERE child_ID = :child_ID AND Picture = :picture AND uploadDate = :uploadDate", true, [':child_ID'=>$childId, ':picture'=>$picture, ':uploadDate'=>$date]);
        if ($result)
        {
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
    public function isTimeline()
    {
        return $this->timeline;
    }
    public function getDescription()
    {
        return $this->message;
    }

   
    public function addToTimeline($desc)
    {
        $this->timeline = true;
        $this->message = $desc;
    }

    public function setPicture($path)
    {
        $this->picture = $path;
    }

    public function setChildID($childID)
    {
        $this->childID = $childID;
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
            ':timeline' => $this->timeline,
            ':message' => $this->message
        ];
        
        $res = $db->execute('UPDATE images SET ' .
        'child_ID = :child_ID, Picture = :picture, timeline = :timeline, Message = :message ' .
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
