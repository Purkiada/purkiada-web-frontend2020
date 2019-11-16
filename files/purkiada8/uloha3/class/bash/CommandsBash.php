<?php

require __DIR__ . '/../EnvironmentInfo.php';

abstract class CommandsBash implements InputProcessor
{

    /**
     * @return EnvironmentInfo
     */
    public abstract function getEnvironmentInfo();

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getWelcomeText($terminal)
    {
        return $this->getEnvironmentInfo()->getWelcomeText($terminal);
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getExitText($terminal)
    {
        return $this->getEnvironmentInfo()->getExitText($terminal);
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputPrefix($terminal)
    {
        $environmentInfo = $this->getEnvironmentInfo();

        $userInfo = $environmentInfo->getActualUserInfo();
        $userColor = $userInfo->admin ? 'red': 'lawngreen';

        $hasFiles = $environmentInfo->getDeviceInfo()->hasFiles;
        $workingDirText = '';
        if ($hasFiles) {
            $displayWorkingDirectory = str_replace($userInfo->homeDirectory, "~", $environmentInfo->getWorkingDirectory());
            $workingDirText = "<span style='color: white'>:</span>"
                . "<span style='color: royalblue'>" . htmlspecialchars($displayWorkingDirectory) . "</span>";
        }
        return "<span style='color: $userColor'>" . htmlspecialchars($environmentInfo->getActualUserName() . "@"
                . $environmentInfo->getDeviceHandler()->getDeviceName()) . "</span>"
            . $workingDirText
            . "<span style='color: white'>$</span>&nbsp;";
    }

    public function getInputType($terminal)
    {
        return 'line';
    }
}
