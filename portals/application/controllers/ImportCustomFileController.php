<?php
class ImportCustomFileController extends Zend_Controller_Action
{

    protected $_mainRouter;
    protected $_item;
    protected $_pk;
    protected $_ids;
    protected $_mapperName;
    protected $_mapper;
    protected $_modelName;
    protected $_model;
    protected $_multilangFields;
    protected $_availableLangs;
    protected $_config;
    protected $_freeUploadCommand;
    protected $_delimiter = ";";
    protected $_enclosure;
    protected $_scape;
    protected $_forcedValues;

    protected $_availableFields = array(
        "targetPatternName" => array(
            "title" => "Target Pattern Name",
            "required" => true,
            "help" => "Target Pattern Name",
        ),
        "targetPatternDescription" => array(
            "title" => "Target Pattern Description",
            "required" => true,
            "help" => "",
        ),
        "regularExpresion" => array(
            "title" => "Prefix",
            "required" => true,
            "help" => "Regular Expresion",
        ),
        "perPeriodCharge" => array(
            "title" => "Per minute charge",
            "required" => true,
            "help" => "Per minute charge",
        ),
        "connectionCharge" => array(
            "title" => "Connection charge",
            "required" => true,
            "help" => "Connection charge",
        ),
        "periodTime" => array(
            "title" => "Charge period",
            "required" => true,
            "help" => "Charge period",
        ),
    );


    /**
     * @var \Bootstrap
     */
    protected $_bootstrap;

    public function init()
    {
        $front = \Zend_Controller_Front::getInstance();
        $this->_bootstrap = $front->getParam('bootstrap');

        /**
         * Initialize action controller here
         */
        if ((!$this->_mainRouter = $this->getRequest()->getUserParam("mainRouter")) ||
                (!is_object($this->_mainRouter)) ) {
            throw New Zend_Exception("", Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION);
        }

        $this->_item    = $this->_mainRouter->getCurrentItem();
        $this->_config = $this->_item->getConfig();
        $this->_mapperName = $this->_config->getProperty("mapper");
        $this->_freeUploadCommand = $this->_config->getProperty("freeUploadCommand");

        $delimiter = $this->_config->getProperty("delimiter");
        if (!is_null($delimiter)) {
            $this->_delimiter = $delimiter;
        }
        $this->_enclosure = $this->_config->getProperty("enclosure");
        $this->_scape = $this->_config->getProperty("scape");


        /////////////////////////////////////////////////
//        $this->_mapper = new $this->_mapperName;
//        $this->_pk = $this->getRequest()->getParam("pk");
//        $this->_model = $this->_item->getModelSpec()->getInstance();
//        $this->_modelName = $this->_item->getModelSpec()->getClassName();
//        $availableFields = $this->_item->getModelSpec()->getFields();
//
//        $this->_multilangFields = $this->_model->getMultiLangColumnsList();
//        $this->_availableLangs = $this->_model->getAvailableLangs();
//        asort($this->_availableLangs);
        ///////////////////////////////////////////////////////////

        $this->_forcedValues = $this->_config->getProperty("forcedValues")->toArray();


        //////////////////////////////////////////////////////////
//        $this->_availableFields = array();
//
//        foreach ($availableFields as $key => $field) {
//            $this->_availableFields[$key] = $field;
//            if (isset($this->_multilangFields[$key])) {
//                $title = \Klear_Model_Gettext::gettextCheck($field->get("title"));
//                foreach ($this->_availableLangs as $lang) {
//                    $newField = $field->toArray();
//                    $newField["title"] = $title." ".ucfirst($lang);
//                    $newFieldConfig = new \Zend_Config($newField);
//                    $this->_availableFields[$key."_".$lang] = $newFieldConfig;
//                }
//            }
//        }
        //////////////////////////////////////////////////////////////

        $this->_helper->ContextSwitch()
        ->addActionContext("import", "json")
        ->initContext("json");

        $this->_helper->layout->disableLayout();
    }

    protected function _dispatch(array $data)
    {
        $jsonResponse = new Klear_Model_DispatchResponse();
        $jsonResponse->setModule('klearMatrix');
        $jsonResponse->setPlugin('klearMatrixGenericDialog');
        $jsonResponse->addJsFile("/js/plugins/qq-fileuploader.js");
        $jsonResponse->addJsFile('/js/plugins/jquery.klearmatrix.genericdialog.js');
        $jsonResponse->setData($data);
        $jsonResponse->attachView($this->view);
    }

    public function importAction()
    {
        switch ($this->getParam("step")) {
            case "process_confirm":
                $this->_checkFields();
                break;
            case "load_file":
                if (is_null($this->_getFilePath())) {
                    $this->_loadFile();
                } else {
                    $this->_confirmImport();
                }
                break;
            default:
                $this->_loadFile();
                break;
        }
    }

    protected function _loadFile()
    {

        $message = "<p>".$this->_helper->translate("Select file to import")."</p>";
        $message .= "<input type='file' name='importFile' data-upload-command='".$this->_freeUploadCommand."'>";
        $data = array(
                'title' => $this->_helper->translate("Import file"),
                'message' => $message,
                'buttons' => array(
                        $this->_helper->translate('Close') => array(
                                'recall' => false,
                                'reloadParent' => false
                        ),
                        $this->_helper->translate('Continue') => array(
                                'recall' => true,
                                'params' => array(
                                        'step' => "load_file"
                                )
                        ),
                )
        );
        $this->_dispatch($data);
    }

    protected function _getFilePath()
    {
        $tempFSystemNS = new \Zend_Session_Namespace('File_Controller');

        $fileHash = $this->getRequest()->getParam('importFile');
        if (!empty($fileHash) && isset($tempFSystemNS->{$fileHash})) {
            $tempFile = $tempFSystemNS->{$fileHash};
            return $tempFile["path"];
        }
        return null;
    }

    protected function _parseFile($filePath, $limit = null)
    {
        $file = file_get_contents($filePath);
        $lines = explode(PHP_EOL, trim($file));

        if (count($lines)<=0) {
            return false;
        }

        $counter = 0;
        $linesArray = array();
        foreach ($lines as $line) {
            $lineFields = str_getcsv(trim($line), $this->_delimiter, $this->_enclosure, $this->_scape);
            $linesArray[] = $lineFields;
            $counter++;
            if (!is_null($limit) && $counter==$limit) {
                break;
            }
        }

        return $linesArray;
    }

    protected function _buildForm($lines)
    {
        $form = '
        <style>
        .tableBox {
        max-width:750px;overflow:auto;
    }
    .parsedValues tr td {
    border: 1px solid #999;
    padding: 4px;
    }
    .parseHelp{
    padding: 17px;
    font-size: 0.9em;
    }
    </style>
    ';

        $help = '<div class="parseHelp">';
        $help.= '<p>'.$this->_helper->translate("Import system").". ".$this->_helper->translate("Set column configuration and continue.").'</p>';
        $help.= '<p>'.$this->_helper->translate("Fields with * are required").'.</p><br/>';
        $help.= '<ul>';

        foreach ($this->_availableFields as $key => $fieldInfo) {
            if (isset($this->_forcedValues[$key])) {
                continue;
            }
            $fieldLabel = \Klear_Model_Gettext::gettextCheck($fieldInfo['title']);
            $required = "";
            if (!is_null($fieldInfo['required']) && $fieldInfo['required']) {
                $required = "*";
            }
            $fieldHelp = "";
            if (!is_null($fieldInfo['help'])) {
                $required .= ": ";
                $fieldHelp = \Klear_Model_Gettext::gettextCheck($fieldInfo['help']);
            }

            $help.='<li>'.$fieldLabel.$required.'<em>'.$fieldHelp.'</em></li>';
        }

        $help.= '</ul></div>';
        $table = $help . '<div class="tableBox"><table class="kMatrix parsedValues">';
        $table.= "<tr>";
        $idx = 0;

        $lineLength = count($lines[0]);
        $availableFieldsKeys = array_keys($this->_availableFields);
        for ($i = 0; $i < $lineLength; $i ++){
            $optionValue = $this->getRequest()->getParam('field_'.$i, null);

            $tmp = '<select name="field_'.$i.'" class="notcombo visualFilter ui-widget ui-state-default ui-corner-all ui-state-valid">';
            $selected = "";
            if ($optionValue == "ignore") {
                $selected = 'selected="selected"';
            }
            $tmp.='<option value="ignore" '.$selected.'>' . $this->_helper->translate('Ignore') . '</option>';
            foreach ($availableFieldsKeys as $idf => $xfield) {
                if (isset($this->_forcedValues[$xfield])) {
                    continue;
                }
                $xfieldLabel = \Klear_Model_Gettext::gettextCheck($this->_availableFields[$xfield]['title']);
                $xfieldRequired = "";
                if (!is_null($this->_availableFields[$xfield]['required']) && $this->_availableFields[$xfield]['required']) {
                    $xfieldRequired = "*";
                }
                $selected = "";
                if (is_null($optionValue) && $i == $idf) {
                    $selected = 'selected="selected"';
                } else {
                    if ($optionValue == $xfield) {
                        $selected = 'selected="selected"';
                    }
                }
                $tmp .= '<option value="'.$xfield.'" '
                    .$selected.'>'
                    .$xfieldLabel.$xfieldRequired. '</option>';
            }
            $tmp.= '</select>';
            $table.="<th class='ui-widget-header multiItem notSortable'>" . $tmp . "</th>";
        }

        $table.= "</tr>";
        foreach ($lines as $line) {
            $table.= "<tr>";
            foreach ($line as $idPart=>$part) {
                $table.="<td class='ui-widget-content'>" . $part . "</td>";
            }
            $table.= "</tr>";
        }
        $table .="</table>";
        $form .= $table . '</div><br />';
        $ignoreFirst = $this->getRequest()->getParam("ingoreFirst", null);
        $checked = '';
        if (!is_null($ignoreFirst) && $ignoreFirst == "on") {
            $checked = 'checked="checked"';
        }
        $form .= '<label><input type="checkbox" name="ingoreFirst" '.$checked.'/> ' . $this->_helper->translate("Ignore first line.").'</label>';
        $update = $this->getRequest()->getParam("update", null);
        $checked = '';
        if (!is_null($update) && $update == "on") {
            $checked = 'checked="checked"';
        }
//        $form .= '<label><input type="checkbox" name="update" '.$checked.'/> ' . $this->_helper->translate("Update values.").'</label>';
        $form .= '';

        return $form;
    }
    protected function _confirmImport($message = "", $filePath = null)
    {
        if (is_null($filePath)) {
            $filePath = $this->_getFilePath();
        }
        $lines = $this->_parseFile($filePath, 3);

        if ($lines===false) {
            $this->_generalError();
            return;
        }

        $form = $this->_buildForm($lines);
        $data = array(
                'title' => $this->_helper->translate("Import file"),
                'message' => $message."<br>".$form,
                'buttons' => array(
                        $this->_helper->translate('Close') => array(
                                'recall' => false,
                                'reloadParent' => false
                        ),
                        $this->_helper->translate('Yes, continue!') => array(
                                'recall' => true,
                                'params' => array(
                                        "step" => 'process_confirm',
                                        "filePath" => $filePath
                                )
                        ),
                )
        );
        $this->_dispatch($data);
    }

    protected function _enqueImport()
    {

       // $redisConfig = $this->_bootstrap->getOption("redis");
       // $redisServer = $redisConfig["backend"];

       // \Resque::setBackend($redisServer);

       // $queue = "pricesImporter";
       // $class = "\\IvozProvider\\Resque\\Jobs\\Import\\Processor";

        $jobData = $this->getRequest()->getParams();
        $jobData["delimiter"] = $this->_delimiter;
        $jobData["enclosure"] = $this->_enclosure;
        $jobData["scape"] = $this->_scape;
        $jobData["forcedValues"] = $this->_forcedValues;

       // $jobToken = \Resque::enqueue($queue, $class, $jobData);

        $importJob = new \IvozProvider\Gearmand\Jobs\Pricesimporter();
        $importJob->setParams($jobData)->send();

        $mess = $this->_helper->translate("Import process enqueued");
        //$message = sprintf($mess, $jobToken);

        $data = array (
            'title' => $this->_helper->translate("Import file"),
            'message' => $mess,
            'buttons' => array(
                $this->_helper->translate('Close') => array(
                    'recall' => false,
                    'reloadParent' => true
                )
            )
        );
        $this->_dispatch($data);
    }

    protected function _checkFields()
    {
        $error = array();
        $success = array();
        $filePath = $this->getRequest()->getParam('filePath');
        $ignoreFirst = $this->getRequest()->getParam('ingoreFirst');
        $conf = array();

        $lines = $this->_parseFile($filePath, 1);
        $fileFields = count($lines[0]);
        $fieldsPossitions = array();
        for($i = 0; $i < $fileFields; $i++) {
            $fieldName = $this->getRequest()->getParam('field_'.$i);
            $fieldsPossitions[$fieldName] = $i;
        }

        //comprobar campos requeridos
        $missing = false;
        $message = '<p><b style="color: red;">ERROR</b></p>';
        foreach ($this->_availableFields as $key => $field) {
            if (isset($this->_forcedValues[$key])) {
                continue;
            }
            if ($field["required"]) {
                if (!isset($fieldsPossitions[$key])) {
                    $missing = true;
                    $message .= "<p>'".$key."' ".$this->_helper->translate("is a required field").".</p>";
                }
            }
        }

        if ($missing) {
            $this->_log($message);
            $this->_confirmImport($message, $filePath);
            return;
        }

        $this->_enqueImport();
    }

    protected function _generalError()
    {
        $this->_dispatch(
                array(
                        'title' => $this->_helper->translate("An error occurred"),
                        'message' => $this->_helper->translate("An error occurred: check files format and content."),
                        'buttons' => array(
                                $this->_helper->translate('Close') => array(
                                        'recall' => false,
                                        'reloadParent' => false
                                )
                        )
                )
        );
    }

    protected function _log($message, $priorityText = null)
    {
        switch ($priorityText) {
            case "error":
                $priority = \Zend_Log::ERR;
                break;
            case "info":
                $priority = \Zend_Log::INFO;
                break;
            default:
                $priority = \Zend_Log::DEBUG;
                break;
        }
        $this->_helper->log($message, $priority);
    }

}
