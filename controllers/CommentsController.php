<?php

namespace app\controllers;

require_once __DIR__ . '/../models/Comments.php';
require_once __DIR__ . '/../models/Toolkit.php';

use app\models\Comments;
use app\models\Toolkit;


class CommentsController
{
    // стартовый метод, в зависимости от типа запроса и переданных параметров, выполняем соответствующее действие
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->actionAdd();
        }elseif ($_GET['action'] == 'delete')
        {
            $this->actionDelete();
        }else
        {
            return $this->actionIndex();
        }

    }

    // "Главная"
    private function actionIndex()
    {
        $comments = new Comments();
        $commentsData = $comments->findAll();
        $commentsCount = count($commentsData);
        // преобразуем данные из бд, преобразуем в древо и заполняем шаблон данными.
        $commentsTree = Toolkit::getTree(Toolkit::getArrayChangedKeys($commentsData));
        $commentsList = Toolkit::getTemplate($commentsTree, 'comment');
        // view - имя представления
        return [
            'view' => 'index',
            'comments' => [
                'count' => $commentsCount,
                'list' => $commentsList,
            ],
        ];
    }

    // добавление записи в бд
    private function actionAdd()
    {
        // форматируем пользовательские данные
        $parentId = isset($_POST['parentID']) ? (int)$_POST['parentID'] : null;
        $userName = isset($_POST['userName']) ? Toolkit::formatString($_POST['userName']) : null;
        $userMessage = isset($_POST['userMessage']) ? Toolkit::formatString($_POST['userMessage']) : null;

        if (isset($parentId, $userName, $userMessage)
            && (!empty($parentId) || $parentId === 0) && !empty($userName) && !empty($userMessage)) {
            $comments = new Comments();
            // если добавляемая запись имеет родителя, проверяем уровень вложенности
            if ($parentId !== 0)
            {
                $commentsData = $comments->findAll();
                $level = Toolkit::getLevel($commentsData, $parentId);
                if ($level < Comments::MAX_LEVEL) {
                    $comments->addComment($parentId, $userName, $userMessage);
                }
            }else
            {
                $comments->addComment($parentId, $userName, $userMessage);
            }
        }
        header('Location: /');
    }

    // удаляем запись
    private function actionDelete()
    {
        // форматируем пользовательские данные
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if (isset($id) && $id > 0)
        {
            $comments = new Comments();
            $toolkit = new Toolkit();
            $commentsData = $comments->findAll();
            // получаем потомков удаляемой записи
            $toolkit->setChild($commentsData, $id);
            $child = $toolkit->child;
            // удаляемую запись добавляем в массив потомков для удаления
            $child[] = $id;
            // удаляем всех потомков и саму запись
            $comments->deleteComments($child);
        }
        header('Location: /');
    }
}