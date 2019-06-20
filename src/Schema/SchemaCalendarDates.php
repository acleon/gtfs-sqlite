<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaCalendarDates
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('calendar_dates');
        $table->addColumn('service_id', 'string');
        $table->addColumn('date', 'string');
        $table->addColumn('exception_type', 'integer');
        $table->addForeignKeyConstraint('trips', ['service_id'], ['service_id']);

        return $schema;
    }
}
