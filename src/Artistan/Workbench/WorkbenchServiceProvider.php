<?php namespace Artistan\Workbench;

use Illuminate\Support\ServiceProvider;
use Artistan\Workbench\Commands\InstallCommand;
use Artistan\Workbench\Commands\DevelopCommand;
use Artistan\Workbench\Commands\LaunchCommand;

class WorkbenchServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('artistan/workbench');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerCommands();
        // register classes...
        $this->app->bind('Artistan\Workbench\Helpers\BenchHelper',
            'Artistan\Workbench\Helpers\BenchHelper');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

    private function registerCommands()
    {
        try{
            /**
             *
             */
            $this->app['artistan.workbench.install'] = $this->app->share(function($app)
            {
                return new InstallCommand();
            });
            $this->commands('artistan.workbench.install');
            /**
             *
             */
            $this->app['artistan.workbench.develop'] = $this->app->share(function($app)
            {
                return new DevelopCommand();
            });
            $this->commands('artistan.workbench.develop');
            /**
             *
             */
            $this->app['artistan.workbench.launch'] = $this->app->share(function($app)
            {
                return new LaunchCommand();
            });
            $this->commands('artistan.workbench.launch');
        } catch(\Exception $e) {
            echo "Exception in registerCommands.\nDid you forget to set the 'use' statement?\n";
            echo $e->getMessage()."\n";
        }
    }
}
