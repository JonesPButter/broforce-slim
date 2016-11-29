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

    public function create($username, $email, $password){
        $string = file_get_contents($this->db_location);
        $users = $this->container->get('serializer')->deserialize($string,'Source\\Models\\User[]', 'json');
        $this->container->get('logger')->info("Old-User-Table:" . json_encode($users));
        $user = new User($username, $email, $password);

        // add new User to the end of the array
        $users[] = $user;

        $jsonContent = $this->container->get('serializer')->serialize($users, 'json');
        $this->container->get('logger')->info("New-User-Table:" . $jsonContent);
        file_put_contents($this->db_location,$jsonContent);
        return $user;
    }

    public function getAllUsers()
    {
        $string = file_get_contents($this->db_location);
        $users = $this->container->get('serializer')->deserialize($string,'Source\\Models\\User[]', 'json');
        /*
        $person = new User("Bro", "Bromail", "not_encrypted");
        $jsonContent = $this->serializer->serialize($person, 'json');
        echo "\nPerson 1: " . $jsonContent;
        $user1 = $this->serializer->deserialize($jsonContent,"Source\\Models\\User", "json");
        echo "\nDeserialized. getUsername() = " . $user1->getUsername();

        $person2 = new User("Broman2", "secondBro@bromailer.de", "not_encrypted");
        $jsonContent2 = $this->serializer->serialize($person2, 'json');
        echo "\nPerson 2: " . $jsonContent2;
        $user2 = $this->serializer->deserialize($jsonContent2,"Source\\Models\\User", "json");
        echo "\nDeserialized. getUsername() = " . $user2->getUsername();

        $persons = array($person, $person2);
        $jsonContent3 = $this->serializer->serialize($persons, 'json');
        echo "Personenliste: " . $jsonContent3;
        $users = $this->serializer->deserialize($jsonContent3,"Source\\Models\\User[]", "json");
        */
        //echo "\nDeserialized. getFirstUser() = " . $users[0]->getUsername();
        return $users;
    }

    public function getUserWithEmail($email){
        $result = 0;
        foreach ($this->getAllUsers() as $user){
            if($user->getEmail() == $email){
                $result = $user;
            }
            break;
        }
        return $result;
    }

    public function getUserByID($id){

    }

    public function getUserByUsername($username){
        $result = 0;
        foreach ($this->getAllUsers() as $user){
            if($user->getUsername() == $username){
                $result = $user;
                break;
            }
        }
        return $result;
    }

    public function updateUser(User $user){

    }

}