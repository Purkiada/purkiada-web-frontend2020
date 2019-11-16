<?php

class AliasCommand implements TerminalCommand
{

    /**
     * @var string
     */
    private $alias;
    /**
     * @var string
     */
    private $target;

    /**
     * AliasCommand constructor.
     * @param $alias string
     * @param $target string
     */
    public function __construct($alias, $target)
    {
        $this->alias = $alias;
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->alias;
    }

    /**
     * @param $terminal Terminal
     * @param $environment EnvironmentInfo
     * @param $input string
     * @return array string
     */
    public function doCommand($terminal, $environment, $input)
    {
        $args = resolveArgs($input, ['--help' => 'help'], false);
        if (!$args['fail'] && $args['switchArgs']['help']) {
            return array('result' => "<p><b>'$this->alias'</b> zastupuje příkaz <b>'$this->target'</b>.</p><br>");
        }

        $result = $environment->executeCommand($terminal, $this->target . ' ' . $input);
        return $result;
    }
}
