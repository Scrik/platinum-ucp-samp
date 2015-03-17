<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class Pagination extends Object {

    public function get($query, $count, $uri, $page, $order, $limit) {
        if ($count < 1) {
            return FALSE;
        }

        if ($page == 1) {
            $limitPage = 0;
        } else {
            $limitPage = ($page - 1) * 10;
        }

        $array = $this->db->select("$query ORDER BY $order LIMIT $limitPage,$limit");

        if (empty($array)) {
            return FALSE;
        }

        return array(
            'data' => $array,
            'pagination' => $this->getTemplate(array(
                'maxPage' => ceil($count / $limit) + 1,
                'currentPage' => $page,
                'host' => $_SERVER['HTTP_HOST']
                    ), $uri)
        );
    }

    public function getTemplate($array, $uri) {
        if ($array['currentPage'] == 1) {
            $data['backAction'] = 'disabled';
        } else {
            $data['backHref'] = 'href="/' . $uri . '/' . ($array['currentPage'] - 1) . '/"';
        }

        if ($array['currentPage'] == ($array['maxPage'] - 1)) {
            $data['nextAction'] = 'disabled';
        } else {
            $data['nextHref'] = 'href="/' . $uri . '/' . ($array['currentPage'] + 1) . '/"';
        }

        for ($i = 1; $i < $array['maxPage']; $i++) {

            if ($i == $array['currentPage']) {
                $data['body'] .= $this->view->sub_load('pagination/oneCurrent', array('page' => $i));
            } else {
                $pageData = array(
                    'host' => $array['host'],
                    'pageName' => $uri,
                    'page' => $i
                );
                $data['body'] .= $this->view->sub_load('pagination/one', $pageData);
            }
        }

        return $this->view->sub_load('pagination/main', $data);
    }

}
