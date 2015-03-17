<?php

/* 
 * Platinum UCP SAMP by brebvix
 */

class Admin_newsModel extends Object {
    public function create($array) {
        $array = $this->db->filter($array);
        
        return $this->db->query("INSERT INTO `platinum_news`(`title`, `text`, `author`, `date`) VALUES('{$array['title']}', '{$array['text']}', '{$_SESSION['Name']}', NOW())");
    }
    
    public function getEdit($id) {
        return $this->db->select("SELECT `title`, `text` FROM `platinum_news` WHERE `id` = '$id'", false);
    }
    
    public function saveEdit($id, $title, $text) {
        $title = $this->db->filter($title);
        $text = $this->db->filter($text);
        
        return $this->db->query("UPDATE `platinum_news` SET `title` = '$title', `text` = '$text' WHERE `id` = '$id'");
    }
    
    public function delete($id) {
        return $this->db->query("DELETE FROM `platinum_news` WHERE `id` = '$id'");
    }
}