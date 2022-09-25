<?php

namespace Blytd\MediaManager\Repository\MongoDB;

use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

class BaseRepository
{
    /**
     * @var Model $model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = new $model();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model
            ->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $item = $this->findById($id);
        if (isset($item->id)){
            $item->update($data);
        }
        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $item = $this->findById($id);
        if (isset($item->id)){
            $item->delete();
        }
        return $item;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model
            ->where('_id', $id)
            ->first();
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function createOrUpdate(array $data, $id)
    {
        if (!isset($id)){
            return $this->create($data);
        }
        return $this->update($data, $id);
    }

    public function getObjectId($id=null): ObjectId
    {
        return new ObjectId($id);
    }
}
