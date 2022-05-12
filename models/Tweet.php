<?php 

class Tweet {
    private $_id;
    private $_text;
    private $_timestamp;
    private $_active;

    public function __construct($id, $text, $timestamp, $active) {
        $this->setId($id);
        $this->setText($text);
        $this->setTimestamp($timestamp);
        $this->setActive($active);
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function getText() {
        return $this->_text;
    }

    public function setText($text) {
        $this->_text = $text;
    }

    public function getTimestamp() {
        return $this->_timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->_timestamp = $timestamp;
    }

    public function getActive() {
        return $this->_active;
    }

    public function setActive($active) {
        $this->_active= $active;
    }

    public function getArray() {
        $array = array();

        $array["id"] = $this->getId();
        $array["text"] = $this->getText();
        $array["timestamp"] = $this->getTimestamp();
        $array["active"] = $this->getActive();

        return $array;
    }
}

?>