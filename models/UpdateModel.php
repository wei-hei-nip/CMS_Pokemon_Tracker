<?php

/**
 * Manages update announcements in the application
 * Class updateModel
 */
class UpdateModel {
    /**
     * Returns a list of all update announcements in the database
     * @return array All the update announcements in the database
     */
    public function getUpdates() {
        return Db::queryAll('
            SELECT update_id, version_number, title, content, url, created_at, updated_at
            FROM updates
            ORDER BY update_id DESC
        ');
    }

    /**
     * Returns an update announcements from the database by a URL
     * @param string $url The URL
     * @return array|false The update or false if not found
     */
    public function getUpdate($url) {
        return Db::queryOne('
			SELECT update_id, version_number, title, content, url, created_at, updated_at
			FROM updates
			WHERE url = ?
		', array($url));
    }

    /**
     * Saves an update announcements into the database.
     * If the Id is false, it inserts a new row, otherwise, it updates the existing row.
     * @param int $id The update Id or false
     * @param array $update The update data
     */
    public function saveUpdate($id, $update) {
        if (!$id) {
            try {
                Db::insert('updates', $update);
            }
            catch (PDOException $ex) {
                return array(false, 'Update could not be saved');
            }
        }
        else {
            try {
                Db::update('updates', $update, 'WHERE update_id = ?', array($id));
            }
            catch (PDOException $ex) {
                return array(false, 'Update could not be saved');
            }
        }
        return array(true);
    }

    /**
     * Removes an update announcements
     * @param string $url The URL of the update to be removed
     * @return array|bool[]
     */
    public function removeUpdate($url) {
        try {
            $query = Db::query('
                        DELETE FROM updates
                        WHERE url = ?
                    ', array($url));
        }
        catch (PDOException $ex) {
            return array(false, 'Update could not be removed');
        }
        // if no rows were affected then let the controller know that the update announcements could not be found
        if ($query === null || $query === 0 ) {
            return array(false, 'This update does not exist and cannot be removed.');
        }
        return array(true);
    }
}