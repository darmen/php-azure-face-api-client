<?php

namespace Darmen\AzureFace;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class AzureFaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->assertConfiguration();
        $this->registerConfiguration();
    }

    private function assertConfiguration()
    {
        if (config('azure_face.endpoint') === null) {
            throw new InvalidArgumentException('Please provide Azure Cognitive Services endpoint.');
        }

        if (config('azure_face.subscription_key') === null) {
            throw new InvalidArgumentException('Please provide Azure Subscription Key.');
        }
    }

    /**
     * Creates instance of \Darmen\AzureFace\Configuration class and binds it into the app container.
     */
    private function registerConfiguration()
    {
        $this->app->instance(Configuration::class, new Configuration(
            config('azure_face.endpoint'),
            config('azure_face.subscription_key'),
        ));
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
