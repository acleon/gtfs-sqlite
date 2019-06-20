<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaFareRules
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('fare_rules');
        $table->addColumn('fare_id', 'string');
        $table->addColumn('route_id', 'string', ['notnull' => false]);
        $table->addColumn('origin_id', 'string', ['notnull' => false]);
        $table->addColumn('destination_id', 'string', ['notnull' => false]);
        $table->addColumn('contains_id', 'string', ['notnull' => false]);
        $table->addForeignKeyConstraint('routes', ['route_id'], ['route_id']);

        return $schema;
    }
}
