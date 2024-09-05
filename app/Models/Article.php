<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Article extends Model {
	
	protected $table = 'articles';

	protected $fillable = [
		'article_title',
		'article_description',
		'article_content',
		'article_date',
		'article_active',
		'category_name',
		'article_image',
		'user_id',
	];

	public function deleteSelectedArticle($id) {

		$this->where('article_id', $id)->update([
			'article_active' => 0,
		]);
		
	}

	public function updateSelectedArticle($id, $title, $date, $description, $content, $category, $image) {

		$this->where('article_id', $id)->update([
			'article_title' => $title,
			'article_date' => $date,
			'article_description' => $description,
			'article_content' => $content,
			'category_name' => $category,
			'article_image' => $image,
		]);
		
	}

}