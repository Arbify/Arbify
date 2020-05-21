<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->extendBlade();
    }

    private function extendBlade(): void
    {
        Blade::directive('formsection', function (string $title) {
            return "<h2 class=\"mb-4 text-center\">\n\t<?php echo $title; ?>\n</h2>\n"
                . "<div class=\"col-md-8 offset-md-2\">\n\t<div class=\"card card-body\">";
        });

        Blade::directive('endformsection', function () {
            return "\t</div>\n</div>";
        });
    }
}
