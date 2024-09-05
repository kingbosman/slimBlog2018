<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Slide;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\Category;
use App\Models\Download;
use App\Models\Cv;

Use Slim\Views\Twig as View;

class HomeController extends Controller { 

	public function index($request, $response) {

		return $this->view->render($response, 'home.twig', [
			'slides' => Slide::where('slide_active', '1')->orderBy('slide_id', 'desc')->take(4)->get(),
			'testimonial' => Testimonial::where('testimonial_active', '1')->orderBy('testimonial_id', 'desc')->first(),
			'articles' => $this->getArticles(),
			'categories' => Category::all(),
		]);
		

	}

	public function downloadCv($request, $response) {

		Download::create([
			'download_file'  => 'resume',
			'download_ip' => $_SERVER['REMOTE_ADDR'],
			'download_browser' => $this->getBrowser(),
		]);

		return $this->view->render($response, 'cv.twig' , [
			'cv' => Cv::where('cv_active', 1)->orderBy('cv_id', 'desc')->first(),
		]);

	}

	private function getArticles() {

		$articles = Article::where('article_active', 1)
			->whereRaw('article_date <= UNIX_TIMESTAMP(CURDATE())')
			->orderBy('article_date', 'desc')
			->get();

		foreach ($articles as $key => $article) {

			$slug = str_replace(' ', '-', $article['article_title']);
			
			$articles[$key]['article_slug'] = preg_replace("/[^A-Za-z0-9\-\']/", '', $slug);

		}

		return $articles;
	
	}

	private function getBrowser(){
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
		   return 'Internet explorer';
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
		    return 'Internet explorer';
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
		   return 'Mozilla Firefox';
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		   return 'Google Chrome';
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		   return "Opera Mini";
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		   return "Opera";
		 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		   return "Safari";
		 else
		   return 'Something else';

	}

}