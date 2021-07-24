<?php

namespace Darmen\AzureFace;

use Illuminate\Support\ServiceProvider;

class AzureFaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__ . '/../config/azure-face.php' => config_path('azure_face.php'),
        ]);
    }
}
