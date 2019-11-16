<?php

class AIHook implements Hook
{
    private $visitedWelcomeTexts = [];
    private $visitedWifiConnectedText = false;
    private $visitedRouterNetworkStatusText = false;
    private $visitedSecuritySystemsDeactivatedText = false;

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     */
    public function onEnvironmentCreate($terminal, $environment)
    {
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
        if (!$this->visitedWifiConnectedText
            && $environment->getDeviceHandler()->getDeviceName() === 'ship'
            && $command instanceof NetworkCommand
            && $environment->getDeviceInfo()->network[0]->enabled) {
            if (!isset($output['result'])) $output['result'] = '';
            $output['result'] .= '<br>'
                . $this->makeAiText('Vypadá to, že se ti podařilo připojit k nějakému Wi-Fi hotspotu.')
                . $this->makeAiText("Wi-Fi hotspoty jsou známé tím, že se k nim mohou připojit různá zařízení aniž by se musely fyzicky k těmto zařizením připojit.")
                . $this->makeAiText("Většinu takovýchto sítí vytvářejí takzvané Směrovače (Routery). O její případné rozšíření se pak starají Opakovače (Repeatery).")
                . $this->makeAiText("K těmto zařízením se dá připojit přímo ze sítě, kterou vytvářejí a to mimo jiné pomocí příkazu <b>ssh</b>, "
                    . "ale jejich adresa se mění síť od sítě, proto je ji potřeba před připojením zjistit. "
                    . "Seznam všech zařízení v síti dokáže zobrazit příkaz <b>network</b>.")
                . $this->makeAiText("Zároveň většina výrobců přednastavuje na těchto zařízeních výchozí přihlašovací jméno i heslo na <b>admin</b>, "
                    . "s tím, že uživatel může tyto přihlašovací údaje změnit.")
                . $this->makeAiText("To je vše, co moje databáze obsahuje o sítích Wi-Fi, snad se ti tyto informace budou k něčemu hodit.");
            $this->visitedWifiConnectedText = true;
        } elseif (!$this->visitedRouterNetworkStatusText
            && $environment->getDeviceHandler()->getDeviceName() === 'WFADevice'
            && $command instanceof NetworkCommand
            && isset($output['type']) && $output['type'] === 'status') {
            if (!isset($output['result'])) $output['result'] = '';
            $output['result'] .= '<br>'
                . $this->makeAiText('Vypadá to, že se na jedné ze sítí nachází hlavní Server bitevní stanice.')
                . $this->makeAiText("Pokud se ti na něj podaří přihlásit jako uživatel <b>root</b> (Účet s právy administrátora), tak máme vyhráno.")
                . $this->makeAiText("Občas na linuxových zařízeních bývá účet pro návštevy, takzvaný <b>guest</b> účet");
            $this->visitedRouterNetworkStatusText = true;
        } elseif (!$this->visitedSecuritySystemsDeactivatedText
            && $environment->getDeviceHandler()->getDeviceName() === 'sw.death-star'
            && $command instanceof SecurityCommand
            && isset($output['type']) && $output['type'] === 'deactivate') {
            if (!isset($output['result'])) $output['result'] = '';
            $output['result'] .= '<br>'
                . $this->makeAiText('Vypadá to, že se ti podařilo deaktivovat veškeré ochrané systémy bitevní stanice.')
                . $this->makeAiText('Nejspíš jim dá chvilku zabrat, než ochrané systémy zase aktivují. ;]')
                . $this->makeAiText('Spouštím autopilotní režim a nastavuji cílovou destnaci na opačnou stranu galaxie. Ať už jsme odtud pryč...')

                . '<br><p><b>Závěrečná Legenda</b> (aneb <b><i>"Čehopak jsem to vlastně dosáhl?"</i></b>):</p>'
                . '<p>Uspěšně jsi dokončil úkol a dokázal jsi celé posádce, že jsi přesně tím členem posádky, kterého potřebovali.</p>'
                . '<p>Ihned poté, co se deaktivovalo ochrané magnetické pole vaše loď vyrazila pokračovat ve své misi.</p>'

                . '<br><p style="color: lightgreen"><b>Tímto jste dokončili úlohu č. 3.</b></p>'

                . '<br><p>PS od Vývojáře: V první řadě vám děkuji za výdrž při čtení textů, kterých nebylo v této úloze pomálu, '
                . 'zároveň doufám, že jste StarWars nikdy neviděli a nevšimnete si tak "drobných" nesrovnalostí s reálným (správným) příbehem.</p>'
                . '<p>Také doufám, že jste si plnění této úlohy užili, že vám dala něco do života a '
                . 'že jste se dozvěděli alespoň něco málo o linuxovém terminálu či o linuxu samotném.</p>'

                . '<br><p><b>Terminál byl ukončen.</b></p>';
            $output['inputType'] = 'none';
            $output['backupContent'] = false;
            unset($_SESSION['controlPanelTerminal']);
            $this->visitedSecuritySystemsDeactivatedText = true;
        }
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $welcomeText string
     */
    public function onGetWelcomeText($terminal, $environment, &$welcomeText)
    {
        $welcomeTextId = $environment->getDeviceHandler()->getDeviceName() . ':' . $environment->getActualUserName();

        if (!isset($this->visitedWelcomeTexts[$welcomeTextId]) || !$this->visitedWelcomeTexts[$welcomeTextId]) {
            switch ($welcomeTextId) {
                case 'ship:user':
                    $welcomeText .= '<br>' . $this->makeAiText('Vítám tě, jmenuji se Startana.')
                        . $this->makeAiText('Jsem umělá ineligence speciálně vivinutá pro pomoc s létáním ve vesmírných lodích.')
                        . $this->makeAiText('Veškeré informace ti budu předávat pomocí takto vypadajích textů '
                        . '(moje texty budou vždy začínat znaky "//" a vždy budou modré).')
                        . '<br>'
                        . $this->makeAiText('Initializace systému...')
                        . $this->makeAiText('Kontrola stavu lodi...')
                        . $this->makeAiText("Byl detekován problém (kód 0xFE79): "
                            . "<span style='color: lightcoral'>loď je v nebezpečné blízkosti nepřátelské bitevní stanice</span>")
                        . $this->makeAiText('Hledám řešení...')
                        . $this->makeAiText('Hledání řešení nepřineslo <b>žádné výsledky</b>.')
                        . $this->makeAiText('<b>Problém</b> s kódem <b>0xFE79</b> byl <b>označen za krytický</b>.')
                        . $this->makeAiText('Tento problém boužel nelze vyřešit automaticky, řešení je nyní na tobě.')
                        . $this->makeAiText('Vypadá to, že bitevní stanice vytváří síťovou komunikaci v našem okolí, zkus to prověřit.')
                        . $this->makeAiText("Použíj k tomu příkazovou řádku systému, příkaz <b>network</b> by ti měl s tím pomoci.");
                    break;
                case 'TL-WA850RE:admin':
                    $welcomeText .= '<br>' . $this->makeAiText('Vypadá to, že se ti podařilo připojit k Opakovači.')
                        . $this->makeAiText('Spouštím prohledávání Opakovače...')
                        . $this->makeAiText('Prohledávám Opakovač...')
                        . $this->makeAiText('Na opakovači jsem nalezla zapnutou historii přenesených dat.')
                        . $this->makeAiText('Získávám z Opakovače historii přenesených dat...')
                        . $this->makeAiText("V historii přenesených dat se mi podařilo najít několik nešifrovaných pokusů o připojení k zařízení <b>WFADevice</b>. "
                            . "Pokaždé bylo použito přihlašovací jméno <b>admin</b> a heslo <b>deathStarIsBest</b>. Možná by se ti mohly tyto informace hodit.");
                    break;
                case 'WFADevice:admin':
                    $welcomeText .= '<br>' . $this->makeAiText('Vypadá to, že se ti podařilo připojit ke Směrovači.')
                        . $this->makeAiText('Spouštím prohledávání Směrovače...')
                        . $this->makeAiText('Prohledávám Směrovač...')
                        . $this->makeAiText('Na směrovači jsem nalezla další připojené sítě, ale jinak nic zajímavého.');
                    break;
                case 'sw.death-star:guest':
                    $welcomeText .= '<br>' . $this->makeAiText("Vypadá to, že se ti podařilo připojit k hlavnímu Serveru bitevní stanice jako uživatel <b>guest</b>.")
                        . $this->makeAiText('Spouštím prohledávání Serveru...')
                        . $this->makeAiText('Nepodařilo se mi spustit prohledávání Serveru, něco mi brání v práci.')
                        . $this->makeAiText('Nejspíš jsou na tomto serveru špatně nastavená oprávnění k některým důležitým souborům.')
                        . $this->makeAiText('Vypadá to, že si budeš muset poradit sám.')
                        . $this->makeAiText("Hlavně pamatuj, že se musíš přihlásit k tomuto serveru jako uživatel <b>root</b> (použij příkaz <b>su</b>).")
                        . $this->makeAiText('Kde by se dalo získat přístupové heslo nevím, ale zkus prohledat, co zvládneš.')
                        . $this->makeAiText('Pokud nevíš nic o linuxových oprávnění přístupu k souborům, '
                            . 'tak si o nich něco počti, jsou zajímavé, ale při špatné práci s nimy můžou vzniknout '
                            . 'celkem nehezké bezpečnostní díry a to většinou nedopadá úplně dobře...');
                    break;
                case 'sw.death-star:root':
                    $welcomeText .= '<br>' . $this->makeAiText("Vypadá to, že se ti podařilo přihlásit k hlavnímu Serveru bitevní stanice jako uživatel <b>root</b>.")
                        . $this->makeAiText('Rychle deaktivuj ochrané systémy, než bude pozdě!');
                    break;
            }
            $this->visitedWelcomeTexts[$welcomeTextId] = true;
        }
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $exitText string
     */
    public function onGetExitText($terminal, $environment, &$exitText)
    {
    }

    private function makeAiText($text) {
        return "<p style='color: deepskyblue'>//" . $text . "</p>";
    }
}
