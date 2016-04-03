<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Комментарии</title>
    <link rel="stylesheet" href="/../../web/css/bootstrap.min.css">
    <style>
        .title-comments {
            font-size: 1.4rem;
            font-weight: bold;
            line-height: 1.5rem;
            color: rgba(0, 0, 0, .87);
            margin-bottom: 1rem;
            padding-bottom: .25rem;
            border-bottom: 1px solid rgba(34, 36, 38, .15);
        }

        /* скрываем кнопку "Ответить" для элементов с уровнем вложенности 5*/
        .media .media .media .media .media a:last-child {
            display: none;
        }
    </style>
</head>
<body style="margin: 50px;">
<div class="comments">
    <h3 id="title-comments"
        class="title-comments"><?= !isset($commentsCount) || ($commentsCount === 0) ? 'Нет комментариев' : "Комментарии ($commentsCount)" ?></h3>
    <ul id="result" class="media-list"><?= isset($commentsList) ? $commentsList : '...' ?></ul>
</div>
<div class="panel panel-footer">
    <form class="form-horizontal" role="form" action="/" method="post" id="0">
        <input name="parentID" type="hidden" value="0">

        <div class="form-group">
            <label for="userName" class="col-sm-2 control-label">Имя:</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" id="userName" name="userName"
                       placeholder="Введите ваше имя" maxlength="50" required>
            </div>
        </div>
        <div class="form-group">
            <label for="userMessage" class="col-sm-2 control-label">Комментарий:</label>

            <div class="col-sm-10">
                                <textarea class="form-control" id="userMessage" name="userMessage"
                                          placeholder="Введите ваш комментарий" rows="2" maxlength="255"
                                          required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-info" type="submit">Добавить комментарий</button>
            </div>
        </div>
    </form>
</div>
<script>
    // простая функция для открытия/закрытия формы
    function openForm(formID, togglerID) {
        var div = document.getElementById(formID);
        var toggler = document.getElementById(togglerID);
        if (div.style.display == 'block') {
            div.style.display = 'none';
            toggler.innerHTML = 'Открыть';
        }
        else {
            div.style.display = 'block';
            toggler.innerHTML = 'Закрыть';
        }
    }
</script>
</body>
</html>