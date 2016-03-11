<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Register as Data Consumer service
// Note that the subtype corresponds to the name of the database table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    'phpdisplay',
    'dataconsumer' ,
    'tx_phpdisplay_dataconsumer',
    array(

        'title' => 'Data Display Engine',
        'description' => 'Generic Data Consumer for recordset-type data structures',

        'subtype' => 'tx_phpdisplay_displays',

        'available' => TRUE,
        'priority' => 50,
        'quality' => 50,

        'os' => '',
        'exec' => '',

        'className' => \Tesseract\Phpdisplay\Service\PhpDisplay::class,
    )
);
