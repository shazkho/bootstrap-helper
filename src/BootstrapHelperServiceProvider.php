<?php

namespace Shazkho\BootstrapHelper;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Str;

class BootstrapHelperServiceProvider extends ServiceProvider
{

    /**
     * Supported Blade Directives
     *
     * @var array
     */
    protected $directives = ['email','text'];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('bootstrap-helper', function ($app) {
            return new BootstrapHelper();
        });
        $this->app->alias('bootstrap-helper', BootstrapHelper::class);

        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $namespaces = [
                'bootstrap-helper' => get_class_methods(BootstrapHelper::class),
            ];

            foreach ($namespaces as $namespace => $methods) {
                foreach ($methods as $method) {
                    if (in_array($method, $this->directives)) {
                        $snakeMethod = Str::snake($method);
                        $directive = strtolower($namespace).'_'.$snakeMethod;

                        $bladeCompiler->directive($directive, function ($expression) use ($namespace, $method) {
                            return "<?php echo $namespace::$method($expression); ?>";
                        });
                    }
                }
            }
        });

    }
}
