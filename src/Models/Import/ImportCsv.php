<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpUnused */

namespace App\Models\Import;

use App\Models\Import\Import\ImportFieldMap;
use App\Models\Import\Import\ImportWorkflow;
use App\Models\Import\Import\ImportWriter;
use App\Traits\Steps;
use Doctrine\Persistence\ObjectManager;
use Interpid\PhpLib\Logger\Memory;
use Port\Reader\ArrayReader;
use Port\Result;
use Port\Writer;

/**
 * Class ImportCsv
 * @package App\Models\Import
 */
class ImportCsv
{
    private ObjectManager $manager;
    private string $entityClass;
    private string $writerClass;
    private ?array $fieldMap = null;
    private ?string $delimiter = null;
    private ?array $writerOptions = [];
    private $loggerWrapper = null;
    private $logger = null;

    private ?Writer $writer = null;

    use Steps;

    /**
     * ImportCsv constructor.
     * @param ObjectManager $manager
     * @param string $entityClass
     * @param string $writerClass
     * @param array $writerOptions
     */
    public function __construct(ObjectManager $manager, string $entityClass, $writerClass = ImportWriter::class, $writerOptions = [])
    {
        $this->manager = $manager;
        $this->entityClass = $entityClass;
        $this->writerClass = $writerClass;
        $this->loggerWrapper = new Memory();
        $this->logger = $this->loggerWrapper->getLogger();
        $this->setWriterOptions($writerOptions);
    }

    /**
     * @param array|null $fieldMap
     * @return self
     */
    public function setFieldMap(?array $fieldMap): self
    {
        $this->fieldMap = $fieldMap;
        return $this;
    }

    /**
     * Set/Overwrites the current writerOptions
     * @param array|null $writerOptions
     */
    public function setWriterOptions(?array $writerOptions): void
    {
        $this->writerOptions = array_merge($this->writerOptions, $writerOptions);
    }

    /**
     * @param array|null $delimiter
     * @return self
     */
    public function setDelimiter(?array $delimiter): self
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return ImportWriter|null
     */
    public function getWriter(): ?Writer
    {
        return $this->writer;
    }

    /**
     * @param $filename
     * @param array $writerOptions
     * @param array $additionalSteps
     * @return Result
     */
    public function import($filename, $writerOptions = [], $additionalSteps = [])
    {
        $reader = ImportInstances::csvReader($filename, $this->delimiter);

        $headers = $reader->getColumnHeaders();
        $fieldMaps = new ImportFieldMap($this->fieldMap);
        $writerOptions['fieldMap'] = $fieldMaps->getFieldMap($headers);

        //merge the writer options with the CSV options
        $writerOptions = array_merge($this->writerOptions, $writerOptions);
        $this->writer = ImportInstances::entityWriter($this->manager, $this->entityClass, $this->writerClass, $writerOptions);

        $import = new ImportWorkflow($reader, $this->writer);
        $import->setSteps($this->getSteps());
        $import->addStep($additionalSteps);
        return $import->process();
    }

    /**
     * @param array $data
     * @param array $writerOptions
     * @param array $additionalSteps
     * @return Result
     */
    public function importData(array $data, $writerOptions = [], $additionalSteps = [])
    {
        $reader = new ArrayReader($data);

        //merge the writer options with the CSV options
        $writerOptions = array_merge($this->writerOptions, $writerOptions);
        $this->writer = ImportInstances::entityWriter($this->manager, $this->entityClass, $this->writerClass, $writerOptions);

        $import = new ImportWorkflow($reader, $this->writer);
        $import->setSteps($this->getSteps());
        $import->addStep($additionalSteps);
        return $import->process();
    }
}
