<?php

require __DIR__ . '/EditFileInputProcessor.php';

class EditCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'edit';
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
        if ($args['fail']) return array("result" => '<p>edit: ' . $args['reason'] . '</p>');
        if ($args['switchArgs']['help']) {
            return array('result' => "<p>edit - úprava souboru</p>"
                . "<p>použití: edit &lt;soubor&gt;</p>");
        }

        $textArgs = $args['textArgs'];
        $textArgsCount = count($textArgs);
        switch ($textArgsCount) {
            case 1:
                $path = $textArgs[0];
                break;
            default:
                return array('result' => "<p>edit: Nesprávný počet argumentů: požadováno 1, ale obdrženo $textArgsCount</p>");
        }

        $fileInfo = array('permissions' => '-755');
        $createPathResult = createFile($path, $fileInfo, $environment, true, true, false, false);
        if ($createPathResult['fail']) {
            return array('result' => "<p>edit: " . $createPathResult['reason'] . "</p>");
        }

        $inputPrefix = $terminal->getInputPrefix();
        return array('result' => "<p>Editace souboru '" . $createPathResult['file']->name . "':</p>"
            . "<div class='file-edit-wrapper'>"
            . "<div class='file-edit-text' contentEditable='true'>" . implode($createPathResult['file']->content) . "</div><br>"
            . "<button class='file-edit-button file-edit-button-confirm' onclick='processEditConfirm()'>Save</button>"
            . "<button class='file-edit-button file-edit-button-cancel' onclick='processEditCancel()'>Cancel</button>"
            . "</div>" . $terminal->addInputProcessorToTop(new EditFileInputProcessor($createPathResult['path'], $environment)),
            'inputPrefix' => $inputPrefix, 'backupContent' => false);
    }
}
