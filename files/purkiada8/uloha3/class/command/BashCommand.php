<?php

class BashCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "bash";
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '--diff' => 'diff'], false);
        if ($args['fail']) return array("result" => '<p>bash: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array("result" => "<p>bash - spuštění terminálu</p>"
                . "<p>použití: bash</p><br>"

                . "<p><b>Popis fungování terminálu:</b></p>"
                . "<ol>"
                    . "<li><b>Celý terminál je case sensitive, což znamená, že rozlišuje malé a velké písmena, takže Help je něco jiného, než help.</b></li>"
                    . "<li>Zápis příkazů: název-příkazu [přepínače]... &lt;parametry&gt;<ol>"
                        . "<li>název-příkazu - Název příkazu, který bude zavolán</li>"
                        . "<li>[přepínače]... - Dělí se na dlouhé a krátké"
                        . "<ol>"
                            . "<li>Dlouhé: napřiklad <b>--help</b>; slovo začínající dvěmy pomlčkami</li>"
                            . "<li>Krátké: například <b>-f</b>; písmeno začínající pomlčkou; lze zapsat více za sebe například <b>-al</b> je to samé jako <b>-a -l</b></li>"
                        . "</ol>"
                        . "</li>"
                        . "<li>&lt;parametry&gt; - dodatečný text, se kterým příkaz pracuje; často cesta k souboru nebo složce; "
                            . "odděleny mezerami; pokud parametr obsahuje mezeru, tak musí být obalený úvozovkami, "
                            . "například <b>edit \"Můj soubor.txt\"</b> zavolá příkaz edit s jedním parametrem, "
                            . "ale <b>edit Můj soubor.txt</b> zavolá příkaz se dvěma parametry (Můj a soubor.txt), což způsobí chybu</li>"
                    . "</ol></li>"
                    . "<li>Našeptávač:<ol>"
                        . "<li><b>Tab:</b> při psaní příkazu dokončí příkaz, nebo vypíše všechny příkazy, které začínají na zadaný text; "
                            . " při psaní cesty k souboru nebo složce dokončuje cestu stejným způsobem, jako příkaz</li>"
                        . "<li><b>Šipka nahoru/dolů:</b> Zobrazí předchozí/další příkaz z historie</li>"
                    . "</ol></li>"
                    . "<li>Cesty k souborům:<ol>"
                        . "<li>Po přihlášení k systému je aktuálním adresářem domovská složka</li>"
                        . "<li>Nejvyžší adresář je /, cesta pak muže vypadat třeba takto /home/user</li>"
                        . "<li><b>.</b> - aktuální adresář, např. <b>./data.txt = soubor data.txt v aktuálním adresáři</b></li>"
                        . "<li><b>..</b> - adresář o úroveň výš, např. <b>/home/user/.. = /home</b>, umožňuje přes příkaz cd návrat aktuálního adresáře o úrveň výš</li>"
                        . "<li><b>~</b> - zastupuje domovský adresář, u každého účtu jiná sožka, např. <b>~ = /home/user</b></li>"
                        . "<li>V případě, že potřebujete zjistit, jaký je váš aktuální adresář, použijte příkaz pwd</li>"
                    . "</ol></li>"
                . "</ol>");
        }
        if ($args['switchArgs']['diff']) {
            return array("result" => "<p>Funguje:</p>"
                . "<ul>"
                . "<li>Příkazy</li>"
                . "<li>Parametry s mezerou (obalené \")</li>"
                . "<li>Naštěpávač (tab)</li>"
                . "<li>Historie příkazů na zařízení (šipka nahoru/dolů)</li>"
                . "<li>Obsah terminálu přečká obnovení stránky</li>"
                . "<li>Více terminálových prostředí běžících v sobě</li>"
                . "</ul>"
                . "<p>Nefunguje:</p>"
                . "<ul>"
                . "<li>Pipeline (|)</li>"
                . "<li>Předání výstupu/vstupu (> ani <)</li>"
                . "<li>Klávesové zkratky (například Ctrl+C, atd.)</li>"
                . "<li>Některé další vychytávky...</li>"
                . "</ul>");
        }

        return array("result" => $terminal->addInputProcessorToTop(new JsonBash(
            new EnvironmentInfo($terminal, $environment->getDeviceHandler(), $environment->getActualUserName()))));
    }
}
