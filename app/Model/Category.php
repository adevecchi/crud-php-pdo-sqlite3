<?php

namespace App\Model;

use App\Helper\Json;
use App\Database\SQLite;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Category
{
    private $db;
    private $logger;

    public function __construct()
    {
        $this->db = SQLite::create()->getConnection();

        $this->logger = new Logger('Category');
        $this->logger->pushHandler(new StreamHandler($this->getPathLogger(), Logger::DEBUG));
    }

    public function list(): string
    {
        $pstmt = $this->db->prepare('SELECT codigo, nome FROM categoria');

        $pstmt->execute();

        $result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function add(object $category)
    {
        $sql = 'INSERT INTO categoria (
                    codigo,
                    nome
                )
                VALUES (
                    :codigo,
                    :nome
                )';

        $pstmt = $this->db->prepare($sql);

        $pstmt->bindValue(':codigo', filter_var($category->code, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':nome', filter_var($category->name, FILTER_SANITIZE_STRING));

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'category added'];
            $this->logger->info('added', ['Category' => (array)$category]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'category not added'];
            $this->logger->error('not added', ['Category' => (array)$category]);
        }
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function find(string $codigo)
    {
        $pstmt = $this->db->prepare('SELECT * FROM categoria WHERE codigo = :codigo');

        $pstmt->bindValue(':codigo', $codigo);

        $pstmt->execute();

        $result = $pstmt->fetch(\PDO::FETCH_ASSOC);
        
        $pstmt->closeCursor();

        if ($result === false)
            return $result;

        return Json::encode($result);
    }

    public function update(object $category)
    {
        $sql = 'UPDATE categoria
                SET
                    nome = :nome
                WHERE codigo = :codigo';

        $pstmt = $this->db->prepare($sql);

        $pstmt->bindValue(':codigo', filter_var($category->code, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':nome', filter_var($category->name, FILTER_SANITIZE_STRING));

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'category updated'];
            $this->logger->info('updated', ['Category' => (array)$category]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'category not updated'];
            $this->logger->error('not updated', ['Category' => (array)$category]);
        }
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function delete(string $codigo)
    {
        $logCategoria = $this->find($codigo);

        $pstmt = $this->db->prepare('DELETE FROM categoria WHERE codigo = :codigo');

        $pstmt->bindValue(':codigo', $codigo);

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'category deleted'];
            $this->logger->info('deleted', ['Category' => (array)Json::decode($logCategoria)]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'category not deleted'];
            $this->logger->error('not deleted', ['Category' => (array)Json::decode($logCategoria)]);
        }

        $pstmt->closeCursor();

        return Json::encode($result);
    }

    private function getPathLogger(): string
    {
        $path = dirname(dirname(__FILE__));

        if (PHP_OS == 'Linux') 
            return ($path .= '/logs/categories.log');
        
        return ($path .= '\logs\categories.log');
    }

    public function checkName(string $codigo, string $nome)
    {
        $pstmt = $this->db->prepare('SELECT * FROM categoria WHERE codigo <> :codigo AND nome = :nome');

        $pstmt->bindValue(':codigo', filter_var($codigo, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':nome', filter_var($nome, FILTER_SANITIZE_STRING));

        $pstmt->execute();

        $result = $pstmt->fetch(\PDO::FETCH_ASSOC);
        
        $pstmt->closeCursor();

        if ($result === false)
            return false;

        return true;
    }
}