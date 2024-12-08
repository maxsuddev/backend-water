<?php

namespace App\Services;


use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Transformers\ProductTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class ProductService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, ProductRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }

    public function all(): ?array
    {
        return $this->formatData($this->repository->paginate(), 'products');
    }

    public function show(Product $product): ?array
    {
        $fractal = new Manager();
        $resource = new Item($product, new ProductTransformer());
        return $this->formatData($fractal->createData($resource)->toArray(), 'product');
    }

    /**
     * @throws \Throwable
     */
    public function store($data): ?array
    {
        return $this->runInTransaction(function () use ($data) {
            $product = $this->repository->skipPresenter()->create($data);
            return $this->show($product);
        });
    }

    /**
     * @throws \Throwable
     */
    public function update(Product $product,  $data): ?array
    {
        return $this->runInTransaction(function () use ($data, $product) {
            $edit_product = $this->repository->skipPresenter()->update((array)$data, $product->id);

            return $this->show($edit_product);
        });
    }

    /**
     * @throws \Throwable
     */
    public function delete(Product $product): ?bool
    {
        return $this->runInTransaction(function () use ($product) {
            return $product->delete();
        });
    }
}
