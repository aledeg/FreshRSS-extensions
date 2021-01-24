<?php

class DateFormatExtension extends Minz_Extension {
    private $relative_dates;
    private $adjusted_dates;
    private $hour12_dates;

    const DEFAULT_RELATIVE_DATE = false;
    const DEFAULT_ADJUSTED_DATE = false;
    const DEFAULT_HOUR12_DATE = false;

    public function init() {
        $this->registerTranslates();
        $this->getConfiguration();

        $current_user = Minz_Session::param('currentUser');
        $filename = 'configuration.' . $current_user . '.js';
        $filepath = join_path($this->getPath(), 'static', $filename);

        if (file_exists($filepath)) {
            Minz_View::appendScript($this->getFileUrl($filename, 'js'));
        }
        Minz_View::appendScript($this->getFileUrl('moment-with-locales.js', 'js'));
        Minz_View::appendScript($this->getFileUrl('date-format.js', 'js'));
    }

    public function handleConfigureAction() {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            $configuration = [
                'relativeDates' => (bool) Minz_Request::param('relative-dates'),
                'adjustedDates' => (bool) Minz_Request::param('adjusted-dates'),
                'hour12Dates' => (bool) Minz_Request::param('hour12-dates'),
            ];

            $current_user = Minz_Session::param('currentUser');
            $filename = 'configuration.' . $current_user . '.json';
            $filepath = join_path($this->getPath(), 'static', $filename);
            file_put_contents($filepath, json_encode($configuration));

            $current_user = Minz_Session::param('currentUser');
            $filename = 'configuration.' . $current_user . '.js';
            $filepath = join_path($this->getPath(), 'static', $filename);
            file_put_contents($filepath, sprintf('const dateFormatConfiguration = %s;', json_encode($configuration)));
        }

        $this->getConfiguration();
    }

    public function __get($property) {
        return $this->$property;
    }

    private function getConfiguration() {
        $current_user = Minz_Session::param('currentUser');
        $filename = 'configuration.' . $current_user . '.json';
        $filepath = join_path($this->getPath(), 'static', $filename);

        $this->relative_dates = static::DEFAULT_RELATIVE_DATE;
        $this->adjusted_dates = static::DEFAULT_ADJUSTED_DATE;
        $this->hour12_dates = static::DEFAULT_HOUR12_DATE;
        if (file_exists($filepath)) {
            $configuration = json_decode(file_get_contents($filepath), true);
            if (array_key_exists('relativeDates', $configuration)) {
                $this->relative_dates = $configuration['relativeDates'];
            }
            if (array_key_exists('adjustedDates', $configuration)) {
                $this->adjusted_dates = $configuration['adjustedDates'];
            }
            if (array_key_exists('hour12Dates', $configuration)) {
                $this->hour12_dates = $configuration['hour12Dates'];
            }
        }
    }
}