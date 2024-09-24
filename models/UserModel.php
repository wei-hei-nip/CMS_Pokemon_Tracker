<?php

/**
 * Manages user accounts
 * Class UserModel
 */

class UserModel {

    /**
     * Generates a password hash
     * @param string $password The password
     * @return string The password hash
     */
    private function computeHash($password) {
        // this would be the quickest and safer way to store passwords, but requires PHP > 5.6
        //return password_hash($password, PASSWORD_DEFAULT);
        $salt = uniqid('', true);
        $algo = '6'; // CRYPT_SHA512
        $rounds = '9999';
        $crypt_salt = '$' . $algo . '$rounds=' . $rounds . '$' . $salt;
        $hashed_password = crypt($password, $crypt_salt);
        return $hashed_password;
    }

    /**
     * Registers a new user
     * @param string $name A user name
     * @param string $password A password
     * @param string $password_repeat A password again to check whether they match
     * @param int $year The current year entered by the user (antispam)
     * @param bool $visibility Set the user's profile visibility by other users.
     * @return array|bool[] for any error occur.
     */
    public function register($name, $password, $password_repeat, $year, $visibility) {
        if ($year != date('Y')) {
            return array(false, 'Antispam mismatch.');
        }
        if ($password != $password_repeat) {
            return array(false, 'Passwords mismatch.');
        }
        if ($visibility == 'public') {
            $visibility = 1; 
        } else if ($visibility == 'private'){
            $visibility = 0;
        } else{
            return array(false, 'Profile Visibility has no correct value.');
        }

        $user = array(
            'name' => $name,
            'password' => $this->computeHash($password),
            'visibility' => $visibility
        );
        try {
            Db::insert('users', $user);
        }
        catch (PDOException $ex) {
            return array(false, 'This username is already taken.');
        }
        return array(true);
    }

    /**
     * Logs a user in
     * @param string $name The user name
     * @param string $password The user password
     * @throws Exception
     */
    public function login($name, $password) {
        $user = Db::queryOne('
            SELECT user_id, name, user_group, password
            FROM users
            WHERE name = ?
        ', array($name));
        //if (!$user || !password_verify($password, $user['password']))
        if (!$user || !(crypt($password, $user['password']) == $user['password'])) {
            throw new Exception('Invalid username or password.');
        }
        $_SESSION['user'] = $user;
    }

    /**
     * Logs the user off by destroying the session data
     */
    public function logoff() {
        session_destroy();
    }

    /**
     * @param int $url user_id
     * 
     * if no $url specified, return the logged users detail,
     * if $url specified, return the correspond user of $url user_id
     * 
     * return null if no user is currently logged in
     * @return array|null The logged user or null if no user is currently logged in
     */
    public function getUser($url = null) {
        if ($url){ //if a user is specified, save as its user_id
            $user_id = $url;
        } else{ //if a user is not specified, return logged users, null if no logged users
            if ($_SESSION['user']){
                $user_id = $_SESSION['user']['user_id'];
            } else{ 
                return null;
            }
        }

        $user = Db::queryOne('
        SELECT user_id, name, user_group, password, visibility
        FROM users
        WHERE user_id = ?
        ', array($user_id));

        return $user;
    }

    /**
     * Returns whether the user is an admin or not. Admin is considered a user belonging to the 'admin' user_group
     * @return bool
     */
    public function isAdmin() {
        if (isset($_SESSION['user'])) {
            if (isset($_SESSION['user']['user_group']) &&  $_SESSION['user']['user_group'] === 'admin') {
                return true;
            }
        }
        return false;
    }


    /**
     * Returns a list of users in the database
     * @return array Users in the database
     * 
     * @param bool $visibility allows to select all users (UsersController), or users with only public visibility (UserCommunityController)
     */

    public function getUsers($visibility = null) {
        if ($visibility == 'public'){
            return Db::queryAll('
            SELECT user_id, name, user_group, visibility
            FROM users
            WHERE visibility = ?
            ORDER BY user_id
        ', array(1));
        }else{
            return Db::queryAll('
            SELECT user_id, name, user_group, visibility
            FROM users
            ORDER BY user_id
        ');
        }
    }

     /**
     * Removes a user from database, users.
     * @param int $url The user_id of the user to be removed
     * @return array|bool[] containing messages of error.
     */
    public function removeUser($url) {
        if ($url == $_SESSION['user']['user_id']){ //Does not allow user to remove themselves
            return array(false, 'You should not remove yourself.'); 
        } else if ( $url == 1 ){ //Does not allow user to remove the main admin User ID = 1
            return array(false, 'User ID 1 is not removable.');
        } else{
            try {
                $query = Db::query('
                            DELETE FROM users
                            WHERE user_id = ?
                        ', array($url));
            }
            catch (PDOException $ex) {
                return array(false, 'User could not be removed');
            }
        }
        // if no rows were affected then let the controller know that the user could not be found
        if ($query === null || $query === 0 ) {
            return array(false, 'User does not exist and cannot be removed.');
        }
        return array(true);
    }


    /**
     * Reassign the group of a user from database, users.
     * @param int $url The user_id of the user to be reassign
     * @return array|bool[] containing messages of error.
     */
    public function assignUser($group, $url) {
        if ($url == $_SESSION['user']['user_id']){ //Does not allow user to remove themselves
            return array(false, 'You should not reassign yourself.');
        } else if ( $url == 1 ){ //Does not allow user to remove the main admin User ID = 1
            return array(false, 'User ID 1 cannot be reassigned.');
        } else{
            try {
                $query = Db::query('
                            UPDATE users
                            SET user_group = ?
                            WHERE user_id = ?
                        ', array($group, $url));
            }
            catch (PDOException $ex) {
                return array(false, 'User could not be assigned');
            }
        }
        
        // if no rows were affected then let the controller know that the user could not be found
        if ($query === null || $query === 0 ) {
            return array(false, 'User does not exist and cannot be assigned.');
        }
        return array(true);
    }

    /**
     * Set the visibility of a user from database, users.
     * @param string $visible the visbility
     * @param int $url The user_id of the user to be reassign
     * @return array|bool[] containing messages of error.
     */
    public function changeVisibility($visible, $url){
        if ($url != $_SESSION['user']['user_id']){
            return array(false, 'You can only change your own account settings.');
        } else{
            try {
                if ($visible == 'public') {
                    $visible = 1;
                } else if ($visible == 'private'){
                    $visible = 0;
                } else{
                    return array(false, 'Profile Visibility has no correct value.');
                }

                $query = Db::query('
                            UPDATE users
                            SET visibility = ?
                            WHERE user_id = ?
                        ', array($visible, $url));
            }
            catch (PDOException $ex) {
                return array(false, 'Profile visibility could not be changed');
            }
        }  
    }

}