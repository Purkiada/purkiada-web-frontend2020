<?php

/**
 * @param $terminal Terminal
 * @param $environment EnvironmentInfo
 */
function onEnvironmentCreate($terminal, $environment) {
    add_to_log('Handled EnvironmentCreate "' . $environment->getDeviceHandler()->getDeviceName()
        . ':' . $environment->getActualUserName() . '"', getActualUserLogFilePath($terminal));

    foreach ($terminal->getDevices()->getHooks() as $hook) {
        $hook->onEnvironmentCreate($terminal, $environment);
    }
}


/**
 * @param $terminal Terminal
 * @param $environment EnvironmentInfo
 * @param $input string
 * @param $command TerminalCommand|null
 * @param $output array
 */
function onCommandHandled($terminal, $environment, $input, $command, &$output) {
    add_to_log('Handled Command "' . $input . '"', getActualUserLogFilePath($terminal));

    foreach ($terminal->getDevices()->getHooks() as $hook) {
        $hook->onCommandHandled($terminal, $environment, $input, $command, $output);
    }
}

/**
 * @param $terminal Terminal
 * @param $environment EnvironmentInfo
 * @param $welcomeText string
 */
function onGetWelcomeText($terminal, $environment, &$welcomeText) {
    add_to_log('Handled GetWelcomeText of "' . $environment->getActualUserName() . '@'
        . $environment->getDeviceHandler()->getDeviceName() . '"', getActualUserLogFilePath($terminal));

    foreach ($terminal->getDevices()->getHooks() as $hook) {
        $hook->onGetWelcomeText($terminal, $environment, $welcomeText);
    }
}

/**
 * @param $terminal Terminal
 * @param $environment EnvironmentInfo
 * @param $exitText string
 */
function onGetExitText($terminal, $environment, &$exitText) {
    add_to_log('Handled GetExitText of "' . $environment->getActualUserName() . '@'
        . $environment->getDeviceHandler()->getDeviceName() . '"', getActualUserLogFilePath($terminal));

    foreach ($terminal->getDevices()->getHooks() as $hook) {
        $hook->onGetExitText($terminal, $environment, $exitText);
    }
}
