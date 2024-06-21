<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../view/login.html");
    exit();
}

require_once '../model/Database.php';
require_once '../model/User.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

function sendResponse($status, $data)
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data); // Encode data as JSON before outputting
    exit();
}

switch($method)
{
    case 'GET':
        if (!isset($_SESSION['id'])) {
            sendResponse(401, ['error' => 'Unauthorized']);
        } else {
            $user = new User();
            $success = $user->load($_SESSION['id']);
            if ($success) {
                sendResponse(200, [
                    'id' => $user->getId(),
                    'firstname' => $user->getFirstname(),
                    'lastname' => $user->getLastname(),
                    'email' => $user->getEmail(),
                    'relationship' => $user->getRelation(),
                    'dob' => $user->getDob(),
                ]);
            } else {
                sendResponse(500, ['error' => 'Server Error']);
            }
        }
        break;
    case 'POST':
        if(!isset($input['email']) || !isset($input['password']))
        {
            sendResponse(400, ['error' => 'Email and password are required']);
        }
        $user = new User();
        $user->find($input['email']);
        if($user->getID() == null || !password_verify($input['password'], $user->getPassword()))
        {
            sendResponse(401, ['error' => 'Invalid email or password']);
        }
        $_SESSION['id'] = $user->getID();
        sendResponse(200, $user);
        break;

    case 'PUT':
        if(!isset($_SESSION['id']))
        {
            sendResponse(401, ['error' => 'Unauthorized']);
        }
        else{
            $user = new User();
            $user->load($_SESSION['id']);
            $data = [];
            parse_str(file_get_contents('php://input'), $data);
            if(isset($data['firstname']))
            {
                $user->setFirstname($data['firstname']);
            }
            if(isset($data['lastname']))
            {
                $user->setLastname($data['lastname']);
            }
            if(isset($data['email']))
            {
                $user->setEmail($data['email']);
            }
            if(isset($data['password']))
            {
                $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            }
            if(isset($data['relationship']))
            {
                $user->setRelation($data['relationship']);
            }
            if(isset($data['dob']))
            {
                $user->setDob($data['dob']);
            }
            $user->save();
            sendResponse(200, $user);
        }
    case 'DELETE':
        if(!isset($_SESSION['id']))
        {
            sendResponse(401, ['error' => 'Unauthorized']);
        }
        unset($_SESSION['id']);
        sendResponse(200, ['message' => 'Logged out']);
        break;
    default:
        sendResponse(405, ['error' => 'Method Not Allowed']);
        break;
}

?>