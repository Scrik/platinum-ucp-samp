<?php

class UserbarController extends Object {

    public function get($args) {
        $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/view/images/cache/{$args[0]}.png";
        header('Content-type: image/png');
        if (is_file($file)) {
            if ((time() - filemtime($file)) <= 1800) {
                echo file_get_contents($file);
                $continue = FALSE;
            } else {
                unlink($file);
            }
        }
        if ($continue !== FALSE) {
            if ($this->model->userbar->isAllowed($args[0])) {
                $this->_getUserBar($args[0]);
            } else {
                echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/assets/view/images/no-userbar.png");
            }
        }
    }

    private function _getUserBar($name) {
        $array = $this->model->userbar->getInfo($name);
        $root = $_SERVER['DOCUMENT_ROOT'];
        $font = "$root/assets/view/fonts/arial.ttf";
        $image = "$root/assets/view/images/userbar/{$array['image']}";

        $im = imagecreatefrompng($image);
        foreach ($array['data'] AS $value) {
            $value['pos_left'] = $value['pos_left'];
            if ($value['name'] == 'Skin') {
                $id = $array['text'][$value['name']]['value'];
                $src = imagecreatefrompng("$root/assets/view/images/skins/Skin_$id.png");

                imagecopymergegray($im, $src, $value['pos_left'], $value['pos_top'] - 133, 0, 0, imagesx($src), imagesy($src), 100);
            } else {
                $array['text'][$value['name']]['value'] = strip_tags($array['text'][$value['name']]['value']);
                $text = $array['text'][$value['name']]['title'] . ': ' . $array['text'][$value['name']]['value'];

                preg_match("/\(([^()]*)\)/", $value['color'], $color);
                $color = explode(',', $color[1]);
                $color = imagecolorallocate($im, $color[0], $color[1], $color[2]);
                $fontSize = $value['fontSize'] * 0.7528125;
                $value['pos_top'] = $value['pos_top'] + ($fontSize * 1.33333333) - 0.35433070866;
                imagettftext($im, $fontSize, 0, $value['pos_left'], $value['pos_top'], $color, $font, (string) $text);
            }
        }
        imagepng($im, "$root/assets/view/images/cache/$name.png");
        imagepng($im);
        imagedestroy($im);
    }

}
