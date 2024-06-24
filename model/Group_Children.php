<?php
ini_set('display_errors', 0); // Turn off error displaying
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', '../errors.log');

require_once 'Database.php';
require_once 'Group.php';
require_once 'Child.php';

class Group_Children{
    private $id;
    private $child_ID;

    public function __construct(){
        $this->id = -1;
    }

    public function load($group_children){
        $this->id = $group_children['ID'];
        $this->child_ID = $group_children['child_ID'];
    }

    public function add(){
        $db = new Database();
        $db->execute("INSERT INTO group_children (ID, child_ID) VALUES (?)", [$this->id,$this->child_ID]);
        $result = $db->select("SELECT ID FROM group_children WHERE child_ID = ? AND ID = ?", true, [$this->child_ID,$this->id]);
        if($result){
            $this->id = $result['ID'];
        }
    }

    public function delete(){
        $db = new Database();
        $db->execute("DELETE FROM group_children WHERE ID = ? AND child_ID = ?", [$this->id,$this->child_ID]);
    }


    public function addChildToGroup($id, $child_ID){
        $db = new Database();
        $db->execute("INSERT INTO group_children (ID, child_ID) VALUES (?, ?)", [$id, $child_ID]);
    }

    public function getAllChildrenFromGroup($id){
        $db = new Database();
        $result = $db->selectAll("SELECT * FROM group_children WHERE ID = ?", true, [$id]);
        $children = [];
        if($result){
            foreach($result as $child){
                $group_children = new Child();
                $group_children->load($child['$child_ID']);
                $children[] = $group_children;
            }
        }
        return $children;
    }

    public function getId(){
        return $this->id;
    }
    public function getChildID(){
        return $this->child_ID;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setChildID($child_ID){
        $this->child_ID = $child_ID;
    }
}
?>