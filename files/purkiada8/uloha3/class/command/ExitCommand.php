<?php

class ExitCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "exit";
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
        if ($args['fail']) return array("result" => '<p>exit: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>exit - ukončí terminál</p>"
                . "<p>použití: exit [přepínače]...</p>"
                . "<p>Přepínače:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;-f, --force - slouží pro ukončení zakladního (posledního) terminálu</p>");
        }

        $inputProcessor = $terminal->getTopInputProcessor();
        if (!($inputProcessor instanceof CommandsBash) || $inputProcessor->getEnvironmentInfo() !== $environment) {
            return array('result' => "<p>exit: Příkaz nebyl spuštěn z bashe, nelze provést požadovanou akci</p>");
        }

        if ($terminal->getInputProcessorsCount() <= 1) {
            if (!$args['switchArgs']['force']) {
                return array('result' => "<p>exit: Pokud opravdu chcete ukončit poslední spuštěný terminál "
                    . "(zpúsobí smazání historie terminálu) použíjte přepínač <b>'--force'</b> nebo <b>'-f'</b></p><br>");
            }

            unset($_SESSION['controlPanelTerminal']);
            return array('result' => $terminal->removeTopInputProcessor(),
                'inputType' => 'none', 'backupContent' => false, 'clear' => true);
        } else {
            $additionalResult = '';
            if ($args['switchArgs']['force']) {
                $additionalResult .= "<p>exit: Použití přepínače <b>'--force'</b> nebo <b>'-f'</b> není v této situaci vyžadováno</p><br>";
            }

            return array('result' => $additionalResult . $terminal->removeTopInputProcessor());
        }
    }
}
