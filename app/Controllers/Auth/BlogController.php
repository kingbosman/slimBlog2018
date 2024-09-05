<?php 

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Respect\Validation\Validator as v;

Use Slim\Views\Twig as View;

class BlogController extends Controller { 

	public function getBlogContent($request, $response) {

		return $this->view->render($response, 'auth/admin/blog/content.twig', [
			'articles' => Article::leftjoin('users', 'users.user_id', '=', 'articles.user_id')->where('article_active', '1')->get()
		]);

	}

	public function getBlogAdd($request, $response) {

		return $this->view->render($response, 'auth/admin/blog/add.twig', [
			'categories' => Category::get(),
		]);

	}

	public function postBlogAdd($request, $response) {

		$validation = $this->validator->validate($request, [
			'title' => v::notEmpty()->length(null, 255),
			'date' => v::notEmpty()->date("d/m/Y"),
			'description' => v::notEmpty()->length(null, 255),
			'content' => v::notEmpty(),
		]);

		if ($validation->failed()) {

			$this->flash->addMessage('danger', 'oops! Looks like something went terrible wrong...');

			return $response->withRedirect($this->router->pathFor('admin.blog.add'));

		}

		$date = str_replace('/', '-', $request->getParam('date'));
		$date = date('Y-m-d', strtotime($date));
		$date = strtotime($date);

		$article = Article::create([
			'article_title' => $request->getParam('title'),
			'article_date' => $date,
			'article_description' => $request->getParam('description'),
			'article_content' => $request->getParam('content'),
			'article_image' => $request->getParam('image'),
			'category_name' => implode(",", $request->getparam('categories')),
			'user_id' => $this->auth->user()->user_id,
		]);

		$this->flash->addMessage('success', 'Your article will be posted on: ' . date('d F Y', $date));

		return $response->withRedirect($this->router->pathFor('admin.blog.add'));

	}

	public function getBlogArticle($request, $response, $id) {

		return $this->view->render($response, 'auth/admin/blog/article.twig', [
			'article' => Article::leftjoin('users', 'users.user_id', '=', 'articles.user_id')->where('article_id', $id)->first(),
			'categories' => Category::get(),
		]);
		
	}

	public function deleteArticle($request, $response, $id) {

		$this->auth->article($id['id'])->deleteSelectedArticle($id['id']);

		$this->flash->addMessage('warning', 'The selected article is removed');

		return $response->withredirect($this->router->pathFor('admin.blog.content'));
		
	}

	public function updateArticle($request, $response, $id) {

		$date = str_replace('/', '-', $request->getParam('date'));
		$date = date('Y-m-d', strtotime($date));
		$date = strtotime($date);
		$category = implode(",", $request->getparam('categories'));

		$this->auth->article($id['id'])->updateSelectedArticle(
			$id['id'], 
			$request->getParam('title'), 
			$date, 
			$request->getParam('description'), 
			$request->getParam('content'), 
			$category,
			$request->getParam('image')
		);

		$this->flash->addMessage('success', 'The selected article is updated');

		return $response->withredirect($this->router->pathFor('admin.blog.content'));
		
	}

	public function showPosts($request, $response){	

		$articles = Article::where('article_active', 1)
			->whereRaw('article_date <= UNIX_TIMESTAMP(CURDATE())')
			->orderBy('article_date', 'desc')
			->get();

		foreach ($articles as $key => $article) {

			$slug = str_replace(' ', '-', $article['article_title']);
			
			$articles[$key]['article_slug'] = preg_replace("/[^A-Za-z0-9\-\']/", '', $slug);

		}
		
		return $this->view->render($response, 'blog.twig', [
			'articles' => $articles,
			'categories' => Category::get(),
		]);

	}

	public function showPostsFiltered($request, $response, $args){	

		$articles = Article::where('article_active', 1)
			->where('category_name', ucfirst($args['name']))
			->whereRaw('article_date <= UNIX_TIMESTAMP(CURDATE())')
			->orderBy('article_date', 'desc')
			->get();

		foreach ($articles as $key => $article) {

			$slug = str_replace(' ', '-', $article['article_title']);
			
			$articles[$key]['article_slug'] = preg_replace("/[^A-Za-z0-9\-\']/", '', $slug);

		}
		
		return $this->view->render($response, 'blog.twig', [
			'articles' => $articles,
			'categories' => Category::get(),
		]);

	}

	public function showArticle($request, $response, $args){	

		$articles = Article::where('article_active', 1)
			->whereRaw('article_date <= UNIX_TIMESTAMP(CURDATE())')
			->orderBy('article_date', 'desc')
			->get();

		foreach ($articles as $key => $article) {

			$slug = str_replace(' ', '-', $article['article_title']);
			
			$articles[$key]['article_slug'] = preg_replace("/[^A-Za-z0-9\-\']/", '', $slug);

		}

		return $this->view->render($response, 'article.twig', [
			'article' => Article::where('article_active', 1)
				->where('article_id', $args['id'])
				->whereRaw('article_date <= UNIX_TIMESTAMP(CURDATE())')
				->take(1)
				->get()[0],
			'articles' => $articles,
			'categories' => Category::get(),
			'args' => $args,
		]);

	}

}