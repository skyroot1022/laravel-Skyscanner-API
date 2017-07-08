<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SkyScanner extends Facade
{

	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'sky.utils';
	}

}