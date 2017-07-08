<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\BasicFormBuilder;
use App\Extensions\FormBuilder;
use App\Extensions\HorizontalFormBuilder;

class ExtensionServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {

	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->registerFormBuilder();
		$this->registerBootForms();
		$this->registerBasicFormBuilder();
	}

	private function registerBootForms() {
		$this->app['bootform.horizontal'] = $this->app->share( function ( $app ) {
			return new HorizontalFormBuilder( $app['adamwathan.form'] );
		} );

	}

	protected function registerBasicFormBuilder() {
		$this->app['bootform.basic'] = $this->app->share( function ( $app ) {
			return new BasicFormBuilder( $app['adamwathan.form'] );
		} );
	}

	protected function registerFormBuilder()
	{
		$this->app['adamwathan.form'] = $this->app->share(function ($app) {
			$formBuilder = new FormBuilder();
			$formBuilder->setErrorStore($app['adamwathan.form.errorstore']);
			$formBuilder->setOldInputProvider($app['adamwathan.form.oldinput']);
			$formBuilder->setToken($app['session.store']->getToken());

			return $formBuilder;
		});
	}


}