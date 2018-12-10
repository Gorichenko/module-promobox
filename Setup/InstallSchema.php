<?php

namespace VOID\Promobox\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

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
            ->addColumn('slide_id', Table::TYPE_INTEGER, null, [
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
            ->addColumn('widget_id', Table::TYPE_INTEGER, null, [
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

        if ($installer->tableExists('promobox_slide_widget')) {
            $connection->dropTable($setup->getTable('promobox_slide_widget'));
        }

        $table = $installer->getConnection()->newTable($setup->getTable('promobox_slide_widget'))
            ->addColumn('id', Table::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Id')
            ->addColumn('widget_id', Table::TYPE_INTEGER, 11, [], 'Widget Id')
            ->addColumn('slide_id', Table::TYPE_INTEGER, 11, [], 'Slide Id')
            ->addForeignKey(
                $installer->getFkName('promobox_slides', 'slide_id', 'promobox_slide_widget', 'slide_id'),
                'slide_id',
                $installer->getTable('promobox_slide_widget'),
                'slide_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_RESTRICT
            )
            ->addForeignKey(
                $installer->getFkName('promobox_widgets', 'widget_id', 'promobox_slide_widget', 'widget_id'),
                'slide_id',
                $installer->getTable('promobox_slide_widget'),
                'widget_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('Slides_Widgets');

        $connection->createTable($table);

        $installer->endSetup();
    }
}
