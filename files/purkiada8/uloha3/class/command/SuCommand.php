<?php

class SuCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'su';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help'], true);
        if ($args['fail']) return array("result" => '<p>su: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>su - umožňuje se přihlásit na jiný uživatelský účet na aktuálním zařízení</p>"
                . "<p>použití: su &lt;uživatelské jméno&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $username = $textArgs[0];
                $command = 'bash';
                break;
            case 2:
                $username = $textArgs[0];
                $command = $textArgs[1];
                break;
            default:
                return array('result' => "<p>su: Nesprávný počet argumentů: požadováno 1 nebo 2, ale obdrženo $textArgsCount</p>");
        }

        if ($username != null) {
            $result = processLogin($terminal, $environment->getDeviceHandler(), $username, '', $command);
            if (!$result['fail']) return $result['result'];
        }

        return array('result' => $terminal->addInputProcessorToTop(new LoginInputProcessor($this, $environment->getDeviceHandler(), $username, $command)));
    }
}
