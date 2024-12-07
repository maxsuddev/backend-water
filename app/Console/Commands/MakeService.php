<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name?}';

    protected $description = 'Create a new service class';

    public function handle(): void
    {
        $serviceName = $this->argument('name') ?? $this->ask('Please enter the name of the service');

        $path = app_path("Services/{$serviceName}.php");

        if (File::exists($path)) {
            $this->error("Service {$serviceName} already exists!");
            return;
        }

        if (!File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), 0755, true);
        }

        $serviceTemplate = $this->getServiceTemplate($serviceName);

        File::put($path, $serviceTemplate);

        $this->info("Service {$serviceName} created successfully!");
    }

    protected function getServiceTemplate($serviceName): string
    {
        return <<<EOT
<?php

namespace App\Services;


class {$serviceName} extends BaseService
{
}
EOT;
    }
}
