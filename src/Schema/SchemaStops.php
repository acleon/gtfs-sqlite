<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaStops
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('stops');
        $table->addColumn('stop_id', 'string', ['notnull' => false]);
        $table->addColumn('stop_code', 'string', ['notnull' => false]);
        $table->addColumn('stop_name', 'string');
        $table->addColumn('stop_desc', 'string', ['notnull' => false]);
        $table->addColumn('stop_lat', 'float');
        $table->addColumn('stop_lon', 'float');
        $table->addColumn('zone_id', 'string', ['notnull' => false]);
        $table->addColumn('stop_url', 'string', ['notnull' => false]);
        $table->addColumn('location_type', 'integer', ['notnull' => false]);
        $table->addColumn('parent_station', 'string', ['notnull' => false]);
        $table->addColumn('stop_timezone', 'string', ['notnull' => false]);
        $table->addColumn('wheelchair_boarding', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['stop_id']);

        return $schema;
    }
}
