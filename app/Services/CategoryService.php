<?php

namespace App\Services;


use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class CategoryService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, CategoryRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }

    public function all(): ?array
    {
        return $this->formatData($this->repository->paginate(), 'categories');
    }

    public function show(Category $category): ?array
    {
        $fractal = new Manager();
        $resource = new Item($category, new CategoryTransformer());
        return $this->formatData($fractal->createData($resource)->toArray(), 'category');
    }

    /**
     * @throws \Throwable
     */
    public function store($data): ?array
    {
        return $this->runInTransaction(function () use ($data) {
            $category = $this->repository->skipPresenter()->create((array)$data);
            return $this->show($category);
        });
    }

    /**
     * @throws \Throwable
     */
    public function update(Category $category,  $data): ?array
    {
        return $this->runInTransaction(function () use ($data, $category) {
            $edit_category = $this->repository->skipPresenter()->update((array)$data, $category->id);

            return $this->show($edit_category);
        });
    }

    /**
     * @throws \Throwable
     */
    public function delete(Category $category): ?bool
    {
        return $this->runInTransaction(function () use ($category) {
            return $category->delete();
        });
    }
}
