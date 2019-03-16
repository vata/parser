<?php

namespace App\Http\Controllers;

class ConsoleCommand extends \Illuminate\Console\Command
{
    protected $name = 'NONEXISTENT';
    protected $hidden = true;

    public $outputSymfony;
    public $outputStyle;

    public function __construct($argInput = null)
    {
        parent::__construct();

        $this->input = new \Symfony\Component\Console\Input\StringInput($argInput);

        $this->outputSymfony = new \Symfony\Component\Console\Output\ConsoleOutput();
        $this->outputStyle = new \Illuminate\Console\OutputStyle($this->input, $this->outputSymfony);

        $this->output = $this->outputStyle;
    }

}