<?php

require __DIR__ . '/command/TerminalCommand.php';
require __DIR__ . '/command/AliasCommand.php';
require __DIR__ . '/command/RevertTimeCommand.php';

require __DIR__ . '/command/BashCommand.php';
require __DIR__ . '/command/CatCommand.php';
require __DIR__ . '/command/CdCommand.php';
require __DIR__ . '/command/ChmodCommand.php';
require __DIR__ . '/command/CpCommand.php';
require __DIR__ . '/command/EditCommand.php';
require __DIR__ . '/command/ExitCommand.php';
require __DIR__ . '/command/HelpCommand.php';
require __DIR__ . '/command/LnCommand.php';
require __DIR__ . '/command/LsCommand.php';
require __DIR__ . '/command/MkDirCommand.php';
require __DIR__ . '/command/MvCommand.php';
require __DIR__ . '/command/NetworkCommand.php';
require __DIR__ . '/command/PwdCommand.php';
require __DIR__ . '/command/RmCommand.php';
require __DIR__ . '/command/RmDirCommand.php';
require __DIR__ . '/command/SecurityCommand.php';
require __DIR__ . '/command/SshCommand.php';
require __DIR__ . '/command/SuCommand.php';

/**
 * @param $commandInfo object
 * @return null|array TerminalCommand
 */
function createCommand($commandInfo)
{
    switch ($commandInfo->type) {
        case 'command':
            switch ($commandInfo->name) {
                case 'bash':
                    return [new BashCommand()];
                case 'cat':
                    return [new CatCommand()];
                case 'cd':
                    return [new CdCommand()];
                case 'chmod':
                    return [new ChmodCommand()];
                case 'cp':
                    return [new CpCommand()];
                case 'edit':
                    return [new EditCommand()];
                case 'exit':
                    return [new ExitCommand()];
                case 'help':
                    return [new HelpCommand()];
                case 'ln':
                    return [new LnCommand()];
                case 'ls':
                    return [new LsCommand()];
                case 'mkdir':
                    return [new MkDirCommand()];
                case 'mv':
                    return [new MvCommand()];
                case 'network':
                    return [new NetworkCommand()];
                case 'pwd':
                    return [new PwdCommand()];
                case 'rm':
                    return [new RmCommand()];
                case 'rmdir':
                    return [new RmDirCommand()];
                case 'security':
                    return [new SecurityCommand()];
                case 'ssh':
                    return [new SshCommand()];
                case 'su':
                    return [new SuCommand()];
                default:
                    return null;//invalid command name
            }
            break;
        case 'alias':
            return [new AliasCommand($commandInfo->name, $commandInfo->target)];
        case 'set':
            switch ($commandInfo->name) {
                case 'basic':
                    return [new BashCommand(), new ExitCommand(), new HelpCommand(), new SuCommand()];
                case 'files':
                    return [new CatCommand(), new CdCommand(), new ChmodCommand(), new CpCommand(),
                        new EditCommand(), new AliasCommand('ll', 'ls -al'), new LnCommand(), new LsCommand(),
                        new MkDirCommand(), new MvCommand(), new PwdCommand(), new RmCommand(),
                        new RmDirCommand()];
                case 'network':
                    return [new SshCommand(), new NetworkCommand()];
                case 'repeater':
                    return [];
                case 'router':
                    return [];
                case 'server':
                    return [new SecurityCommand()];
                default:
                    return null;
            }
        default:
            return null;//invalid type
    }
}

class EnvironmentInfo
{

    /**
     * @var DeviceHandler
     */
    private $deviceHandler;
    /**
     * @var string
     */
    private $actualUserName;

    /**
     * @var string
     */
    private $workingDirectory;

    /**
     * @var array TerminalCommand
     */
    private $commands;

    /**
     * EnvironmentInfo constructor.
     * @param $terminal Terminal
     * @param $deviceHandler DeviceHandler
     * @param $actualUserName string
     * @param $workingDirectory string
     */
    public function __construct($terminal, $deviceHandler, $actualUserName, $workingDirectory = null)
    {
        $this->deviceHandler = $deviceHandler;
        $this->actualUserName = $actualUserName;
        $userInfo = $this->getActualUserInfo();
        $this->workingDirectory = $workingDirectory != null
            ? $workingDirectory : $userInfo->homeDirectory;

        $this->commands = array();
        foreach ($userInfo->commands as &$commandsInfo) {
            $commandsSet = createCommand($commandsInfo);
            if ($commandsSet != null) {
                foreach ($commandsSet as $command) {
                    $this->commands[$command->getName()] = $command;
                }
            } else add_to_log('Command not found. Command info: ' . json_encode($commandsInfo));
        }
        $command = new RevertTimeCommand();
        $this->commands[$command->getName()] = $command;
        ksort($this->commands);

        onEnvironmentCreate($terminal, $this);
    }

    /**
     * @return DeviceHandler
     */
    public function getDeviceHandler()
    {
        return $this->deviceHandler;
    }

    /**
     * @return object
     */
    public function getDeviceInfo()
    {
        return $this->getDeviceHandler()->getDeviceInfo();
    }

    /**
     * @return string
     */
    public function getActualUserName()
    {
        return $this->actualUserName;
    }

    /**
     * @return object
     */
    public function getActualUserInfo()
    {
        return $this->getDeviceInfo()->accounts->data->{$this->getActualUserName()};
    }

    /**
     * @param string $workingDirectory
     */
    public function setWorkingDirectory($workingDirectory)
    {
        $this->workingDirectory = $workingDirectory;
    }

    /**
     * @return string
     */
    public function getWorkingDirectory()
    {
        return $this->workingDirectory;
    }

    /**
     * @return array TerminalCommand
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getWelcomeText($terminal)
    {
        $welcomeText = implode($this->getActualUserInfo()->welcomeText);
        onGetWelcomeText($terminal, $this, $welcomeText);
        return $welcomeText;
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getExitText($terminal)
    {
        $exitText = implode($this->getActualUserInfo()->exitText);
        onGetExitText($terminal, $this, $exitText);
        return $exitText;
    }

    /**
     * @param $terminal Terminal
     * @param $input string
     * @return array string
     */
    public function executeCommand($terminal, $input) {
        $commandName = explode(' ', $input)[0];

        $output = null;
        $commands = $this->getCommands();
        $command = isset($commands[$commandName]) ? $commands[$commandName] : null;
        $output = $command == null ? array('result' => "<p>Příkaz nebyl nalezen!</p>"
            . "<p>Pro seznam dostupných příkazů použíjte příkaz <b>'help'</b>.</p>")
            : $command->doCommand($terminal, $this, substr($input, strlen($commandName) + 1));

        onCommandHandled($terminal, $this, $input, $command, $output);
        return $output;
    }
}
