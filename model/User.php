<?php

require_once 'Database.php';
require_once 'Child.php';
require_once 'Notification.php';


class User
{
    private $id;
    private $firstname;
    private $lastname;
    private $password;
    private $email;
    private $relationship;
    private $dob;
    private $children;

    public function __construct()
    {
        $this->id = -1;
    }

    public function load($id)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM users WHERE id = :id", true, [':id'=>$id]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->firstname = $result['firstName'];
            $this->lastname = $result['lastName'];
            $this->password = $result['password'];
            $this->email = $result['email'];
            $this->relationship = $result['relationship'];
            $this->dob = $result['dob'];
            return true;
        }
        return false;
    }

    public function find($email)
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM users WHERE email = :email", true,  [':email'=> $email]);
        if ($result)
        {
            $this->id = $result['ID'];
            $this->firstname = $result['firstName'];
            $this->lastname = $result['lastName'];
            $this->password = $result['password'];
            $this->email = $result['email'];
            $this->relationship = $result['relationship'];
            $this->dob = $result['dob'];
            return true;
        }
        return false;
    }

    public function loadFromImport($data)
    {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->relationship = $data['relationship'];
        $this->dob = $data['dob'];
        if(!$this->find($this->email))
            $this->add();
        echo json_encode(['error' => 'User added']);
    }

    public function getAllUserNotifications(){
        $db = new Database();
        $result = $db->selectAll("SELECT * FROM notifications WHERE user_ID = :user_ID ORDER BY time_issued DESC", true, [':user_ID' => $this->id]);
        $notifications = [];
        if($result){
            foreach($result as $row){
                $notification = new Notification();
                $notification->load($row['ID']);
                $notifications[] = $notification;
            }
        }
        return $notifications;
    }

    public function getNrNotifications(){
        $db = new Database();
        $result = $db->select("SELECT COUNT(*) as count FROM notifications WHERE user_ID = :user_ID AND readN = 0", true, [':user_ID' => $this->id]);
        error_log("Nr of notifs: " . json_encode($result));
        if($result)
            return $result['count'];
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
    public function getPassword()
    {
        return $this->password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getRelation()
    {
        return $this->relationship;
    }
    public function getDOB()
    {
        return $this->dob;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setRelation($relationship)
    {
        $this->relationship = $relationship;
    }
    public function setDOB($dob)
    {
        $this->dob = $dob;
    }
    public function add()
    {
        $db = new Database();
        $params = [
            ':firstName' => $this->firstname,
            ':lastName' => $this->lastname,
            ':relationship' => $this->relationship,
            ':email' => $this->email,
            ':dob' => $this->dob,
            ':password' => $this->password
        ];
        $res = $db->execute('INSERT INTO users (firstName, lastName, relationship, email, dob, password) ' . 
                                       'VALUES (:firstName, :lastName, :relationship, :email, :dob, :password)', $params);

        return $res;
    }
    public function save()
    {
        $db = new Database();
        $params = [
            ':firstName' => $this->firstname,
            ':lastName' => $this->lastname,
            ':relationship' => $this->relationship,
            ':email' => $this->email,
            ':dob' => $this->dob,
            ':password' => $this->password,
            ':id' =>  $this->id
        ];
        $res = $db->execute('UPDATE users SET ' .
            'firstName = :firstName, lastName = :lastName, relationship = :relationship, email = :email, dob =:dob, password = :password ' .
            'WHERE ID = :id', $params);
        return $res;
    }

    public function getChildren()
    {
        $this->children = [];
        $db = new Database();
        $stmt = $db->select('SELECT ID FROM children WHERE parent_ID = :parent', false, [':parent'=>$this->id]);
        while ($result = $stmt->fetch())
        {
            $child = new Child();
            if ($child->load(($result['ID'])))
            {
                $this->children[$result['ID']] = $child;
            }
        }
        return $this->children;
    }


    public function delete()
    {
        $db = new Database();
        $this->getChildren();
        foreach ($this->children as $child) {
            $child->delete();
        }
        $db->execute('DELETE FROM users WHERE ID = :id', [':id' => $this->id]);
        if (file_exists('../pics/profiles/' . $this->id . '.jpg')) {
            unlink('../pics/profiles/' . $this->id . '.jpg');
        }
    }
}
?>
