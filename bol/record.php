<?php

/**
 * Data Transfer Object for `skeleton_record` table.
 *
 * @package ow.plugin.skeleton.bol
 * @since 1.0
 */
class SKELETON_BOL_Record extends OW_Entity
{
    /**
     *
     * @var string
     */
    public $text;
           
    /**
     *
     * @var string
     */
    public $extendedText;
    
    /**
     *
     * @var int
     */
    public $choice;
}