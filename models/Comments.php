<?php

namespace app\models;

require_once __DIR__ . '/DB.php';

class Comments extends DB
{
    // Максимальный уровень вложенности
    const MAX_LEVEL = 5;

    public function tableName()
    {
        return 'comments';
    }

    public function addComment($parentID, $author, $value)
    {
        $req = $this->dbh->prepare("INSERT INTO {$this->tableName()} (id, parent_id, author, value, created_at)
                             VALUES (NULL, :parentID, :author, :value, CURRENT_TIMESTAMP)");
        $req->execute([
            'parentID' => $parentID,
            'author' => $author,
            'value' => $value
        ]);
        return true;
    }

    public function deleteComments(array $keys, $columnName = 'id')
    {
        $keys = implode(', ', $keys);
        $this->dbh->exec("DELETE FROM {$this->tableName()} WHERE {$columnName} IN ({$keys})");
        return true;
    }
}