<?php

class EditFileInputProcessor implements InputProcessor
{

    /**
     * @var string
     */
    private $filePath;
    /**
     * @var EnvironmentInfo
     */
    private $environment;

    /**
     * EditFileInputProcessor constructor.
     * @param $filePath string
     * @param $parentEnvironment EnvironmentInfo
     */
    public function __construct($filePath, $parentEnvironment)
    {
        $this->filePath = $filePath;
        $this->environment = $parentEnvironment;
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getWelcomeText($terminal)
    {
        return '';
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getExitText($terminal)
    {
        return '';
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputPrefix($terminal)
    {
        $terminal->removeTopInputProcessor();//detected page reload
        return $terminal->getInputPrefix();
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputType($terminal)
    {
        return 'none';
    }

    /**
     * @param $terminal Terminal
     * @param $input string
     * @return array
     */
    public function handleInput($terminal, $input)
    {
        $additionalResult = '';
        if ($input[0] == '1') {
            $pathResult = resolvePath($this->filePath, $this->environment, true, true, true, ['-']);
            if ($pathResult['fail']) {
                $additionalResult .= "<p>edit: Při ukládání souboru došlo k chybě: " . $pathResult['reason'] . "</p>";
            } else $pathResult['file']->content = array(substr($input, 1));
        }
        return array('result' => $additionalResult . $terminal->removeTopInputProcessor());
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @return array
     */
    public function handleTab($terminal, $actualInputValue)
    {
        return array();// LoginInputProcessor don't support tab key
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @param $offset int
     * @return array
     */
    public function handleUpDown($terminal, $actualInputValue, $offset)
    {
        return array();// LoginInputProcessor don't support up/down arrows
    }
}
