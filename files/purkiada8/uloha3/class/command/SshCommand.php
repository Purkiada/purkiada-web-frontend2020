<?php

class SshCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'ssh';
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
        if ($args['fail']) return array("result" => '<p>ssh: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>ssh - připojení ke vzdálenému zařízení</p>"
                . "<p>použití: ssh &lt;adresa&gt; [&lt;příkaz&gt;]</p>"
                . "<p>Parametry:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;&lt;adresa&gt; - Buďto ve formátu '10.0.0.0' nebo 'username@10.0.0.0' "
                . "kde username je uživatelské jméno účtu k přihlášení.</p>"
                . "<p>&nbsp;&nbsp;&nbsp;&lt;příkaz&gt; - Volitelný. "
                . "Příkaz, který bude na cílovem zařízení po úspěšném přihlášení zavolán. "
                . "Vychozí hodnota 'bash', který vyvolá spuštění terminálu na cílovém zařízení.</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $url = $textArgs[0];
                $command = 'bash';
                break;
            case 2:
                $url = $textArgs[0];
                $command = $textArgs[1];
                break;
            default:
                return array('result' => "<p>ssh: Nesprávný počet argumentů: požadováno 1 nebo 2, ale obdrženo $textArgsCount</p>");
        }

        $username = null;
        $urlExplode = explode('@', $url);
        if (count($urlExplode) == 2) {
            $username = $urlExplode[0];
            $url = $urlExplode[1];
        }

        $target = $this->resolveTargetByUrl($terminal, $environment, $url);
        if (!$target['valid']) {
            return array('result' => "<p>ssh: Připojit k hostu $url: Nenalezena cesta k hostovi</p>");
        }

        if (!($target['device'] instanceof DeviceHandler)) {
            return array('result' => "<p>ssh: Připojit k hostu $url: Host nepodporuje připojení ssh</p>");
        }

        if ($username !== null) {
            $result = processLogin($terminal, $target['device'], $username, '', $command);
            if (!$result['fail']) return $result['result'];
        }

        return array('result' => $terminal->addInputProcessorToTop(new LoginInputProcessor($this, $target['device'], $username, $command)));
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $url string
     * @return array bool|DeviceHandler|null
     */
    private function resolveTargetByUrl($terminal, $environment, $url) {
        $network = resolveNetwork($terminal, $environment);
        foreach ($network as $networkType) {
            foreach ($networkType as $networkEntry) {
                if (!$networkEntry['enabled']) continue;
                if (!isset($networkEntry['lan'][$url])) continue;
                return ['valid' => true, 'device' => $networkEntry['lan'][$url]];
            }
        }
        return ['valid' => false, 'device' => null];
    }
}
