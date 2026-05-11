<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class GenerateRoutesFromControllers extends Command
{
    protected $signature = 'route:generate-auto';
    protected $description = 'Generate routes automatically from controllers';

    public function handle()
    {
        $controllersPath = app_path('Http/Controllers');

        $files = File::allFiles($controllersPath);

        $routes = "";

        foreach ($files as $file) {
            $class = $this->getClassFromFile($file->getPathname());

            if (!class_exists($class)) continue;

            $reflection = new ReflectionClass($class);

            if ($reflection->isAbstract()) continue;

            $name = $reflection->getShortName();
            $base = str_replace('Controller', '', $name);
            $uri = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $base));

            $routes .= "Route::resource('$uri', \\$class::class);\n";
        }

        File::put(base_path('routes/generated.php'), "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n" . $routes);

        $this->info('Routes generated successfully!');
    }

    private function getClassFromFile($path)
    {
        $content = file_get_contents($path);

        $namespace = '';
        if (preg_match('/namespace\s+(.+);/', $content, $m)) {
            $namespace = $m[1] . '\\';
        }

        if (preg_match('/class\s+(\w+)/', $content, $m)) {
            return $namespace . $m[1];
        }

        return null;
    }
}