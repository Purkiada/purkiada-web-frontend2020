<?php

class HelpCommand implements TerminalCommand
{

    /**
     * @return string
     */
    public function getName()
    {
        return "help";
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, [], false);
        if ($args['fail']) return array("result" => '<p>help: ' . $args['reason'] . '</p>');

        $commands = $environment->getCommands();
        $maxNameLen = 10;
        foreach ($commands as &$command) {
            $maxNameLen = max($maxNameLen, strlen($command->getName()));
        }

        $result = "<p>Pro informace o některém z příkazů zadejte <b>'názevPříkazu --help'</b>. Dostupné příkazy:</p><p>";
        foreach ($commands as &$command) {
            $name = htmlspecialchars($command->getName());
            $result .= ' ' . $name;
            while (strlen($name) < $maxNameLen) {
                $name .= ' ';
                $result .= '&nbsp;';
            }
        }
        $result .= '</p>';

        return array("result" => $result);
    }
}
