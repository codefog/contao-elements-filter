<?php

namespace Codefog\ElementsFilterBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;

class MultiColumnWizardMigration extends AbstractMigration
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (!$schemaManager->tablesExist(['tl_article'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_article');

        if (!isset($columns['elementsfilter_filters'])) {
            return false;
        }

        return $this->connection->fetchOne('SELECT id FROM tl_article WHERE elementsFilter_filters LIKE ? LIMIT 1', ['%elementsFilter_filters_%']) !== false;
    }

    public function run(): MigrationResult
    {
        $records = $this->connection->fetchAllAssociative('SELECT id, elementsFilter_filters FROM tl_article');

        foreach ($records as $record) {
            $oldFilters = StringUtil::deserialize($record['elementsFilter_filters']);

            if (!is_array($oldFilters) || [] === $oldFilters) {
                continue;
            }

            $newFilters = [];

            foreach ($oldFilters as $values) {
                $newFilter = [];

                foreach ($values as $key => $value) {
                    $newFilter[str_replace('elementsFilter_filters_', '', $key)] = $value;
                }

                $newFilters[] = $newFilter;
            }

            $this->connection->update('tl_article', ['elementsFilter_filters' => serialize($newFilters)], ['id' => $record['id']]);
        }

        return $this->createResult(true);
    }
}
