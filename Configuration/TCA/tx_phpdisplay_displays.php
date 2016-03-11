<?php
if (!defined('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("tx_phpdisplay_displays", "--palette--;LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays.debug;10", "", "after:description");
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("tx_phpdisplay_displays", "--palette--;LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays.pagebrowser;20", "", "after:description");

return [
    'ctrl' => [
        'title' => 'LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'title,description,template',
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('phpdisplay') . 'Configuration/TCA/tx_phpdisplay_displays.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('phpdisplay') . 'Resources/Public/images/tx_phpdisplay_displays.png',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden,title,description'
    ],
    'feInterface' => $GLOBALS['TCA']['tx_phpdisplay_displays']['feInterface'],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0'
            ]
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays.title',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'required,trim',
            ]
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays.description',
            'config' => [
                'type' => 'text',
                'cols' => '40',
                'rows' => '4',
            ]
        ],
        'template' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:phpdisplay/Resources/Private/Language/locallang_db.xml:tx_phpdisplay_displays.template',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'eval' => 'trim',
                'default' => 'EXT:phpdisplay/Samples/Simple.php',
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'Link',
                        'icon' => 'link_popup.gif',
                        'module' => [
                            'name' => 'wizard_element_browser',
                            'urlParameters' => [
                                'mode' => 'wizard',
                                'act' => 'file'
                            ]
                        ],
                        'JSopenParams' => 'height=600,width=700,status=0,menubar=0,scrollbars=1',
                        'params' => [
                            'blindLinkOptions' => 'page,url,mail,spec,folder',
                        ],
                    ]
                ]
            ]
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, template, description']
    ],
    'palettes' => [
        '1' => ['showitem' => '']
    ]
];
