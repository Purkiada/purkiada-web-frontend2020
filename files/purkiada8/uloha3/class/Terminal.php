<?php

require __DIR__ . '/Hooks.php';
require __DIR__ . '/devices/Devices.php';

require __DIR__ . '/bash/InputProcessor.php';
require __DIR__ . '/bash/CommandsBash.php';
require __DIR__ . '/bash/StartupLoginInputProcessor.php';
require __DIR__ . '/bash/WelcomeInputProcessor.php';
require __DIR__ . '/bash/JsonBash.php';
require __DIR__ . '/bash/LoginInputProcessor.php';

class Terminal
{
    /**
     * @var Devices
     */
    private $devices;
    /**
     * @var string
     */
    private $terminalContentBackup = '';
    /**
     * @var array Bash
     */
    private $inputProcessorsStack = [];

    /**
     * Terminal constructor.
     */
    public function __construct()
    {
        $this->devices = new Devices();
        $this->terminalContentBackup .= $this->addInputProcessorToTop(new StartupLoginInputProcessor());
    }

    /**
     * @return Devices
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param $content string
     */
    public function backupContent($content)
    {
        $this->terminalContentBackup = $content;
    }

    /**
     * @return string
     */
    public function getContentBackup()
    {
        return $this->terminalContentBackup;
    }

    /**
     * @param $inputProcessor InputProcessor
     * @return string
     */
    public function addInputProcessorToTop($inputProcessor)
    {
        $oldBash = empty($this->inputProcessorsStack) ? null : $this->inputProcessorsStack[0];
        array_unshift($this->inputProcessorsStack, $inputProcessor);
        return !($oldBash instanceof CommandsBash)
        || !($inputProcessor instanceof CommandsBash)
        || $oldBash->getEnvironmentInfo()->getDeviceHandler() != $inputProcessor->getEnvironmentInfo()->getDeviceHandler()
        || $oldBash->getEnvironmentInfo()->getActualUserName() != $inputProcessor->getEnvironmentInfo()->getActualUserName()
            ? $inputProcessor->getWelcomeText($this) : '';
    }

    /**
     * @return string
     */
    public function removeTopInputProcessor()
    {
        if (empty($this->inputProcessorsStack)) return '';

        $oldBash = array_shift($this->inputProcessorsStack);
        $newBash = empty($this->inputProcessorsStack) ? null : $this->inputProcessorsStack[0];
        return !($oldBash instanceof CommandsBash)
        || !($newBash instanceof CommandsBash)
        || $oldBash->getEnvironmentInfo()->getDeviceHandler() != $newBash->getEnvironmentInfo()->getDeviceHandler()
        || $oldBash->getEnvironmentInfo()->getActualUserName() != $newBash->getEnvironmentInfo()->getActualUserName()
            ? $oldBash->getExitText($this) : '';
    }

    /**
     * @return InputProcessor|null
     */
    public function getTopInputProcessor()
    {
        return empty($this->inputProcessorsStack) ? null : $this->inputProcessorsStack[0];
    }

    /**
     * @return int
     */
    public function getInputProcessorsCount()
    {
        return count($this->inputProcessorsStack);
    }

    public function resetInputProcessorsStack()
    {
        if (empty($this->inputProcessorsStack)) return false;
        $this->inputProcessorsStack = [];
        return true;
    }

    /**
     * @return string
     */
    public function getInputPrefix()
    {
        if (empty($this->inputProcessorsStack)) return '>';
        return $this->inputProcessorsStack[0]->getInputPrefix($this);
    }

    /**
     * @return string
     */
    public function getInputType()
    {
        if (empty($this->inputProcessorsStack)) return 'none';
        return $this->inputProcessorsStack[0]->getInputType($this);
    }

    /**
     * @param $input string
     * @return array
     */
    public function handleInput($input)
    {
        if (empty($this->inputProcessorsStack)) {
            unset($_SESSION['controlPanelTerminal']);
            $result = array('result' => '<p>Nenalezen žádný terminál, který by mohl zachytit požadavek.'
                . ' Ukončuji terminál, prosím obnovte prohlížeč.</p>',
                'inputType' => 'none', 'backupContent' => false);
        } else {
            $result = $this->inputProcessorsStack[0]->handleInput($this, $input);
        }

        $output = [];
        $output['clear'] = isset($result['clear']) ? $result['clear'] : false;
        $output['result'] = isset($result['result']) ? $result['result'] : '';
        $output['inputPrefix'] = isset($result['inputPrefix']) ? $result['inputPrefix'] : $this->getInputPrefix();
        $output['inputType'] = isset($result['inputType']) ? $result['inputType'] : $this->getInputType();//[line, char, none]
        $output['backupContent'] = isset($result['backupContent']) ? $result['backupContent'] : true;

        return $output;
    }

    /**
     * @param $actualInputValue string
     * @return array
     */
    public function handleTab($actualInputValue)
    {
        $output = empty($this->inputProcessorsStack) ? array()
            : $this->inputProcessorsStack[0]->handleTab($this, $actualInputValue);

        if (!isset($output['hasResult'])) {
            $output['hasResult'] = isset($output['result']);
        }

        if (!isset($output['result'])) {
            $output['result'] = '';
        }

        if (!isset($output['changedInput'])) {
            $output['changedInput'] = $actualInputValue;
        }

        return $output;
    }

    /**
     * @param $actualInputValue string
     * @param $offset integer
     * @return array
     */
    public function handleUpDown($actualInputValue, $offset)
    {
        $output = empty($this->inputProcessorsStack) ? array() :
            $this->inputProcessorsStack[0]->handleUpDown($this, $actualInputValue, $offset);

        if (!isset($output['changedInput'])) {
            $output['changedInput'] = $actualInputValue;
        }

        return $output;
    }
}
