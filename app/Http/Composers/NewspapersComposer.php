<?php

namespace App\Http\Composers;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\View\View;

Class NewspapersComposer
{
	public function compose(View $view)
	{
		$view->with('newspapers_list', DB::table('newspaperslists')
                ->orderBy('name', 'asc')
                ->get());
	}
}