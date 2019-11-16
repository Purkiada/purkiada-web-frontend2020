<?php

class ChmodCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'chmod';
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
        if ($args['fail']) return array("result" => '<p>chmod: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>chmod - změna oprávnění pro přístup k souboru. Pro více informací použijte Google.</p>"
                . "<p>použití: chmod &lt;XXX&gt; &lt;soubor&gt;</p>"
                . "<p>Parametry: </p>"
                . "<p>&nbsp;&nbsp;&nbsp;&lt;XXX&gt; - tři čísla v rozsahu 4-7 nebo 0.</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 2:
                $newPermissions = $textArgs[0];
                $filePath = $textArgs[1];
                break;
            default:
                return array('result' => "<p>chmod: Nesprávný počet argumentů: požadováno 2, ale obdrženo $textArgsCount</p>");
        }

        $pathResult = resolvePath($filePath, $environment, true, true, true);
        if ($pathResult['fail']) {
            return array('result' => "<p>chmod: " . $pathResult['reason'] . "</p>");
        }

        $file = $pathResult['file'];
        if ($file == null) {
            return array('result' => "<p>chmod: Nelze měnit oprávnění kořenového adresáře</p>");
        }

        if (!validateShortFilePermissions($newPermissions)) {
            return array('result' => "<p>chmod: Zadaná oprávnění nejsou ve správném formátu</p>");
        }

        $file->permissions = $file->permissions[0] . $newPermissions;

        return array();
    }
}
