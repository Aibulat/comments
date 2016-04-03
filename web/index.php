<?php
require_once __DIR__ . '/../controllers/CommentsController.php';

try {
    // запускаем контроллер
    $data = (new \app\controllers\CommentsController())->run();
    // получаем представление
    $view = isset($data['view']) ? $data['view'] : 'index';
    // заполняем данными для представления index
    if ($view === 'index')
    {
        $commentsCount = isset($data['comments']['count']) ? $data['comments']['count'] : null;
        $commentsList = $commentsCount != 0 ? $data['comments']['list'] : null;
    }
    // загружаем соответствующее представление
    require_once __DIR__ . "/../views/comments/{$view}.php";
} catch (Exception $e) {
    // записываем исключеия в файл
    file_put_contents(__DIR__ . '/../log/SiteErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
    die($e->getMessage());
}