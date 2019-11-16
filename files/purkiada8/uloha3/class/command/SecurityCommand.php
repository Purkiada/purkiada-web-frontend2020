<?php

class SecurityCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'security';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '--status' => 'status',
            '--deactivate' => 'deactivate', '--activate' => 'activate'], false);
        if ($args['fail']) return array("result" => '<p>security: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>security - správa bezpečnostních a ochranných systémů</p>"
                . "<p>použití: network &lt;příkaz&gt;</p>"
                . "<p>Příkazy:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;--status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- vypíše stav bezpečnostních a ochranných systémů</p>"
                . "<p>&nbsp;&nbsp;&nbsp;--activate&nbsp;&nbsp;&nbsp;- aktivuje bezpečnostní a ochranné systémy</p>"
                . "<p>&nbsp;&nbsp;&nbsp;--deactivate&nbsp;- deaktivuje bezpečnostní a ochranné systémy</p>");
        }

        if ($args['switchArgs']['status'] + $args['switchArgs']['deactivate'] + $args['switchArgs']['activate'] > 1) {
            return array('result' => "<p>security: Bylo zadáno příliš mnoho přepínaču, "
                . "použijte argument <b>'--help'</b> pro informace jak tento příkaz správně používat</p>");
        }

        if ($args['switchArgs']['status']) {
            return array('result' => '<p>Všechny bezpočnostní a ochranné systémy jsou aktivonané a připravené k akci.</p>',
                'type' => 'status');
        } elseif ($args['switchArgs']['activate']) {
            return array('result' => '<p>Bezpočnostní a ochranné systémy již jsou aktivovány. Nebyly provedeny žádné změny.</p><br>',
                'type' => 'activate');
        } elseif ($args['switchArgs']['deactivate']) {
            return array('result' => '<p>Bezpočnostní a ochranné systémy byly deaktivovány.</p><br>'
                . '<p style="color: lightcoral;"><b>POZOR: Všem jednotkám, bylo detekováno narušeni bezpočnosti!<br>'
                . 'Opakuji, bylo detekováno narušeni bezpočnosti!</b></p>',
                'type' => 'deactivate');
        }

        return array('result' => "<p>security: Nebyl zadán žádný přepínač, "
            . "použijte argument <b>'--help'</b> pro informace jak tento příkaz správně používat</p>");
    }
}
