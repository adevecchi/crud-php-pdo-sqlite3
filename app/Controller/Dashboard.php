<?php
 
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends Controller
{
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}

    public function index()
    {
        $pageContent = file_get_contents('../templates/dashboard.html');

        $this->response->setContent($pageContent);
        $this->response->send();
    }
}