<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaStopTimes
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('stop_times');
        $table->addColumn('trip_id', 'string');
        $table->addColumn('arrival_time', 'string', ['notnull' => false]);
        $table->addColumn('departure_time', 'string');
        $table->addColumn('stop_id', 'string');
        $table->addColumn('stop_sequence', 'integer');
        $table->addColumn('stop_headsign', 'string', ['notnull' => false]);
        $table->addColumn('pickup_type', 'integer', ['notnull' => false]);
        $table->addColumn('drop_off_type', 'integer', ['notnull' => false]);
        $table->addColumn('shape_dist_travelled', 'float', ['notnull' => false]);
        $table->addColumn('timepoint', 'integer', ['notnull' => false]);
        $table->addForeignKeyConstraint('trips', ['trip_id'], ['trip_id']);
        $table->addForeignKeyConstraint('stops', ['stop_id'], ['stop_id']);

        return $schema;
    }
}
