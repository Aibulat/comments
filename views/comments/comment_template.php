<?php if (isset($comment)): ?>
    <li class="media">
        <div class="media-left">
            <img class="media-object img-circle" src="/web/img/avatar.jpg" alt="...">
        </div>
        <div class="media-body">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div><?= $comment['author'] ?></div>
                    <span class="date"><?= $comment['created_at']; ?></span>
                </div>
                <div class="panel-body">
                    <div class="media-text text-justify"><?= $comment['value'] ?></div>
                    <div class="pull-right">
                        <a class="btn btn-danger" href="/?action=delete&id=<?= $comment['id'] ?>" data-confirm="qq"
                           onclick="return confirm('Вы уверены, что хотите удалить комментарий: <?= $comment['value'] ?> ?') ? true : false;">Удалить</a>
                        <a id="toggler<?= $comment['id'] ?>" class="btn btn-info"
                           onclick="openForm('form<?= $comment['id'] ?>', 'toggler<?= $comment['id'] ?>')">Ответить</a>
                    </div>
                </div>
                <div class="panel-footer" id="form<?= $comment['id'] ?>" style="display: none;">
                    <form class="form-horizontal" role="form" action="/" method="post" id="<?= $comment['id'] ?>">
                        <input name="parentID" type="hidden" value="<?= $comment['id'] ?>">

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
            </div>

            <?php if (!empty($comment['child'])): ?>
                <ul class="media-list">
                    <?= app\models\Toolkit::getTemplate($comment['child'], 'comment') ?>
                </ul>
            <?php endif; ?>
        </div>
    </li>
<?php endif; ?>
