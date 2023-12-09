<?php
include('connection.php');
session_start();

function isUsernameExists($username)
{
    global $conn;

    $sql = "SELECT COUNT(*) as count FROM user WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] > 0;
}
function registerUser($username, $password)
{
    global $conn;

    $hashpass = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO user (username, password) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashpass);

    if ($stmt->execute()) {
        return "User registered successfully";
    } else {
        return "Error: " . $conn->error;
    }
}

function loginUser($username, $password)
{
    global $conn;

    $sql = "SELECT id,username, password FROM user WHERE username=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function saveNotes($userId, $content)
{
    global $conn;
    $sql = "INSERT INTO note (user_id, content) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $userId, $content);
    $stmt->execute();
    $stmt->close();
}



function getNotes($userId)
{
    global $conn;

    $sql = "SELECT * FROM note WHERE user_id ='$userId'";

    $result = $conn->query($sql);

    $notes = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notes[] = $row;
        }
    }
    return $notes;
}


function updateNote($noteId, $content)
{
    global $conn;
    $sql = "UPDATE note SET content=? WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("si", $content, $noteId);
    $stmt->execute();
    $stmt->close();
}


function deleteNote($noteId)
{
    global $conn;

    $sql = "DELETE from note WHERE id='$noteId'";
    $conn->query($sql);
}

function isUserLoggedIn()
{
    global $conn;
    return isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']);
}

function getUsername()
{
    if (isUserLoggedIn()) {
        global $conn;

        $userId = $_SESSION['user_id'];

        $sql = "SELECT username FROM user WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['username'];
        } else {
            return "Unknown User";
        }
    } else {
        return "User Not Logged In";
    }
}
