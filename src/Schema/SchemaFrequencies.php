<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaFrequencies
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('frequencies');
        $table->addColumn('trip_id', 'string');
        $table->addColumn('start_time', 'string');
        $table->addColumn('end_time', 'string');
        $table->addColumn('headway_secs', 'integer');
        $table->addColumn('exact_times', 'integer', ['notnull' => false]);
        $table->addForeignKeyConstraint('trips', ['trip_id'], ['trip_id']);

        return $schema;
    }
}
