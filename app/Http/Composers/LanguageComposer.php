<?php

namespace App\Http\Composers;
use App\Language;

use Illuminate\Contracts\View\View;

Class LanguageComposer
{
	public function compose(View $view)
	{
		$view->with('languages', Language::orderBy('name', 'asc')->get());
	}
}