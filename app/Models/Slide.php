<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\model;

class Slide extends Model {
	
	protected $table = 'slides';

	protected $fillable = [
		'slide_intro',
		'slide_content',
		'slide_active',
		'slide_image',
	];

	public function deleteSelectedSlide($id) {

		$this->where('slide_id', $id)->update([
			'slide_active' => 0,
		]);
		
	}

	public function updateSelectedSlide($id, $intro, $content, $image) {

		$this->where('slide_id', $id)->update([
			'slide_intro' => $intro,
			'slide_content' => $content,
			'slide_image' => $image,
		]);
		
	}

}