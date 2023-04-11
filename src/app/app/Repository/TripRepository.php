<?php

namespace App\Repository;

use App\Models\Trip;
use App\Repository\TripRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TripRepository extends BaseRepository implements TripRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Trip $model)
    {
        $this->model = $model;
    }
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->Where('is_active',true)->where('departure_time','>=',Carbon::now()->toDateTimeString())->get($columns);
    }

    public function findById(int $modelId,array $columns = ['*'],array $relations = [],array $appends = []): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends)
        ->Where('is_active',true)->where('departure_time','>=',Carbon::now()->toDateTimeString())->first();
    }


}
