<?php

namespace VOID\Promobox\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $connection = $installer->getConnection();

        $installer->startSetup();

        if ($installer->tableExists('promobox_slides')) {
            $connection->dropTable($setup->getTable('promobox_slides'));
        }

        $table = $installer->getConnection()->newTable($setup->getTable('promobox_slides'))
            ->addColumn('slide_id', Table::TYPE_SMALLINT, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Slide Id')
            ->addColumn('slide_title', Table::TYPE_TEXT, 255, [], 'Title')
            ->addColumn('background_image', Table::TYPE_TEXT, 255, [], 'Background Image')
            ->addColumn('slide_text', Table::TYPE_TEXT, '64k', [], 'Slide Text')
            ->setComment('Promobox Slides Content');

        $connection->createTable($table);

        if ($installer->tableExists('promobox_widgets')) {
            $connection->dropTable($setup->getTable('promobox_widgets'));
        }

        $table = $installer->getConnection()->newTable($setup->getTable('promobox_widgets'))
            ->addColumn('widget_id', Table::TYPE_SMALLINT, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Widget Id')
            ->addColumn('widget_title', Table::TYPE_TEXT, 255, [], 'Title')
            ->addColumn('widget_slides', Table::TYPE_TEXT, 255, [], 'Widget Slides')
            ->addColumn('show_slide_text', Table::TYPE_BOOLEAN, null, ['default' => false], 'Show slide text')
            ->setComment('Promobox Widgets');

        $connection->createTable($table);

        if ($installer->tableExists('promobox_widget_slide')) {
            $connection->dropTable($setup->getTable('promobox_widget_slide'));
        }

        $table = $installer->getConnection()->newTable($setup->getTable('promobox_widget_slide'))
            ->addColumn('id', Table::TYPE_SMALLINT, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Id')
            ->addColumn('widget_id', Table::TYPE_SMALLINT, null, ['unsigned' => true], 'Widget Id')
            ->addColumn('slide_id', Table::TYPE_SMALLINT, null, ['unsigned' => true], 'Slide Id')
            ->addForeignKey(
                $installer->getFkName('promobox_widget_slide', 'slide_id', 'promobox_slides', 'slide_id'),
                'slide_id',
                $installer->getTable('promobox_slides'),
                'slide_id',
                Table::ACTION_NO_ACTION
            )
            ->addForeignKey(
                $installer->getFkName('promobox_widget_slide', 'widget_id', 'promobox_widgets', 'widget_id'),
                'widget_id',
                $installer->getTable('promobox_widgets'),
                'widget_id',
                Table::ACTION_CASCADE
            )
            ->setComment('Slides_Widgets');

        $connection->createTable($table);

        $installer->endSetup();
    }
}
