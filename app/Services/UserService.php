<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, UserRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all(): ?array
    {
        return $this->formatData($this->repository->paginate(),'users');
    }


    public function show(User $user): ?array
    {
        $fractal = new Manager();
        $resource = new Item($user, new UserTransformer());

        return $this->formatData($fractal->createData($resource)->toArray(),'user');
    }


    /**
     * @throws ValidatorException
     * @throws \Throwable
     */
    public function create($data): ?array
    {
        return $this->runInTransaction(function () use ($data) {
        $user =  $this->repository->skipPresenter()->create($data);
        $this->syncRole($user, $data['roles']);
        $user->refresh();
       return $this->show($user);
        });


    }


    /**
     * @throws ValidatorException
     * @throws \Throwable
     */
    public function update(User $user, $data): ?array
    {

        return $this->runInTransaction(function () use ($user, $data) {
        $edit_user = $this->repository->skipPresenter()->update($data, $user->id);
        $this->syncRole($edit_user, $data['roles']);
        return $this->show($edit_user);
        });

    }

    /**
     * @throws \Throwable
     */
    public function restore($id): ?array
    {
        $user = User::withTrashed()->findOrFail($id);
        return $this->runInTransaction(function () use ($user) {
        $user->restore();
        return $this->show($user);
        });

    }

    /**
     * @throws \Throwable
     */
    public function delete(User $user): ?bool
    {
       return $this->runInTransaction(function () use ($user) {
        return $user->delete();
        });
    }

    public function forceDelete(User $user): ?bool
    {
        DB::table('role_user')->where('user_id', $user->id)->delete();
        return $user->forceDelete();
    }


    protected function syncRole(User $user, array $roles = []): void
    {
        DB::table('role_user')->where('user_id', $user->id)->delete();

        foreach ($roles as $role) {
            $user->roles()->attach($role);
        }
    }
}
