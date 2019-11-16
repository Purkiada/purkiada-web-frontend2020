<?php

class ObjectivesHook implements Hook
{

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     */
    public function onEnvironmentCreate($terminal, $environment)
    {
        $objectivesDirPath = $terminal->getDevices()->getActualUserSourcesPath() . '/objectives';

        $objectiveConnectToRepeaterPath = $objectivesDirPath . '/2ConnectToRepeater';
        if ($environment->getDeviceHandler()->getDeviceName() === 'TL-WA850RE'
            && !file_exists($objectiveConnectToRepeaterPath)) {
            file_put_contents($objectiveConnectToRepeaterPath, 'true');
        }

        $objectiveConnectToRouterPath = $objectivesDirPath . '/3ConnectToRouter';
        if ($environment->getDeviceHandler()->getDeviceName() === 'WFADevice'
            && !file_exists($objectiveConnectToRouterPath)) {
            file_put_contents($objectiveConnectToRouterPath, 'true');
        }

        $objectiveConnectToServerPath = $objectivesDirPath . '/4ConnectToServer';
        if ($environment->getDeviceHandler()->getDeviceName() === 'sw.death-star'
            && !file_exists($objectiveConnectToServerPath)) {
            file_put_contents($objectiveConnectToServerPath, 'true');
        }

        $objectiveLoginAsRootInServerPath = $objectivesDirPath . '/5LoginAsRootInServer';
        if ($environment->getDeviceHandler()->getDeviceName() === 'sw.death-star'
            && $environment->getActualUserName() === 'root'
            && !file_exists($objectiveLoginAsRootInServerPath)) {
            file_put_contents($objectiveLoginAsRootInServerPath, 'true');
        }
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @param $command TerminalCommand|null
     * @param $output array
     */
    public function onCommandHandled($terminal, $environment, $input, $command, &$output)
    {
        $objectivesDirPath = $terminal->getDevices()->getActualUserSourcesPath() . '/objectives';

        $objectiveConnectToWifiPath = $objectivesDirPath . '/1ConnectToWifi';
        if ($environment->getDeviceHandler()->getDeviceName() === 'ship'
            && $command instanceof NetworkCommand
            && $environment->getDeviceInfo()->network[0]->enabled
            && !file_exists($objectiveConnectToWifiPath)) {
            file_put_contents($objectiveConnectToWifiPath, 'true');
        }

        $objectiveDisableSecuritySystemsOnDeathStarPath = $objectivesDirPath . '/6DisableSecuritySystemsOnDeathStar';
        if ($environment->getDeviceHandler()->getDeviceName() === 'sw.death-star'
            && $command instanceof SecurityCommand
            && isset($output['type']) && $output['type'] === 'deactivate'
            && !file_exists($objectiveDisableSecuritySystemsOnDeathStarPath)) {
            file_put_contents($objectiveDisableSecuritySystemsOnDeathStarPath, 'true');
        }
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $welcomeText string
     */
    public function onGetWelcomeText($terminal, $environment, &$welcomeText)
    {
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $exitText string
     */
    public function onGetExitText($terminal, $environment, &$exitText)
    {
    }
}

/**
 * @param $loginID string
 * @return bool
 */
function isAllObjectivesCompleted($loginID) {
    $objectivesDirPath = getUserSourcesPath($loginID) . '/objectives';
    $objectiveConnectToWifiPath = $objectivesDirPath . '/1ConnectToWifi';
    $objectiveConnectToRepeaterPath = $objectivesDirPath . '/2ConnectToRepeater';
    $objectiveConnectToRouterPath = $objectivesDirPath . '/3ConnectToRouter';
    $objectiveConnectToServerPath = $objectivesDirPath . '/4ConnectToServer';
    $objectiveLoginAsRootInServerPath = $objectivesDirPath . '/5LoginAsRootInServer';
    $objectiveDisableSecuritySystemsOnDeathStarPath = $objectivesDirPath . '/6DisableSecuritySystemsOnDeathStar';

    return file_exists($objectiveConnectToWifiPath)
        && file_exists($objectiveConnectToRepeaterPath)
        && file_exists($objectiveConnectToRouterPath)
        && file_exists($objectiveConnectToServerPath)
        && file_exists($objectiveLoginAsRootInServerPath)
        && file_exists($objectiveDisableSecuritySystemsOnDeathStarPath);
}
