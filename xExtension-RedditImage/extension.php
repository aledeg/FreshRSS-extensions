<?php

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'AbstractTransformer.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'ContentTransformer.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'LinkTransformer.php';

class RedditImageExtension extends Minz_Extension {
    const DEFAULT_HEIGHT = 70;
    const DEFAULT_MUTEDVIDEO = true;
    const DEFAULT_DISPLAYIMAGE = true;
    const DEFAULT_DISPLAYVIDEO = true;
    const DEFAULT_DISPLAYORIGINAL = true;

    private $contentTransformer;
    private $linkTransformer;

    public function init() {
        $this->registerTranslates();

        $current_user = Minz_Session::param('currentUser');
        $filename = 'style.' . $current_user . '.css';
        $filepath = join_path($this->getPath(), 'static', $filename);

        if (file_exists($filepath)) {
            Minz_View::appendStyle($this->getFileUrl($filename, 'css'));
        }

        $this->getConfiguration();

        $this->contentTransformer = new ContentTransformer($this->display_image, $this->display_video, $this->muted_video, $this->display_original);
        $this->linkTransformer = new LinkTransformer();

        $this->registerHook('entry_before_display', array($this->contentTransformer, 'transform'));
        $this->registerHook('entry_before_insert', array($this->linkTransformer, 'transform'));
    }

    public function handleConfigureAction() {
        $this->registerTranslates();

        $current_user = Minz_Session::param('currentUser');
        $filename = 'configuration.' . $current_user . '.json';
        $filepath = join_path($this->getPath(), 'static', $filename);

        if (Minz_Request::isPost()) {
            $configuration = array(
                'imageHeight' => (int) Minz_Request::param('image-height', static::DEFAULT_HEIGHT),
                'mutedVideo' => (bool) Minz_Request::param('muted-video'),
                'displayImage' => (bool) Minz_Request::param('display-image'),
                'displayVideo' => (bool) Minz_Request::param('display-video'),
                'displayOriginal' => (bool) Minz_Request::param('display-original'),
            );
            file_put_contents($filepath, json_encode($configuration));
            file_put_contents(join_path($this->getPath(), 'static', "style.{$current_user}.css"), sprintf(
                'img.reddit-image, video.reddit-image {max-height:%svh;}',
                $configuration['imageHeight']
            ));
        }

        $this->getConfiguration();
    }

    private function getConfiguration() {
        $current_user = Minz_Session::param('currentUser');
        $filename = 'configuration.' . $current_user . '.json';
        $filepath = join_path($this->getPath(), 'static', $filename);

        $this->image_height = static::DEFAULT_HEIGHT;
        $this->muted_video = static::DEFAULT_MUTEDVIDEO;
        $this->display_image = static::DEFAULT_DISPLAYIMAGE;
        $this->display_video = static::DEFAULT_DISPLAYVIDEO;
        $this->display_original = static::DEFAULT_DISPLAYORIGINAL;
        if (file_exists($filepath)) {
            $configuration = json_decode(file_get_contents($filepath), true);
            if (array_key_exists('imageHeight', $configuration)) {
                $this->image_height = $configuration['imageHeight'];
            }
            if (array_key_exists('mutedVideo', $configuration)) {
                $this->muted_video = $configuration['mutedVideo'];
            }
            if (array_key_exists('displayImage', $configuration)) {
                $this->display_image = $configuration['displayImage'];
            }
            if (array_key_exists('displayVideo', $configuration)) {
                $this->display_video = $configuration['displayVideo'];
            }
            if (array_key_exists('displayOriginal', $configuration)) {
                $this->display_original = $configuration['displayOriginal'];
            }
        }
    }
}
