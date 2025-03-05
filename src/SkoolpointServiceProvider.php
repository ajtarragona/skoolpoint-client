<?php

namespace Ajtarragona\Skoolpoint;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\Blade;
//use Illuminate\Support\Facades\Schema;

class SkoolpointServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        

        //cargo rutas
        $this->loadRoutesFrom(__DIR__.'/routes.php');


        //publico configuracion de la api
        
        $this->publishes([
            __DIR__.'/Config/skoolpoint-api.php' => config_path('skoolpoint.php'),
        ], 'ajtarragona-skoolpoint-config');

        

        
        


       
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       	
        //defino facades
        $this->app->bind('skoolpoint', function(){
            return new \Ajtarragona\Skoolpoint\SkoolpointService;
        });
        

        //helpers
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once($filename);
        }


        
        if (file_exists(config_path('skoolpoint.php'))) {
            $this->mergeConfigFrom(config_path('skoolpoint.php'), 'skoolpoint');
        } else {
            $this->mergeConfigFrom(__DIR__.'/Config/skoolpoint-api.php', 'skoolpoint');
        }
        
    }
}
