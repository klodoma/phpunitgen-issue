<?php

namespace App\Models\Import;

use App\Entity;
use App\Models\Import\Import\ImportProductWriter;
use App\Models\Import\Import\ImportWriter;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ImportFactory
 * @package App\Models\Import
 */
class ImportFactory
{
    /**
     * @param ObjectManager $manager
     * @param string $entity
     * @param array $writerOptions
     * @return ImportCsv
     */
    public static function csvImport(ObjectManager $manager, string $entity, array $writerOptions = [])
    {
        switch ($entity) {
            case Entity\ProductEntity::class:
                return new ImportCsv($manager, Entity\ProductEntity::class, ImportProductWriter::class, $writerOptions);
            default:
                return new ImportCsv($manager, $entity, ImportWriter::class, $writerOptions);
        }
    }
}
