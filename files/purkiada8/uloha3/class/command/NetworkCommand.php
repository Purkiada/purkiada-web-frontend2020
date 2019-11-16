<?php

class NetworkCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'network';
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help', '--status' => 'status', '--connect' => 'connect'], true);
        if ($args['fail']) return array("result" => '<p>network: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>network - práce s internetovými připojeními</p>"
                . "<p>použití: network &lt;příkaz&gt; [&lt;název bezdrátové sítě&gt;]</p>"
                . "<p>Příkazy:</p>"
                . "<p>&nbsp;&nbsp;&nbsp;--status&nbsp;&nbsp;- vypíše stav všech připojení, volá se bez dalších parametrů</p>"
                . "<p>&nbsp;&nbsp;&nbsp;--connect&nbsp;- umožňuje připojit se k zadané bezdrátové síti</p>");
        }

        if ($args['switchArgs']['status'] + $args['switchArgs']['connect'] > 1) {
            return array('result' => "<p>network: Bylo zadáno příliš mnoho přepínačů, "
                . "použijte argument <b>'--help'</b> pro informace jak tento příkaz správně používat</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);

        if ($args['switchArgs']['status']) {
            switch ($textArgsCount) {
                case 0:
                    break;
                default:
                    return array('result' => "<p>network: Nesprávný počet argumentů: požadováno 0, ale obdrženo $textArgsCount</p>");
            }

            $result = '';
            $networks = resolveNetwork($terminal, $environment);
            foreach ($networks as $networkTypeName => $networkType) {
                foreach ($networkType as $networkId => $network) {
                    $result .= "<p>Rozhraní <b>'" . $networkTypeName . "'</b>:</p>";

                    $enabled = $network['enabled'];
                    $result .= "<p style='padding-left: 5em;'>" . 'Rozhraní <b>' . ($enabled ? 'je' : 'není') . '</b> připojeno</p>';
                    $result .= "<p style='padding-left: 5em;'>" . 'Stav připojení rozhraní <b>' . ($network['allowChange'] ? 'lze' : 'nelze') . '</b> měnit</p>';
                    if ($networkTypeName === 'Wi-Fi') {
                        if ($enabled) {
                            $result .= "<p style='padding-left: 5em;'>" . "Rozhraní je připojeno k Wi-Fi síti <b>'" . $network['info']->name . "'</b></p>";
                        } else {
                            $result .= "<p style='padding-left: 5em;'>Dostupné Wi-Fi sítě:</p>";
                            $result .= "<p style='padding-left: 10em;'>Wi-Fi síť <b>" . $network['info']->name . "</b> se zabezpečením <b>"
                                . ($network['info']->password === '' ? 'Žádné/Otevřená' : 'WPA2/PSK') . "</b></p>";
                        }
                    }

                    if ($enabled) {
                        $result .= "<p style='padding-left: 5em;'>" . 'Zařízení připojená ke stejné síti:</p>';
                        foreach ($network['lan'] as $networkAddress => $networkDevice) {
                            $result .= "<p style='padding-left: 10em;'>" . "Zařízení <b>"
                                . ($networkDevice instanceOf DeviceHandler ? $networkDevice->getDeviceName() : $networkDevice)
                                . "</b> s adresou <b>" . $networkAddress . "</b></p>";
                        }
                    }
                }

                $result .= '<br>';
            }

            return array('result' => $result, 'type' => 'status');
        } elseif ($args['switchArgs']['connect']) {
            switch ($textArgsCount) {
                case 1:
                    $wifiName = $textArgs[0];
                    break;
                default:
                    return array('result' => "<p>network: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
            }


            $networks = resolveNetwork($terminal, $environment);
            foreach ($networks as $networkTypeName => $networkType) {
                if ($networkTypeName !== 'Wi-Fi') continue;
                foreach ($networkType as $networkId => $network) {
                    if ($wifiName !== $network['info']->name) continue;

                    if ($network['enabled']) {
                        return array('result' => "<p>network: K této síti jste již připojeni</p>");
                    }

                    if (!$network['allowChange']) {
                        return array('result' => "<p>network: Nelze se připojit k této síti</p>");
                    }

                    if ($network['info']->password !== '') {//TODO: add support for connecting to password-secured networks
                        return array('result' => "<p>network: Připojení k zabezpečeným sítím momentálně není podporováno</p>");
                    }

                    $network['status']->enabled = true;
                    return array('result' => "<p>Úspěšně připojeno k síti <b>'$wifiName'</b></p>", 'type' => 'connect');
                }
            }

            return array('result' => "<p>network: Síť <b>'$wifiName'</b> nenalezena: Připojení se nezdařilo</p>");
        }

        return array('result' => "<p>network: Nebyl zadán žádný přepínač, "
            . "použijte argument <b>'--help'</b> pro informace jak tento příkaz správně používat</p>");
    }
}
