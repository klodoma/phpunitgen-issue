<?php

namespace Tests\Unit\Models\Import;

use App\Models\Import\ImportFactory;
use Tests\TestCase;

/**
 * Class ImportFactoryTest.
 *
 * @covers \App\Models\Import\ImportFactory
 */
class ImportFactoryTest extends TestCase
{
    /**
     * @var ImportFactory
     */
    protected $importFactory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->importFactory = new ImportFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->importFactory);
    }

    public function testCsvImport(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
