<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');

require_once 'Database.php';

class Group{
    private $id;
    private $parent_ID;
    private $name;
    private $nr_Children;

    public function __construct(){
        $this->id = -1;
    }

    public function load($id){
        $db = new Database();
        $group = $db->select("SELECT * FROM groups WHERE id = ?", true, [$id]);
        $this->id = $group['ID'];
        $this->parent_ID = $group['parent_ID'];
        $this->name = $group['name'];
        $this->nr_Children = $group['nr_Children'];
        
    }

    public function add(){
        $db = new Database();
        $db->execute("INSERT INTO groups (parent_ID, name) VALUES (?, ?)", [$this->parent_ID, $this->name]);
        $result = $db->select("SELECT id FROM groups WHERE parent_ID = ? AND name = ? AND nr_Children = ?", true, [$this->parent_ID, $this->name, $this->nr_Children]);
        if($result){
            $this->id = $result['id'];
        }
    }
    

    public function getAllGroups($parent_ID){
        $db = new Database();
        $result = $db->selectAll("SELECT * FROM groups WHERE parent_ID = ?", true, [$parent_ID]);
        $groups = [];
        if($result){
            foreach($result as $group){
                $group = new Group();
                $group->load($group);
                $groups[] = $group;
            }
        }
        return $groups;
    }

    public function find($id){
        $db = new Database();
        $result = $db->select("SELECT * FROM groups WHERE id = ?", true, [$id]);
        if($result){
            return true;
        }
        return false;
    }

    public function findByName($parent_ID, $name){
        $db = new Database();
        $result = $db->select("SELECT * FROM groups WHERE name = ? and parent_ID = ?", true, [$name,$parent_ID]);
        if($result){
            return true;
        }
        return false;
    }
    
    public function delete(){
        $db = new Database();
        $db->execute("DELETE FROM groups WHERE id = ?", [$this->id]);
    }

    public function modify(){
        $db = new Database();
        $db->execute("UPDATE groups SET parent_ID = ?, name = ?, nr_Children = ? WHERE id = ?", [$this->parent_ID, $this->name, $this->nr_Children, $this->id]);
    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getParent_ID(){
        return $this->parent_ID;
    }
    public function getNr_Children(){
        return $this->nr_Children;
    }
    public function setparentID($parent_ID){
        $this->parent_ID = $parent_ID;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setNr_Children($nr_Children){
        $this->nr_Children = $nr_Children;
    }

    public function incrementNrChildren(){
        $this->nr_Children++;
        $db =  new Database();
        $db->execute("UPDATE group SET nr_Children = ? WHERE id = ?", [$this->nr_Children, $this->id]);
    }
}
?>