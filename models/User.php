<?php 

class User {
    private $_id;
    private $_username;
    private $_password;
    private $_photo;
    private $_type;

    public function __construct($id, $username, $password, $photo, $type) {
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setPhoto($photo);
        $this->setType($type);
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function setUsername($username) {
        $this->_username = $username;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }

    public function getPhoto() {
        return $this->_photo;
    }

    public function setPhoto($photo) {
        $this->_photo = $photo;
    }

    public function getType() {
        return $this->_type;
    }

    public function setType($type) {
        $this->_type = $type;
    }

    public function getArray() {
        $array = array();

        $array["id"] = $this->getId();
        $array["username"] = $this->getUsername();
        $array["photo"] = $this->getPhoto();
        $array["type"] = $this->getType();

        return $array;
    }
}

?>