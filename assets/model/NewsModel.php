<?php

class NewsModel extends Object{
    public function getFromPage($page) {
        $page = $this->db->filter($page);
        $query1 = "SELECT * FROM `platinum_news`";
        $count = $this->db->select("SELECT COUNT(`id`) FROM `platinum_news`", false);
        return $this->pagination->get($query1, $count['COUNT(`id`)'], 'main/page',(empty($page) OR $page == 0) ? 1 : $page, '`id` DESC', 10);
    }
}
