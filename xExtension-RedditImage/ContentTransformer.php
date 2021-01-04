<?php

class ContentTransformer {
    const MATCH_REDDIT = 'reddit.com';

    private $displayImage;
    private $displayVideo;
    private $mutedVideo;
    private $displayOriginal;

    public function __construct(bool $displayImage, bool $displayVideo, bool $mutedVideo, bool $displayOriginal) {
        $this->displayImage = $displayImage;
        $this->displayVideo = $displayVideo;
        $this->mutedVideo = $mutedVideo;
        $this->displayOriginal = $displayOriginal;
    }

    public function transform($entry) {
        if (false === $this->isRedditLink($entry)) {
            return $entry;
        }

        if (null === $href = $this->extractOriginalContentLink($entry)) {
            return $entry;
        }

        // Add image tag in content when the href links to an image
        if (preg_match('#(jpg|png|gif|bmp)(\?.*)?$#', $href)) {
            $content = $this->getNewImageContent($href);
        // Add video tag in content when the href links to an imgur gifv
        } elseif (preg_match('#(?P<gifv>.*imgur.com/[^/]*.)gifv$#', $href, $matches)) {
            $content = $this->getNewVideoContent($matches['gifv']);
        // Add image tag in content when the href links to an imgur image
        } elseif (preg_match('#(?P<imgur>imgur.com/[^/]*)$#', $href)) {
            $href = "${href}.png";
            $content = $this->getNewImageContent($href);
        // Add video tag in content when the href links to a video
        } elseif (preg_match('#(?P<baseurl>.+)(webm|mp4)$#', $href, $matches)) {
            $content = $this->getNewVideoContent($matches['baseurl']);
        } else {
            $content = $this->getNewLinkContent($href);
        }

        if ($this->displayOriginal) {
            $content .= $entry->content();
        }

        $entry->_content($content);
        $entry->_link($href);

        return $entry;
    }

    /**
     * @return bool
     */
    private function isRedditLink($entry) {
        return (bool) strpos($entry->link(), static::MATCH_REDDIT);
    }

    /**
     * @return string|null
     */
    private function extractOriginalContentLink($entry) {
        if (preg_match('#<a href="(?P<href>[^"]*)">\[link\]</a>#', $entry->content(), $matches)) {
            return $matches['href'];
        }
    }

    /**
     * @return string|null
     */
    private function getNewImageContent($href) {
        if (!$this->displayImage) {
            return;
        }
        return <<<CONTENT
            <div class="reddit-image figure">
                <img src="{$href}" class="reddit-image"/>
            </div>
            CONTENT;
    }

    /**
     * @return string|null
     */
    private function getNewVideoContent($baseUrl) {
        if (!$this->displayVideo) {
            return;
        }
        $muted = $this->mutedVideo ? 'muted' : '';
        return <<<CONTENT
            <div class="reddit-image figure">
                <video controls preload="metadata" {$muted} class="reddit-image">
                    <source src="${baseUrl}webm" type="video/webm">
                    <source src="${baseUrl}mp4" type="video/mp4">
                </video>
            </div>
            CONTENT;
    }

    /**
     * @return string
     */
    private function getNewLinkContent($href) {
        return <<<CONTENT
            <p>
                <a href="{$href}">{$href}</a>
            </p>
            CONTENT;
    }
}