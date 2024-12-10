<?php

namespace App\Services;


use App\Models\Size;
use App\Repositories\Size\SizeRepository;
use App\Transformers\SizeTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use stdClass;

class SizeService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, SizeRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);
    }

    public function all(): ?array
    {
        return $this->formatData($this->repository->paginate(), 'sizes');
    }

    public function show(Size $size): ?array
    {
        $fractal = new Manager();
        $resource = new Item($size, new SizeTransformer());
        return $this->formatData($fractal->createData($resource)->toArray(), 'size');
    }

    /**
     * @throws \Throwable
     */
    public function store(array $data): ?array
    {
        return $this->runInTransaction(function () use ($data) {
           $size = $this->repository->skipPresenter()->create($data);
           return $this->show($size);
        });
    }

    /**
     * @throws \Throwable
     */
    public function update(Size $size, array $data): ?array
    {
        return $this->runInTransaction(function () use ($size, $data) {
            $edit_sie = $this->repository->skipPresenter()->update($data, $size->id);
            return $this->show($edit_sie);
        });
    }

    /**
     * @throws \Throwable
     */
    public function delete(Size $size): ?bool
    {
        return $this->runInTransaction(function () use ($size) {
            $size->delete();
        });
    }
}
