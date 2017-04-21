<?php

namespace App\Http\Composers;
use App\Mainaddtype;
use App\Generalsettings;

use Illuminate\Contracts\View\View;

Class MenuComposer
{
	public function compose(View $view)
	{
			
			$view->with('mediacats', Mainaddtype::orderBy('title')->get());
			$view->with('general', Generalsettings::first());
	}
}