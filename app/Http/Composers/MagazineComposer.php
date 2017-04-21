<?php

namespace App\Http\Composers;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\View\View;

Class MagazineComposer
{
	public function compose(View $view)
	{
		$view->with('magazine_list', DB::table('magazinelists')
                ->orderBy('name', 'asc')
                ->get());
	}
}