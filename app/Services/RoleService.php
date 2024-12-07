<?php

namespace App\Services;


use App\Models\Role;
use App\Repositories\Role\RoleRepository;
use App\Transformers\RoleTransformer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Prettus\Validator\Exceptions\ValidatorException;

class RoleService extends BaseService
{
    public function __construct(DatabaseManager $databaseManager, Logger $logger, RoleRepository $repository)
    {
        parent::__construct($databaseManager, $logger, $repository);

    }


    public function all()
    {
        return $this->formatData($this->repository->paginate(),'roles');
    }


    public function show(Role $role): array
    {
        $fractal = new Manager();
        $resource = new Item($role, new RoleTransformer());


        return $this->formatData($fractal->createData($resource)->toArray(),'role');
    }


    /**
     * @throws ValidatorException
     */
    public function create($data)
    {

        $data['slug'] = Str::slug($data['name']);


        $role =  $this->repository->skipPresenter()->create($data);


       $this->syncPermission($role, $data['permissions']);
       $role->refresh();
       return $this->show($role);
    }


    public function update(Role $role,$data)
    {
        $data['slug'] = Str::slug($data['name']);
        $role_updated = $this->repository->skipPresenter()->update($data,$role->id);

        $this->syncPermission($role_updated, $data['permissions']);
        return $this->show($role_updated);
    }

    public function delete(Role $user)
    {
        return $user->delete();
    }

    public function forceDelete(Role $user)
    {
        return $user->forceDelete();
    }


    protected function syncPermission(Role $role, array $permissions = [])
    {
      DB::table('permission_role')->where('role_id', $role->id)->delete();

      foreach ($permissions as $permission) {
          $role->permissions()->attach($permission);
      }
    }
}
