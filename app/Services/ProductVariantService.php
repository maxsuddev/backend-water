<?php

namespace App\Services;


use App\Models\ProductVariant;
use App\Repositories\ProductVariant\ProductVariantRepository;
use App\Transformers\ProductVariantTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class ProductVariantService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, ProductVariantRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);
    }

    public function all(): array
    {
        return $this->formatData($this->repository->paginate(), 'variants');
    }

    public function show(ProductVariant $variant): ?array
    {
        $fractal = new Manager();
        $resource = new Item($variant, new ProductVariantTransformer());
        return $this->formatData($fractal->createData($resource)->toArray(), 'variant');
    }

    /**
     * @throws \Throwable
     */
    public function store($data): ?array
    {
        return $this->runInTransaction(function () use ($data) {
            $variant = $this->repository->skipPresenter()->create($data);
            return $this->show($variant);
        });
    }

    /**
     * @throws \Throwable
     */
    public function update(ProductVariant $variant,  $data): ?array
    {
        return $this->runInTransaction(function () use ($data, $variant) {
            $edit_variant = $this->repository->skipPresenter()->update((array)$data, $variant->id);

            return $this->show($edit_variant);
        });
    }


    /**
     * @throws \Throwable
     */
    public function delete(ProductVariant $variant): ?bool
    {
        return $this->runInTransaction(function () use ($variant) {
            return $variant->delete();
        });
    }
}
