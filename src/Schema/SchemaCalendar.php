<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaCalendar
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('calendar');
        $table->addColumn('service_id', 'string');
        $table->addColumn('monday', 'integer');
        $table->addColumn('tuesday', 'integer');
        $table->addColumn('wednesday', 'integer');
        $table->addColumn('thursday', 'integer');
        $table->addColumn('friday', 'integer');
        $table->addColumn('saturday', 'integer');
        $table->addColumn('sunday', 'integer');
        $table->addColumn('start_date', 'string');
        $table->addColumn('end_date', 'string');
        $table->addForeignKeyConstraint('trips', ['service_id'], ['service_id']);

        return $schema;
    }
}
