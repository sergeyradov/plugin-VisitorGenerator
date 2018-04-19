<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\VisitorGenerator\Iterator;

class FileLineIterator implements \SeekableIterator
{
    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @var int
     */
    private $lineNumber;

    /**
     * @var string
     */
    private $currentLine;

    public function __construct($file)
    {
        $this->file = new \SplFileObject($file);
        $this->lineNumber = 0;
        $this->fetchCurrentLine();
    }

    public function current()
    {
        return $this->currentLine;
    }

    public function next()
    {
        ++$this->lineNumber;
        $this->fetchCurrentLine();
    }

    public function key()
    {
        return $this->lineNumber;
    }

    public function valid()
    {
        return $this->currentLine !== false;
    }

    public function rewind()
    {
        $this->file->fseek(0);
        $this->lineNumber = 0;
        $this->fetchCurrentLine();
    }

    public function seek($position)
    {
        $this->file->seek($position);
        $this->lineNumber = $position;
        $this->fetchCurrentLine();
    }

    public function close()
    {
        $this->file = null;
    }

    private function fetchCurrentLine()
    {
        if (!$this->file->eof()) {
            $this->currentLine = $this->file->fgets();
        } else {
            $this->currentLine = false;
        }
    }
}