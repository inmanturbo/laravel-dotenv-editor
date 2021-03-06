<?php

namespace Quickweb\DotenvEditor;

use Illuminate\Support\ServiceProvider;

class DotenvEditorServiceProvider extends ServiceProvider
{
    /**
     * Provider boot
     *
     * @return null
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../resources/views' => resource_path('views/vendor/dotenv-editor'),
            ],
            'views'
        );

        $this->publishes(
            [
                __DIR__ . '/../config/dotenveditor.php' => config_path('dotenveditor.php'),
                __DIR__ . '/../config/setup.php' => config_path('setup.php'),
                __DIR__ . '/../config/setupeditor.php' => config_path('setupeditor.php'),
                __DIR__ . '/../config/setup.txt' => config_path('setup.txt'),
            ],
            'config'
        );

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dotenv-editor');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'dotenv-editor');
    }

    /**
     * Provider register
     *
     * @return null
     */
    public function register()
    {
        $this->app->bind(
            'quickweb-dotenveditor',
            function () {
                return new DotenvEditor();
            }
        );

        $this->mergeConfigFrom(__DIR__ . '/../config/dotenveditor.php', 'dotenveditor');
        $this->mergeConfigFrom(__DIR__ . '/../config/setup.php', 'setup');
        $this->mergeConfigFrom(__DIR__ . '/../config/setupeditor.php', 'setupeditor');
        //copy(__DIR__ . '/../config/setup.stub', base_path('config/setup.stub'));
    }
}
