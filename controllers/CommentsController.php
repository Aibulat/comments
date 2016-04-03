<?php

namespace app\controllers;

require_once __DIR__ . '/../models/Comments.php';
require_once __DIR__ . '/../models/Toolkit.php';

use app\models\Comments;
use app\models\Toolkit;


class CommentsController
{
    // ��������� �����, � ����������� �� ���� ������� � ���������� ����������, ��������� ��������������� ��������
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

    // "�������"
    private function actionIndex()
    {
        $comments = new Comments();
        $commentsData = $comments->findAll();
        $commentsCount = count($commentsData);
        // ����������� ������ �� ��, ����������� � ����� � ��������� ������ �������.
        $commentsTree = Toolkit::getTree(Toolkit::getArrayChangedKeys($commentsData));
        $commentsList = Toolkit::getTemplate($commentsTree, 'comment');
        // view - ��� �������������
        return [
            'view' => 'index',
            'comments' => [
                'count' => $commentsCount,
                'list' => $commentsList,
            ],
        ];
    }

    // ���������� ������ � ��
    private function actionAdd()
    {
        // ����������� ���������������� ������
        $parentId = isset($_POST['parentID']) ? (int)$_POST['parentID'] : null;
        $userName = isset($_POST['userName']) ? Toolkit::formatString($_POST['userName']) : null;
        $userMessage = isset($_POST['userMessage']) ? Toolkit::formatString($_POST['userMessage']) : null;

        if (isset($parentId, $userName, $userMessage)
            && (!empty($parentId) || $parentId === 0) && !empty($userName) && !empty($userMessage)) {
            $comments = new Comments();
            // ���� ����������� ������ ����� ��������, ��������� ������� �����������
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

    // ������� ������
    private function actionDelete()
    {
        // ����������� ���������������� ������
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if (isset($id) && $id > 0)
        {
            $comments = new Comments();
            $toolkit = new Toolkit();
            $commentsData = $comments->findAll();
            // �������� �������� ��������� ������
            $toolkit->setChild($commentsData, $id);
            $child = $toolkit->child;
            // ��������� ������ ��������� � ������ �������� ��� ��������
            $child[] = $id;
            // ������� ���� �������� � ���� ������
            $comments->deleteComments($child);
        }
        header('Location: /');
    }
}