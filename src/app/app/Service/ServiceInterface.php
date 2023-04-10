<?php

namespace App\Service;

interface ServiceInterface
{
    public function store(array $data);
    public function update(int $resource_id, array $data);
    public function destroy(int $resource_id);
    public function restore(int $resource_id);
    public function all(array $columns = ['*'], array $relations = []);
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    );
}
