<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaTrips
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('trips');
        $table->addColumn('route_id', 'string');
        $table->addColumn('service_id', 'string');
        $table->addColumn('trip_id', 'string');
        $table->addColumn('trip_headsign', 'string', ['notnull' => false]);
        $table->addColumn('trip_short_name', 'string', ['notnull' => false]);
        $table->addColumn('direction_id', 'integer', ['notnull' => false]);
        $table->addColumn('block_id', 'string', ['notnull' => false]);
        $table->addColumn('shape_id', 'string', ['notnull' => false]);
        $table->addColumn('wheelchair_accessible', 'integer', ['notnull' => false]);
        $table->addColumn('bikes_allowed', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['trip_id']);
        $table->addForeignKeyConstraint('routes', ['route_id'], ['route_id']);

        return $schema;
    }
}
