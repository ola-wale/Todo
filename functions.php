<?php
/**
 * MySql connection
 */
require_once "env.php";
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
/**
 * Call the function in the method query param ex: 'functions.php?method=newItem'
 * if it doesn't exist bail with a 404 status
 */
if(function_exists($_GET['method'])){
    call_user_func($_GET['method']);
} else {
    http_response_code(404); die();
}
/**
 * add a new todo item to the DB and return it's ID
 */
function new_item(){
    global $conn;
    $todoItem = $_POST['item'] ? strip_tags($_POST['item']) : '';
    $priority = $_POST['priority'] ? (int) $_POST['priority'] : 1;
    $query = $conn->prepare("INSERT INTO todo (item,priority) VALUES(:item, :priority)");
    try{
        $query->execute(array(
            "item" => $todoItem,
            "priority" => $priority,
        ));
        die(json_encode(array('id' => $conn->lastInsertId())));
    } catch (Exception $e){
        die($e->getMessage());
    }
}
/**
 * Mark a todo item as complete
 */
function mark_todo_as_complete(){
    global $conn;
    $todo_id = (int) $_POST['todoId'];
    $sql = "UPDATE todo SET is_completed=1 WHERE id=$todo_id";
    $query = $conn->prepare($sql);
    $query->execute();
    if(!$query->rowCount()){ //if no rows are updated respond with a 503? error
        http_response_code(503); die();
    }
    die();
}
/**
 * Get all todo items
 */
function get_items(){
    global $conn;
    $todos = $conn->prepare("SELECT * FROM todo");
    $todos->execute();
    $todos = $todos->fetchAll();
    die(json_encode($todos));
}