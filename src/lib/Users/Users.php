<?php
require_once 'config/config.php';

class Users
{
    private $langArray;
    /**
     *
     */
    public function __construct()
    {
        global $langArray;
        $this->langArray = $langArray;
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => $this->langArray["ID"],
            'username' => $this->langArray["Username"],
            'type' => $this->langArray["Type"]
        ];

        return $ordering;
    }

    public function getAllUsers() {
        $db = getDbInstance();
        return $db->get(DATABASE_PREFIX.'users');
    }

    public function getUser($id) {
        $db = getDbInstance();

        $db->where('id', $id);
        $result = $db->getOne('users');

        if($result !== NULL)
            return $result;
        else
            $this->failure($this->langArray["User not found"]);
    }
    
    /**
     * Add user
     */
    public function addUser($input_data) {
        $db = getDbInstance();

        $data_to_db["username"] = $input_data["username"];
        $data_to_db['password'] = password_hash($input_data['password'], PASSWORD_DEFAULT);
        $data_to_db["type"] = $input_data["type"];

        $db->where('username', $data_to_db['username']);
        $db->get('users');

        if ($db->count >= 1)
            $this->failure($this->langArray["Username already exists"]);

	    $last_id = $db->insert('users', $data_to_db);

	    if ($last_id)
		    $this->success($this->langArray["User added successfully"]);
    }
    
    /**
     * Edit user
     * 
     */
    public function editUser($input_data) {
        $db = getDbInstance();

        $db->where('username', $input_data['username']);
        $db->where('id', $input_data["id"], '!=');
        $row = $db->getOne('users');

        if (!empty($row['username']))  {
            $query_string = http_build_query(array(
                'id' => $input_data["id"],
                'edit' => "true",
            ));
            $this->failure($this->langArray["Username already exists"], 'Location: user.php?'.$query_string);
        }

        $data_to_db["username"] = $input_data["username"];
        $data_to_db['password'] = password_hash($input_data['password'], PASSWORD_DEFAULT);
        $data_to_db["type"] = $input_data["type"];

	    $db->where('id', $input_data["id"]);
	    $stat = $db->update('users', $data_to_db);
        
        if ($stat)
            $this->success($this->langArray["User updated successfully"]);
        else
            $this->failure($this->langArray["Failed to update User"] . $db->getLastError());
    }
    
    /**
     * Delete user
     * 
     */
    public function deleteUser($id) {
        if($_SESSION['type']!='super'){
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit("401 Unauthorized");
        }
        
        $db = getDbInstance();
        $db->where('id', $id);
        $stat = $db->delete('users');

        if ($stat)
            $this->info($this->langArray["User deleted successfully"]);
        else
            $this->failure($this->langArray["Unable to delete user"]);
    }
    
    /**
     * Flash message Failure process
     */
    public function failure($message, $location = 'Location: users.php') {
        $_SESSION['failure'] = $message;
        header($location);
    	exit();
    }
    
    /**
     * Flash message Success process
     */
    public function success($message) {
        $_SESSION['success'] = $message;
        header('Location: users.php');
    	exit();
    }
    
    /**
     * Flash message Info process
     */
    public function info($message) {
        $_SESSION['info'] = $message;
        header('Location: users.php');
    	exit();
    }
}
?>
