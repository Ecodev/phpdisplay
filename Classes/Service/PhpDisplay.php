<?php
namespace Tesseract\Phpdisplay\Service;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Tesseract\Phpdisplay\View\PhpView;
use Tesseract\Tesseract\Service\ControllerBase;
use Tesseract\Tesseract\Service\FrontendConsumerBase;
use Tesseract\Tesseract\Tesseract;
use Tesseract\Tesseract\Utility;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Plugin 'Data Displayer' for the 'phpdisplay' extension.
 */
class PhpDisplay extends FrontendConsumerBase
{

    /**
     * @var string
     */
    public $tsKey = 'tx_phpdisplay';

    /**
     * @var string
     */
    public $extKey = 'phpdisplay';

    /**
     * @var array
     */
    protected $configuration;

    protected $table; // Name of the table where the details about the data display are stored
    protected $uid; // Primary key of the record to fetch for the details
    protected $structure = array(); // Input standardised data structure
    protected $result = ''; // The result of the processing by the Data Consumer
    protected $counter = array();

    protected $labelMarkers = array();
    protected $datasourceFields = array();
    protected $datasourceObjects = array();
    protected $LLkey = 'default';
    protected $fieldMarkers = array();

    /**
     * This method resets values for a number of properties
     * This is necessary because services are managed as singletons
     *
     * @return    void
     */
    public function reset()
    {
        $this->structure = array();
        $this->result = '';
        $this->uid = '';
        $this->table = '';
        $this->conf = array();
        $this->datasourceFields = array();
        $this->LLkey = 'default';
        $this->fieldMarkers = array();
    }

    /**
     * Return the filter data.
     *
     * @return    array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     *
     * @var ContentObjectRenderer
     */
    protected $localCObj;

    // Data Consumer interface methods

    /**
     * This method returns the type of data structure that the Data Consumer can use
     *
     * @return    string    type of used data structures
     */
    public function getAcceptedDataStructure()
    {
        return Tesseract::RECORDSET_STRUCTURE_TYPE;
    }

    /**
     * This method indicates whether the Data Consumer can use the type of data structure requested or not
     *
     * @param    string $type : type of data structure
     * @return    boolean        true if it can use the requested type, false otherwise
     */
    public function acceptsDataStructure($type)
    {
        return $type == Tesseract::RECORDSET_STRUCTURE_TYPE;
    }

    /**
     * This method is used to pass a data structure to the Data Consumer
     *
     * @param    array $structure : standardised data structure
     * @return    void
     */
    public function setDataStructure($structure)
    {
        $this->structure[$structure['name']] = $structure;
    }

    /**
     * This method is used to pass a filter to the Data Consumer
     *
     * @param    array $filter : Data Filter structure
     * @return    void
     */
    public function setDataFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * This method is used to get a data structure
     *
     * @return    array    $structure: standardised data structure
     */
    public function getDataStructure()
    {
        return $this->structure;
    }

    /**
     * This method returns the result of the work done by the Data Consumer (FE output or whatever else)
     *
     * @return    mixed    the result of the Data Consumer's work
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * This method sets the result. Useful for hooks.
     *
     * @param mixed $result Predefined result
     * @return void
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * This method starts whatever rendering process the Data Consumer is programmed to do
     *
     * @return void
     */
    public function startProcess()
    {

        if (isset($GLOBALS['_GET']['debug']['structure'], $GLOBALS['TYPO3_MISC']['microtime_BE_USER_start'])) {
            DebugUtility::debug($this->structure);
        }
        // Initializes local cObj
        $this->localCObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $this->configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);


        // Get the full path to the template file
        try {
            $filePath = Utility\Utilities::getTemplateFilePath($this->consumerData['template']);

            /** @var $template PhpView */
            $template = GeneralUtility::makeInstance(PhpView::class);
            $template->set('controller', $this->getController());
            $template->set('filter', $this->getFilter());
            $template->set('datastructure', $this->getDataStructure());
            $this->result = $template->fetch($filePath);
        } catch (Exception $e) {
            $this->controller->addMessage(
                $this->extKey,
                $e->getMessage() . ' (' . $e->getCode() . ')',
                'Error processing the view',
                FlashMessage::ERROR
            );
        }
    }

    /**
     * Displays in the frontend or in the devlog some debug output
     *
     * @return void
     */
    protected function debug()
    {

        if (isset($GLOBALS['_GET']['debug']['structure']) && $GLOBALS['TSFE']->beUserLogin) {
            DebugUtility::debug($this->getDataStructure());
        }

        if (isset($GLOBALS['_GET']['debug']['filter']) && $GLOBALS['TSFE']->beUserLogin) {
            DebugUtility::debug($this->getFilter());
        }
    }

    /**
     * Returns a reference to the component's controller
     *
     * @return ControllerBase The controller
     */
    public function getController()
    {
        return $this->controller;
    }

}
