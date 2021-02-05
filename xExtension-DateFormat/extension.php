<?php

class DateFormatExtension extends Minz_Extension {
    const DEFAULT_RELATIVE_DATE = false;
    const DEFAULT_ADJUSTED_DATE = false;
    const DEFAULT_HOUR12_DATE = false;
    const DEFAULT_CUSTOM_FORMAT = null;

    public function init() {
        $this->registerTranslates();

        Minz_View::appendScript($this->getFileUrl('moment-with-locales.js', 'js'));
        Minz_View::appendScript($this->getFileUrl('date-format.js', 'js'));

        $this->registerHook('js_vars', [$this, 'addVariables']);
    }

    public function addVariables($vars) {
        $vars[$this->getName()]['configuration'] = [
            'relativeDates' => $this->getRelativeDates(),
            'adjustedDates' => $this->getAdjustedDates(),
            'hour12Dates' => $this->getHour12Dates(),
            'customFormat' => $this->getCustomFormat(),
        ];

        return $vars;
    }

    public function handleConfigureAction() {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            $configuration = [
                'relativeDates' => (bool) Minz_Request::param('relative-dates'),
                'adjustedDates' => (bool) Minz_Request::param('adjusted-dates'),
                'hour12Dates' => (bool) Minz_Request::param('hour12-dates'),
                'customFormat' => Minz_Request::param('custom-format'),
            ];
            $this->setUserConfiguration($configuration);
        }
    }

    public function getRelativeDates() {
        return $this->getUserConfigurationValue('relativeDates', static::DEFAULT_RELATIVE_DATE);
    }

    public function getAdjustedDates() {
        return $this->getUserConfigurationValue('adjustedDates', static::DEFAULT_ADJUSTED_DATE);
    }

    public function getHour12Dates() {
        return $this->getUserConfigurationValue('hour12Dates', static::DEFAULT_HOUR12_DATE);
    }

    public function getCustomFormat() {
        return $this->getUserConfigurationValue('customFormat', static::DEFAULT_CUSTOM_FORMAT);
    }
}