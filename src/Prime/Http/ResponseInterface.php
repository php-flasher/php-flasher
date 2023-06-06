<?php

namespace Flasher\Prime\Http;

interface ResponseInterface
{
    /**
     * @return bool
     */
    public function isRedirection();

    /**
     * @return bool
     */
    public function isJson();

    /**
     * @return bool
     */
    public function isHtml();

    /**
     * @return bool
     */
    public function isAttachment();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent($content);
}
