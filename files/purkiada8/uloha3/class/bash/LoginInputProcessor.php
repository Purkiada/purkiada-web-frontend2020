<?php

class LoginInputProcessor implements InputProcessor
{
    /**
     * @var TerminalCommand
     */
    private $command;
    /**
     * @var DeviceHandler
     */
    private $target;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password = null;
    /**
     * @var string
     */
    private $execute;

    /**
     * SshConnectInputProcessor constructor.
     * @param $command TerminalCommand
     * @param $target DeviceHandler
     * @param $username string
     * @param $execute string
     */
    public function __construct($command, $target, $username, $execute = 'bash')
    {
        $this->command = $command;
        $this->target = $target;
        $this->username = $username;
        $this->execute = $execute;
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
        return $this->username == null ? 'Uživatelské jméno:&nbsp;' : 'Heslo:&nbsp;';
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputType($terminal)
    {
        return 'line';
    }

    /**
     * @param $terminal Terminal
     * @param $input string
     * @return array
     */
    public function handleInput($terminal, $input)
    {
        if ($this->username == null) {
            $this->username = $input;

            if ($this->target !== null) {
                $result = processLogin($terminal, $this->target, $this->username, '', $this->execute, true);

                if (!$result['fail']) {
                    return $result['result'];
                }
            }

            return array();
        }

        $this->password = $input;

        if ($this->password === null) return array();
        if ($this->target === null) {
            return array('result' => '<p>' . $this->command->getName() . ': '
                    . 'Špatné uživatelské jméno, nebo heslo' . '</p>' . $terminal->removeTopInputProcessor());
        } else {
            $result = processLogin($terminal, $this->target, $this->username, $this->password, $this->execute, true);

            if ($result['fail']) {
                return array('result' => '<p>' . $this->command->getName() . ': '
                    . $result['reason'] . '</p>' . $terminal->removeTopInputProcessor());
            }

            return $result['result'];
        }
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
