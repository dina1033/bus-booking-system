<?php

namespace App\Service;
use App\Service\ServiceInterface;
use App\Repository\EloquentRepositoryInterface;

class BaseService implements ServiceInterface
{

    protected $repo;

    public function __construct(EloquentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }
    public function update(int $resource_id, array $data)
    {
        return $this->repo->update($resource_id, $data);
    }
    public function destroy(int $resource_id)
    {
        return $this->repo->deleteById($resource_id);
    }
    public function restore(int $resource_id)
    {
        return $this->repo->restoreById($resource_id);
    }
    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->repo->all($columns, $relations);
    }
    public function findById(
        int $resource_id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ) {
        return $this->repo->findById($resource_id);
    }
}
