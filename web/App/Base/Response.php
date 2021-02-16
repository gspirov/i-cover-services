<?php

namespace App\Base;

abstract class Response
{
    /**
     * @var string $content
     */
    protected string $content;

    abstract public function send();

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}