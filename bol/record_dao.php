<?php

/**
 * Data Access Object for `skeleton_record` table.
 *
 * @package ow.plugin.skeleton.bol
 * @since 1.0
 */
class SKELETON_BOL_RecordDao extends OW_BaseDao
{

    /**
     * Singleton instance.
     *
     * @var SKELETON_BOL_RecordDao
     */
    private static $classInstance;

    /**
     * Returns an instance of class (singleton pattern implementation).
     *
     * @return SKELETON_BOL_RecordDao
     */
    public static function getInstance()
    {
        if ( self::$classInstance === null )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    /**
     * @see OW_BaseDao::getDtoClassName()
     *
     */
    public function getDtoClassName()
    {
        return 'SKELETON_BOL_Record';
    }

    /**
     * @see OW_BaseDao::getTableName()
     *
     */
    public function getTableName()
    {
        return OW_DB_PREFIX . 'skeleton_record';
    }

    /**
     * 
     * @return array
     */
    public function findListOrderedByText()
    {
        $example = new OW_Example();
        $example->setOrder("`text` DESC");
        
        return $this->findListByExample($example);
    }
}