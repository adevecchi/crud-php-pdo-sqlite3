<?php
 
namespace App\Controller;

use App\Helper\Json;
use App\Model\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Categories extends Controller
{
    private $category;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);

        $this->category = new Category();
    }

    public function index()
    {
        $pageContent = file_get_contents('../templates/category/categories.html');

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function list()
    {
        $result = $this->category->list();

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function new()
    {
        $pageContent = file_get_contents('../templates/category/addCategory.html');

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function add()
    {   
        $input = Json::decode($this->request->getContent());

        if ($this->category->find($input->code) === false && $this->category->checkName($input->code, $input->name) === false)
            $result = $this->category->add($input);
        else
            $result = Json::encode(['status'=>'Exists', 'msg'=>'category already exists']);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function edit(string $codigo)
    {
        $category = $this->category->find($codigo);

        if ($category === false) {
            $this->response = new \Symfony\Component\HttpFoundation\RedirectResponse('/404');
            $this->response->send();
            return;
        }
        
        $category = Json::decode($category);

        $pageContent = file_get_contents('../templates/category/editCategory.html');

        $pageContent = str_replace(['{name}','{code}'], [$category->nome, $category->codigo], $pageContent);

        $this->response->setContent($pageContent);
        $this->response->send();
    }

    public function update()
    {
        $input = Json::decode($this->request->getContent());

        if ($this->category->checkName($input->code, $input->name) === false)
            $result = $this->category->update($input);
        else
            $result = Json::encode(['status'=>'Exists', 'msg'=>'category already exists']);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }

    public function delete(string $codigo)
    {
        $category = $this->category->find($codigo);

        if ($category === false) {
            $this->response = new \Symfony\Component\HttpFoundation\RedirectResponse('/404');
            $this->response->send();
            return;
        }

        $result = $this->category->delete($codigo);

        $this->response->setContent($result);
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->send();
    }
}