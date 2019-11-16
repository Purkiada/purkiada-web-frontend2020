<?php

class StartupLoginInputProcessor implements InputProcessor
{

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getWelcomeText($terminal)
    {
        $welcomeText = "<p>Pro pokračování zadejte prosím vaše <b>uživatelské jméno (loginID)</b>.</p><br>"

            . "<p>Pro ukončení terminálu, vyčištění historie terminálu a resetování systému (může vyřešit případné problémy)"
            . " zadejte místo uživatelského jména <b>'exit --force'</b> nebo <b>'exit -f'</b>.</p>"
            . "<p>Pokud se Vám nedaří přihlásit, kvůli <i>\"chybě serveru\"</i>, zavolejte si někoho na pomoc, "
            . "nejspíše se vám podařilo poškodit váš systém.</p>";

        if (TEST_MODE_ENABLED) {
            $welcomeText = "<h4 style='color: lightcoral'><b>Pro vstup v testovacím módu použijte zadajte 'mode.test.testUserName' "
                . "a nahraďte 'testUserName' jakýmkoli textem, který ještě nikdo nepoužil. "
                . "V testovacím módu jsou veškeré změny při přihlášení vráceny do původního stavu. "
                . "(Postup v úkolu není zachván.)</b></h4><br>" . $welcomeText;
        }
        return $welcomeText;
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getExitText($terminal)
    {
        return "<p>Terminál byl ukončen. (Pro znovu spuštění terminálu obnovte stránku.)</p>";
    }

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputPrefix($terminal)
    {
        $terminal->getDevices()->prepareDevicesForUser(null);
        return "<span style='color: yellow'>Uživatelské jméno (loginID):&nbsp;</span>";
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
        $input = trim($input);
        if (!empty($input) && ($input == 'exit --force' || $input == 'exit -f')) {

            unset($_SESSION['controlPanelTerminal']);
            return array('result' => $terminal->removeTopInputProcessor(),
                'inputType' => 'none', 'backupContent' => false, 'clear' => true);
        }

        if (!empty($input) && substr($input, 0, strlen('revert-time')) === 'revert-time') {
            $args = resolveArgs(substr($input, strlen('revert-time')), ['-f' => 'force', '--force' => 'force'], true);
            if (!$args['fail'] && $args['switchArgs']['force'] && count($args['textArgs']) == 1) {
                $devices = $terminal->getDevices();
                $loginID = $args['textArgs'][0];
                $devices->resetTargetUserDevices($loginID);
                return array('result' => "<p>Vekerá data uživatele $loginID byla obnovena do počátečního stavu.</p>");
            }
        }

        $allowLogin = false;

        $testModeCode = 'mode.test.';
        $testModeCodeLen = strlen($testModeCode);
        if (TEST_MODE_ENABLED
            && !empty($input) && !containsAny($input, [' '])
            && substr($input, 0, $testModeCodeLen) === $testModeCode
            && $testModeCodeLen < strlen($input)) {

            $terminal->getDevices()->resetTargetUserDevices($input);
            $allowLogin = true;
        }

        if (DATABASE_ACCOUNTS_ENABLED && !$allowLogin) {
            include(__DIR__ . '/../../include/database.php');
            $stmt = $conn->prepare("SELECT * FROM `purkiada` WHERE `login` = ?");
            $stmt->execute(array($input));
            $allowLogin = count($stmt->fetchAll()) == 1;
        }

        if($allowLogin) {
            if (isAllObjectivesCompleted($input)) {
                add_to_log('User ' . $input . ' tried to login after completing all objectives.');
                add_to_log('User ' . $input . ' tried to login after completing all objectives.', getUserLogFilePath($input));
                return array('return' => '<p>Již jsi dokončil tuto ulohu. Znovuspuštění terminálu by mohlo poškodit '
                    . 'tvůj dosažený postup. Pokud potřebuješ vyřešit nějaký problém, tak si zavolej někoho z dozoru.</p>');
            } else {
                $restored = $terminal->getDevices()->prepareDevicesForUser($input);
                add_to_log('User ' . $input . ' logged in.');
                add_to_log('User ' . $input . ' logged in.', getUserLogFilePath($input));
                return array('result' => "<p><span style='color: steelblue'>Uživatel <b>$input</b> byl úspěšně přihlášen.</span></p><br>"
                    . $terminal->addInputProcessorToTop(!$restored ? new WelcomeInputProcessor()
                        : new JsonBash(new EnvironmentInfo($terminal, $terminal->getDevices()->getDeviceHandlerByName('ship'), 'user'))),
                    'clear' => true);
            }
        }

        add_to_log('Unsuccessful login try with username ' . $input . '.');
        return array('result' => '<p>Nesprávné uživatelské jméno (loginId)!</p>');
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @return array
     */
    public function handleTab($terminal, $actualInputValue)
    {
        return array();// StartupLoginInputProcessor don't support tab key
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @param $offset int
     * @return array
     */
    public function handleUpDown($terminal, $actualInputValue, $offset)
    {
        return array();// StartupLoginInputProcessor don't support up/down arrows
    }
}
