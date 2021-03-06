<?php

namespace Consensus\Providers;

use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['system.expediente.list','system.expediente.create','system.expediente.edit'],
            'Consensus\Http\ViewComposers\ExpedienteComposer'
        );

        view()->composer(
            ['layouts.system'], 'Consensus\Http\ViewComposers\LayoutComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
