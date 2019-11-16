<?php

class RevertTimeCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'revert-time';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '-f' => 'force', '--force' => 'force'], false);
        if ($args['fail']) return array("result" => '<p>revert-time: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>revert-time - navrátí úlohu do původního stavu, zahodí veškerý vaš postup v úloze</p>"
                . "<p>použití: revert-time [přepínače]...</p>"
                . "<p>Přepínače:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;-f - potvrdí, že skutečně chcete vymazat stav úlohy</p>");
        }

        if (!$args['switchArgs']['force']) {
            return array('result' => "<p><span style='color: lightcoral'><b>POZOR</b></span>: "
                . "Tento příkaz <span style='color: lightcoral'>smaže veškerý Váš postup v úkolu</span> a umožní Vám začít znovu.</p>"
                . "<p>Je určený pro případy, kdy se vám podaří poškodit, nebo smazat některá data, která jsou potřeba pro úspěšné dokončení úkolu.</p>"
                . "<p><span style='color: lightcoral'>Efekt tohoto příkazu je nevratný!</span></p><br>"
                . "<p>Pokud opravdu chcete provést tento příkaz, tak spusťte tento příkaz znovu s parametrem <b>'--force'</b> nebo <b>'-f'</b>.</p>");
        }

        $devices = $terminal->getDevices();
        $loginId = $devices->getLoginID();
        $terminal->resetInputProcessorsStack();
        $devices->resetActualUserDevices();
        unset($_SESSION['controlPanelTerminal']);
        return array('result' => "<p>Vekerá data uživatele $loginId byla obnovena do počátečního stavu.</p>"
            . "<p><b>Obnovte prosím prohlížeč</b> a znovu se přihlaste, pokud chcete začít plnit úkol znovu.</p>",
            'inputType' => 'none', 'backupContent' => false);
    }
}
