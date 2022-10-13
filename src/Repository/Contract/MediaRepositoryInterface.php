<?php
namespace Blytd\MediaManager\Repository\Contract;

interface MediaRepositoryInterface
{
    public function findById($id);

    public function findByPath($path);

    public function create(array $item);

    public function createOrUpdate(array $data, $id);

    public function delete($id);

    public function deleteFileFormat($id, $fileFormat);
}
