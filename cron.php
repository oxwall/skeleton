<?php


class SKELETON_Cron extends OW_Cron
{
    public function __construct()
    {
        parent::__construct();

        $this->addJob('cronJobExample', 60);
        $this->addJob('clearUploadedFiles', 60 * 24);
    }

    public function run()
    {
        //perform some action in default time interval
    }

    public function cronJobExample()
    {
        //perform some action once in an hour
    }

    public function clearUploadedFiles()
    {
        $fileNameList = OW::getStorage()->getFileNameList(OW::getPluginManager()->getPlugin('skeleton')->getUserFilesDir(), 'file_storage_');
        foreach($fileNameList as $filename)
        {
            OW::getStorage()->removeFile($filename);
        }
    }
}