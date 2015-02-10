<?php

class SKELETON_BOL_Service
{
    /**
     * Class instance
     *
     * @var SKELETON_BOL_Service
     */
    private static $classInstance;
    
    /**
     * Returns class instance
     *
     * @return SKELETON_BOL_Service
     */
    public static function getInstance()
    {
        if ( null === self::$classInstance )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }
    
    /**
     *
     * @var SKELETON_BOL_RecordDao
     */
    private $recordDao;
    
    private function __construct()
    {
        $this->recordDao = SKELETON_BOL_RecordDao::getInstance();
    }
    
    /**
     * 
     * @param string $text
     * @param string $extendedText
     * @param string $choise
     * @return SKELETON_BOL_Record
     */
    public function addRecord( $text, $extendedText, $choise )
    {
        $record = new SKELETON_BOL_Record;
        $record->text = $text;
        $record->extendedText = $extendedText;
        $record->choice = $choise;
        
        return $this->recordDao->save($record);
    }

    public function deleteDatabaseRecord($id)
    {
        $this->recordDao->deleteById($id);
    }
    
    /**
     * 
     * @return array
     */
    public function findList()
    {
        return $this->recordDao->findListOrderedByText();
    }
}