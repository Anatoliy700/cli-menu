<?php
declare(ticks=1);
namespace MikeyMike\CliMenu\Terminal;

/**
 * Class UnixTerminal
 * @author Michael Woodward <mikeymike.mw@gmail.com>
 */
class UnixTerminal implements TerminalInterface
{
    /**
     * @var bool
     */
    private $isTTY;

    /**
     * @var int
     */
    private $width;

    /**
     * @var string
     */
    private $details;

    /**
     * @var string
     */
    private $originalConfiguration;

    /**
     * Initialise the terminal from resource
     *
     */
    public function __construct()
    {
        $this->getOriginalConfiguration();
    }

    /**
     * Kill the application
     *
     * @return void
     */
    public function killProcess()
    {
        $this->setRawMode(false);

//        posix_kill(posix_getpid(), SIGKILL);
    }

    /**
     * Get the available width of the terminal
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width ?: $this->width = exec('tput cols');
    }

    /**
     * Get the available height of the terminal
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->width ?: $this->width = exec('tput lines');
    }

    /**
     * Get terminal details
     *
     * @return string
     */
    public function getDetails()
    {
        return 'some fucking shell init bro';
//        return $this->details ?: $this->details = posix_ttyname(STDOUT);
    }

    private function getOriginalConfiguration()
    {
        return $this->originalConfiguration ?: $this->originalConfiguration = system('stty -g');
    }

    /**
     * Toggle raw mode on TTY
     *
     * @param bool $useRaw
     */
    public function setRawMode($useRaw = true)
    {
        $useRaw ? system('stty -icanon') : system('stty ' . $this->getOriginalConfiguration());
    }

    /**
     * Check if TTY is in raw mode
     *
     * @return bool
     */
    public function isRaw()
    {
        // TODO: Implement isRaw() method.
    }

    /**
     * Test whether terminal is valid TTY
     *
     * @return bool
     */
    public function isTTY()
    {
        return true;
//        return $this->isTTY ?: $this->isTTY = posix_isatty(STDOUT);
    }

    /**
     * Clear the terminal window
     */
    public function clear()
    {
        echo "\033[1J";
    }

    /**
     * Toggle cursor display
     */
    public function toggleCursor()
    {
        echo "\e[?25l";
    }

    /**
     * Toggle cursor display
     */
    public function disableCursor()
    {
        echo "\e[?25l";
    }

    /**
     * @return string
     */
    public function getKeyedInput()
    {
        // TODO: Move to class var?
        // TODO: up, down, enter etc in Abstract CONSTs
        $map = [
            "\033[A" => 'up',
            "\033[B" => 'down',
            "\n"     => 'enter',
            "\r"     => 'enter',
            " "      => 'enter',
        ];

        $input = fread(STDIN, 4);
        echo "\r      ";

        pcntl_signal_dispatch();

        return array_key_exists($input, $map)
            ? $map[$input]
            : $input;
    }

    /**
     * Move the cursor to the top left of the window
     *
     * @return void
     */
    public function moveCursorToTop()
    {
        echo "\033[H";
    }
}