<?php

namespace Arbify\Providers;

use Arbify\Arb\ArbFormatter;
use Arbify\Contracts\Arb\ArbFormatter as ArbFormatterContract;
use Arbify\Arb\Exporter\ArbExporter;
use Arbify\Contracts\Arb\ArbExporter as ArbExporterContract;
use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        ArbExporterContract::class => ArbExporter::class,
        ArbFormatterContract::class => ArbFormatter::class,
    ];

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->extendBlade();
        if (env('APP_HTTPS') === true) {
            URL::forceScheme('https');
        }
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
