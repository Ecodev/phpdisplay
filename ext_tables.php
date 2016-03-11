<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_phpdisplay_displays');

// Add a wizard for adding a datadisplay
$addTemplateDisplayWizard = [
    'type' => 'script',
    'title' => 'LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:wizards.add_phpdisplay',
    'module' => array(
        'name' => 'wizard_add',
    ),
    'icon' => 'EXT:phpdisplay/Resources/Public/images/tx_phpdisplay_displays.png',
    'params' => [
        'table' => 'tx_phpdisplay_displays',
        'pid' => '###CURRENT_PID###',
        'setValue' => 'set'
    ]
];
$GLOBALS['TCA']['tt_content']['columns']['tx_displaycontroller_consumer']['config']['wizards']['add_phpdisplay'] = $addTemplateDisplayWizard;


// Register phpdisplay with the Display Controller as a Data Consumer
$GLOBALS['TCA']['tt_content']['columns']['tx_displaycontroller_consumer']['config']['allowed'] .= ',tx_phpdisplay_displays';