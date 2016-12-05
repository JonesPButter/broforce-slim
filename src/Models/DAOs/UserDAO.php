<?php
/**
 * Created by PhpStorm.
 * User: Jones
 * Date: 24.11.2016
 * Time: 10:27
 */

namespace Source\Models\DAOs;
use \Source\Models\User;

class UserDAO extends AbstractDAO
{

    public function create($username, $email, $password, $token){
        // get Usertable
        $users = $this->getTable();

        // create new User
        $id = md5(uniqid(rand(), true));
        $user = new User($id, $username, $email, $password, "user", $token);

        // add new User to the Usertable
        $users[] = $user;

        // save changes
        $this->saveTable($users);
        $this->container->get('logger')->info("Added new User: " . $user->to_json());
        return $user;
    }

    /*
     * Returns the table as an array
     */
    public function getTable(){
        $this->container->get('logger')->info("Collecting usertable from database user-db.json");
        $string = file_get_contents($this->db_location);
        $users = $this->container->get('serializer')->deserialize($string,'Source\\Models\\User[]', 'json');
        return $users;
    }

    /**
     * Saves the user table
     * @param $users [] the new usertable that should be saved, represented as an array
     */
    public function saveTable($users){
        $jsonContent = $this->container->get('serializer')->serialize($users, 'json');
        file_put_contents($this->db_location,$jsonContent);
    }

    public function getUserWithEmail($email){
        $result = 0;
        foreach ($this->getTable() as $user){
            if($user->getEmail() == $email){
                $result = $user;
                break;
            }

        }
        return $result;
    }

    public function getUserByID($id){
        $result = 0;
        foreach ($this->getTable() as $user){
            if($user->getId() == $id){
                $result = $user;
                break;
            }
        }
        return $result;
    }

    public function getUserByUsername($username){
        $result = 0;
        foreach ($this->getTable() as $user){
            if($user->getUsername() == $username){
                $result = $user;
                break;
            }
        }
        return $result;
    }

    public function updateUser(User $updatedUser){
        $users = $this->getTable();
        $newUsers = array();
        foreach ($users as $user){
            if($user->getId() == $updatedUser->getId()){
                $newUsers[] = $updatedUser;
            } else{
                $newUsers[] = $user;
            }
        }
        $this->saveTable($newUsers);
    }

}