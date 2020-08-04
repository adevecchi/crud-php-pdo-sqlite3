<?php
 
namespace App\Controller;

use App\Helper\Json;
use App\Model\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Products extends Controller
{
    private $product;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);

        $this->product = new Product();
    }

    public function index()
    {
        $pageContent = file_get_contents('../templates/product/products.html');

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function list()
    {
        $result = $this->product->list();

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function new()
    {
        $pageContent = file_get_contents('../templates/product/addProduct.html');

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function add()
    {
        $input = Json::decode($this->request->getContent());

        if ($this->product->find($input->sku) === false)
            $result = $this->product->add($input);
        else
            $result = Json::encode(['status'=>'Exists', 'msg'=>'product already exists']);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function edit(string $sku)
    {
        $p = $this->product->find($sku);

        if ($p === false) {
            $this->response = new \Symfony\Component\HttpFoundation\RedirectResponse('/404');
            $this->response->send();
            return;
        }
        
        $p = Json::decode($p);

        $pageContent = file_get_contents('../templates/product/editProduct.html');

        $placehold = ['{script}', '{sku}', '{name}', '{price}', '{quantity}', '{description}'];

        $categoria = 'var categoria = "' . $p->categoria . '"';

        $values = [$categoria, $p->sku, $p->nome, $p->preco, $p->quantidade, $p->descricao];

        $pageContent = str_replace($placehold, $values, $pageContent);

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function update()
    {
        $input = Json::decode($this->request->getContent());

        $result = $this->product->update($input);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function delete(string $sku)
    {
        $product = $this->product->find($sku);

        if ($product === false) {
            $this->response = new \Symfony\Component\HttpFoundation\RedirectResponse('/404');
            $this->response->send();
            return;
        }

        $result = $this->product->delete($sku);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }
}