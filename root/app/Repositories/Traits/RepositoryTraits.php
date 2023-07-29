<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\DB;

trait RepositoryTraits
{
    abstract function buildQuery($model, $filters);

    /**
     * @param $where
     * @param  array  $relationship
     * @param  string  $columns
     * @return \Illuminate\Database\Eloquent\Model |null
     */
    public function firstByWhere($where, $relationship = [], $columns = "*")
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->first($columns);
        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }

    /**
     * @param $id
     * @param  array  $relationship
     * @param  string  $columns
     * @return \Illuminate\Database\Eloquent\Model |null
     */
    // public function firstById($id, $relationship = [], $columns = "*")
    public function firstById($id, $relationship = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->find($id);

        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }

    public function multiDelete($ids, $relationship = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->whereIn('id', $ids)->delete();

        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }

    /**
     * @param  array  $filters
     * @param  array  $relationship
     * @param  array  $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function firstByFilters($filters = [], $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->first();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param  array  $filters
     * @param  array  $relationship
     * @param  array  $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function firstByFiltersWithTrashed($filters = [], $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->withTrashed()->first();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param  array  $filters
     * @param  array  $relationship
     * @param  int  $limit
     * @param  int  $offset
     * @param  array  $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function getByFilters(
        $filters = [],
        $relationship = [],
        $limit = 10,
        $offset = 0,
        $orderBy = ['id' => 'DESC']
    ) {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildLimit($model, $limit, $offset);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->get();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param  array  $filters
     * @param  array  $relationship
     * @param  array  $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function getAllByFilters($filters = [], $relationship = [], $orderBy = [], $columns = "*")
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->get($columns);

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param  array  $filters
     * @param  int  $pageSize
     * @param  array  $relationship
     * @param  array  $orderBy
     * @return \Illuminate\Pagination\LengthAwarePaginator | null
     */
    public function paginateByFilters(
        $filters = [],
        $pageSize = 10,
        $relationship = [],
        $orderBy = ['id' => 'desc'],
        $columns = "*"
    ) {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->paginate($pageSize, $columns);

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * @param $model
     * @param  array  $orderBy
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildOrderBy($model, $orderBy = [])
    {
        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                if ($column && $direction) {
                    $model = $model->orderBy($column, $direction);
                }
            }
        }
        return $model;
    }

    /**
     * @param $model
     * @param  int  $limit
     * @param  int  $offset
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildLimit($model, $limit = 10, $offset = 0)
    {
        return $model->limit($limit)->offset($offset);
    }

    /**
     * @param $model
     * @param  array  $relationship
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildRelationShip($model, $relationship = [])
    {
        if (!empty($relationship)) {
            $model = $model->with($relationship);
        }

        return $model;
    }

    private function isValidKey($array, $key)
    {
        return array_key_exists($key, $array) && !is_null($array[$key]);
    }

    /**
     * @param $where
     * @param  array  $relationship
     * @param  string  $columns
     * @return \Illuminate\Database\Eloquent\Model |null
     */
    public function firstByWhereWithTrashed($where, $relationship = [], $columns = "*")
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->withTrashed()->first($columns);
        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }

    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->find($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function updateByFilters($filters = [], $columns = [])
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($filters);

        $model = $this->model;
        $model = $model->update($columns);

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Update multiple record
     *
     * @param array $data
     * @param array $conditions
     * @param array $value
     * @return mixed
     */
    public function updateMultiple($datas = [], $columnsKey = [], $columnsUpdate = [])
    {
        $model = $this->model;

        foreach ($columnsUpdate as $key => $columns) {
            unset($columnsUpdate[$key]);
            // Check model use softdelete
            if (in_array(LINK_SOFT_DELETE, class_uses($model))) {
                $columnsUpdate[$columns] = DB::raw("IF(deleted_at IS NULL, VALUES($columns), $columns)");
                continue;
            }
            $columnsUpdate[$columns] = DB::raw("VALUES($columns)");
        }

        $model = $model->upsert($datas, $columnsKey, $columnsUpdate);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Create multiple record
     */
    public function createMultiple($data = [])
    {
        $model = $this->model;
        $model = $model->insert($data);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function getColumnToArray($filters = [], $value = 'id', $key = null)
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $model->pluck($value, $key)->toArray();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Count Data By Filters
     *
     * @param array $filters
     * @param array $relationship
     * @param array $orderBy
     * @return void
     */
    public function countByFilters($filters = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $model->count();

        $this->resetModel();

        return $this->parserResult($model);
    }

    public function existsByFilters($filters = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $model->exists();

        $this->resetModel();

        return $this->parserResult($model);
    }
}
