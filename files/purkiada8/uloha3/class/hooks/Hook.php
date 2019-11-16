<?php

interface Hook
{

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     */
    public function onEnvironmentCreate($terminal, $environment);

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @param $command TerminalCommand|null
     * @param $output array
     */
    public function onCommandHandled($terminal, $environment, $input, $command, &$output);

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $welcomeText string
     */
    public function onGetWelcomeText($terminal, $environment, &$welcomeText);

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $exitText string
     */
    public function onGetExitText($terminal, $environment, &$exitText);
}
