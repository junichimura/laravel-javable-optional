<?php
namespace Junichimura\LaravelJavableOptional;

use Closure;
use Illuminate\Support\Optional;
use Illuminate\Support\ServiceProvider;

class JavableOptionalProvider extends ServiceProvider
{
    public function boot()
    {
        // java8 like Optional methods mix in to Optional Class
        Optional::mixin(new JavableOptionalMixinMethods());
    }

    public function register()
    {
    }
}