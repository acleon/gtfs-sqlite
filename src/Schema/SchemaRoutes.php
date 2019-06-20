<?php

namespace ACLeon\Schema;

use Doctrine\DBAL\Schema\Schema;

class SchemaRoutes
{
    public function __invoke(Schema $schema): Schema
    {
        $table = $schema->createTable('routes');
        $table->addColumn('route_id', 'string', ['notnull' => false]);
        $table->addColumn('agency_id', 'string');
        $table->addColumn('route_short_name', 'string');
        $table->addColumn('route_long_name', 'string');
        $table->addColumn('route_desc', 'string', ['notnull' => false]);
        $table->addColumn('route_type', 'integer');
        $table->addColumn('route_url', 'string');
        $table->addColumn('route_color', 'string');
        $table->addColumn('route_text_color', 'string', ['notnull' => false]);
        $table->addColumn('route_sort_order', 'integer', ['notnull' => false]);
        $table->setPrimaryKey(['route_id']);
        $table->addForeignKeyConstraint('agency', ['agency_id'], ['agency_id']);

        return $schema;
    }
}
