<?php

namespace App\Model;

use App\Helper\Json;
use App\Database\SQLite;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Product
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
        $pstmt = $this->db->prepare('SELECT nome, sku, preco, quantidade, categoria FROM produto');

        $pstmt->execute();

        $result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function add(object $product)
    {
        $sql = 'INSERT INTO produto (
                    nome,
                    sku,
                    preco,
                    descricao,
                    quantidade,
                    categoria
                )
                VALUES (
                    :nome,
                    :sku,
                    :preco,
                    :descricao,
                    :quantidade,
                    :categoria
                )';

        $pstmt = $this->db->prepare($sql);

        $pstmt->bindValue(':nome', filter_var($product->name, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':sku', filter_var($product->sku, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':preco', filter_var($product->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $pstmt->bindValue(':descricao', filter_var($product->description, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':quantidade', filter_var($product->quantity, FILTER_SANITIZE_NUMBER_INT));
        $pstmt->bindValue(':categoria', filter_var(($product->category ?? ''), FILTER_SANITIZE_STRING));

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'product updated'];
            $this->logger->info('added', ['Product' => (array)$product]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'product not updated'];
            $this->logger->error('not added', ['Product' => (array)$product]);
        }
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function find(string $sku)
    {
        $pstmt = $this->db->prepare('SELECT * FROM produto WHERE sku = :sku');

        $pstmt->bindValue(':sku', $sku);

        $pstmt->execute();

        $result = $pstmt->fetch(\PDO::FETCH_ASSOC);
        
        $pstmt->closeCursor();

        if ($result === false)
            return $result;

        return Json::encode($result);
    }

    public function update(object $product)
    {
        $sql = 'UPDATE produto
                SET
                    nome = :nome,
                    preco = :preco,
                    descricao = :descricao,
                    quantidade = :quantidade,
                    categoria = :categoria
                WHERE sku = :sku';

        $pstmt = $this->db->prepare($sql);

        $pstmt->bindValue(':nome', filter_var($product->name, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':preco', filter_var($product->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $pstmt->bindValue(':descricao', filter_var($product->description, FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':quantidade', filter_var($product->quantity, FILTER_SANITIZE_NUMBER_INT));
        $pstmt->bindValue(':categoria', filter_var(($product->category ?? ''), FILTER_SANITIZE_STRING));
        $pstmt->bindValue(':sku', $product->sku);

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'product updated'];
            $this->logger->info('updated', ['Product' => (array)$product]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'product not updated'];
            $this->logger->error('not updated', ['Product' => (array)$product]);
        }
        
        $pstmt->closeCursor();

        return Json::encode($result);
    }

    public function delete(string $sku)
    {
        $logProduto = $this->find($sku);

        $pstmt = $this->db->prepare('DELETE FROM produto WHERE sku = :sku');

        $pstmt->bindValue(':sku', $sku);

        $pstmt->execute();

        if ($pstmt->rowCount() == 1) {
            $result = ['status'=>'Ok', 'msg'=>'product deleted'];
            $this->logger->info('deleted', ['Product' => (array)Json::decode($logProduto)]);
        }
        else {
            $result = ['status'=>'Error', 'msg'=>'product not deleted'];
            $this->logger->error('not deleted', ['Product' => (array)Json::decode($logProduto)]);
        }

        $pstmt->closeCursor();

        return Json::encode($result);
    }

    private function getPathLogger(): string
    {
        $path = dirname(dirname(__FILE__));

        if (PHP_OS == 'Linux') 
            return ($path .= '/logs/products.log');
        
        return ($path .= '\logs\products.log');
    }
}