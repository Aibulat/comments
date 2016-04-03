<?php

namespace app\models;

// ���������� PDO ��� ������ � ��
use PDO;
use PDOException;

abstract class DB
{
    protected $dbh;

    abstract public function tableName();

    public function __construct()
    {
        // ���������� ���� try/catch ��� ������ ����������
        try {
            //��������� ������ ��� ����������� � ��
            $config = require_once __DIR__ . '/../config/db.php';

            $this->dbh = new PDO($config['dsn'], $config['username'], $config['password']);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // ��������� ������ � �����
            file_put_contents(__DIR__ . '/../log/DbErrors.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
            die($e->getMessage());
        }
    }

    // ����� ���������� ��� ������ ������� � ���� �������������� �������
    public function findAll()
    {
        return $this->dbh->query('SELECT * FROM ' . $this->tableName())->fetchAll(PDO::FETCH_ASSOC);
    }
}