<?php 

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

Use Slim\Views\Twig as View;

class AdminController extends Controller { 

	public function index($request, $response) {

		return $this->view->render($response, 'auth/admin/home.twig');

	}

}