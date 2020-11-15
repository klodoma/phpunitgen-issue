<?php

namespace Tests\Unit\Models\Import;

use App\Models\Import\ImportCsv;
use Doctrine\Persistence\ObjectManager;
use Mockery;
use Mockery\Mock;
use Port\Writer;
use ReflectionClass;
use Tests\TestCase;

/**
 * Class ImportCsvTest.
 *
 * @covers \App\Models\Import\ImportCsv
 */
class ImportCsvTest extends TestCase
{
    /**
     * @var ImportCsv
     */
    protected $importCsv;

    /**
     * @var ObjectManager|Mock
     */
    protected $manager;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $writerClass;

    /**
     * @var array
     */
    protected $writerOptions;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = Mockery::mock(ObjectManager::class);
        $this->entityClass = '42';
        $this->writerClass = '42';
        $this->writerOptions = [];
        $this->importCsv = new ImportCsv($this->manager, $this->entityClass, $this->writerClass, $this->writerOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->importCsv);
        unset($this->manager);
        unset($this->entityClass);
        unset($this->writerClass);
        unset($this->writerOptions);
    }

    public function testSetFieldMap(): void
    {
        $expected = [];
        $property = (new ReflectionClass(ImportCsv::class))
            ->getProperty('fieldMap');
        $property->setAccessible(true);
        $this->importCsv->setFieldMap($expected);
        $this->assertSame($expected, $property->getValue($this->importCsv));
    }

    public function testSetWriterOptions(): void
    {
        $expected = [];
        $property = (new ReflectionClass(ImportCsv::class))
            ->getProperty('writerOptions');
        $property->setAccessible(true);
        $this->importCsv->setWriterOptions($expected);
        $this->assertSame($expected, $property->getValue($this->importCsv));
    }

    public function testSetDelimiter(): void
    {
        $expected = [];
        $property = (new ReflectionClass(ImportCsv::class))
            ->getProperty('delimiter');
        $property->setAccessible(true);
        $this->importCsv->setDelimiter($expected);
        $this->assertSame($expected, $property->getValue($this->importCsv));
    }

    public function testGetWriter(): void
    {
        $expected = Mockery::mock(Writer::class);
        $property = (new ReflectionClass(ImportCsv::class))
            ->getProperty('writer');
        $property->setAccessible(true);
        $property->setValue($this->importCsv, $expected);
        $this->assertSame($expected, $this->importCsv->getWriter());
    }

    public function testImport(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testImportData(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
