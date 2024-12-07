<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRPTClasses extends Command
{
    protected $signature = 'make:rpt {name}';
    protected $description = 'Create Repository, Presenter, and Transformer classes';

    public function handle(): void
    {
        $name = $this->argument('name');

        $this->createRepository($name);
        $this->createPresenter($name);
        $this->createTransformer($name);

        $this->info("Repository, Presenter, and Transformer for {$name} created successfully!");
    }

    private function createRepository($name): void
    {
        $path = app_path("Repositories/{$name}/{$name}Repository.php");
        $interfacePath = app_path("Repositories/{$name}/{$name}RepositoryInterface.php");

        $stub = <<<EOT
<?php

namespace App\Repositories\\{$name};

use App\Models\\{$name};
use App\Presenters\\{$name}Presenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
{
    public function model(): string
    {
        return {$name}::class;
    }

    public function boot(): void
    {
        \$this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(): string
    {
        return {$name}Presenter::class;
    }

    protected \$fieldSearchable = [

    ];
}
EOT;

        $interfaceStub = <<<EOT
<?php

namespace App\Repositories\\{$name};

interface {$name}RepositoryInterface
{
    //
}
EOT;

        $this->createFile($path, $stub);
        $this->createFile($interfacePath, $interfaceStub);
    }

    private function createPresenter($name): void
    {
        $path = app_path("Presenters/{$name}Presenter.php");

        $stub = <<<EOT
<?php

namespace App\Presenters;

use App\Transformers\\{$name}Transformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class {$name}Presenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new {$name}Transformer();
    }
}
EOT;

        $this->createFile($path, $stub);
    }

    private function createTransformer($name): void
    {
        $path = app_path("Transformers/{$name}Transformer.php");

        $stub = <<<EOT
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\\{$name};

class {$name}Transformer extends TransformerAbstract
{
    public function transform({$name} \$model): array
    {
        return [

        ];
    }
}
EOT;

        $this->createFile($path, $stub);
    }

    private function createFile($path, $content): void
    {
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, $content);
    }
}
