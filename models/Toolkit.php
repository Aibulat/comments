<?php

namespace app\models;


class Toolkit
{
    // свойство для хранения потомков
    public $child = [];

    // метод изменяет ключ массива на указанный
    public static function getArrayChangedKeys($array, $key = 'id')
    {
        $_comments = [];
        foreach ($array as $item) {
            $_comments[$item[$key]] = $item;
        }
        return $_comments;
    }

    // построение дерева
    public static function getTree($data)
    {
        $tree = array();
        foreach ($data as $id => &$row) {
            if (empty($row['parent_id'])) {
                $tree[$id] = &$row;
            } else {
                $data[$row['parent_id']]['child'][$id] = &$row;
            }
        }
        return $tree;
    }

    // получаем уровень вложенности
    public static function getLevel($data, $childID)
    {
        $level = 0;
        while ($childID) {
            $index = null;
            foreach ($data as $i => $child) {
                if ($child['id'] == $childID) {
                    $index = $i;
                    break;
                }
            }
            $childID = null;
            if ($index !== null) {
                $childID = $data[$index]['parent_id'];
                if ($childID !== 0) {
                    $level++;
                }

            }
        }
        return $level;
    }

    // сохраняем потомки в свойстве $child
    public function setChild($data, $parentID)
    {
        foreach ($data as $i => $child) {
            if ($child['parent_id'] == $parentID) {
                $this->child[] = $child['id'];
                self::setChild($data, $child['id']);
            }
        }
    }

    /*
     * Шаблоны подгружаются из /views/comments/'
     * Формат имени шаблона: (*)_template.php, в функцию передаем параметр (*)
     */
    public static function getTemplate($data, $templateName)
    {
        $html = '';
        foreach ($data as $$templateName) {
            ob_start();
            require __DIR__ . "/../views/comments/{$templateName}_template.php";
            $html .= ob_get_clean();
        }
        return $html;
    }

    // простое форматирование строки
    public static function formatString($string)
    {
        return trim(strip_tags($string));
    }
}