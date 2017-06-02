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
			$view->with('airport_menu',array(
                                    'backlit_panel' => 'Backlit Panel',
                                    'luggage_trolley' => 'Luggage Trolley',
                                    'totems' => 'Totems',
                                    'video_wall' => 'Video Wall',
                                    'ambient_lit' => 'Ambient Lit',
                                    'sav'  => 'Sav',
                                    'backlit_flex' => 'backlit Flex',
                                    'banner' => 'Banner',
                                    'digital_screens' => 'Digital Screens',
                                    'scroller' => 'Scroller'
                             ));
			$view->with('auto_menu', array(  'auto_rikshaw' => 'Auto Rikshaw',
                        'e_rikshaw' => 'E Rikshaw',
                        'tricycle' => 'Tricycle'
                        ));
			$view->with('car_menu',array(  'micro_and_mini' => 'Micro And Mini',
                        'sedan' => 'Sedan',
                        'suv' => 'Suv',
                        'large' => 'Large'
                        ));
			$view->with('outdoor_menu',array(
                                'unipole' => 'Unipole',
                                'hoarding' => 'Hoarding',
                                'pole_kiosk' => 'Pole Kiosk',
                                'i_walker' => 'I Walker'
                            ));
			

	}
}