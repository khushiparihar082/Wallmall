<?php

namespace App\Controllers;

class Client extends BaseController
{
    public function vendor()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Vendors']),
			'page_title' => view('partials/page-title', ['title' => 'Vendors', 'li_1' => 'Vendors', 'li_2' => 'Vendors'])
		];
		return view('Client/vendor-list', $data);
	}
    public function media_type()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Media Type']),
			'page_title' => view('partials/page-title', ['title' => 'Media Type', 'li_1' => 'Media Type', 'li_2' => 'Media Type'])
		];
		return view('Client/Media-Type', $data);
	}
}