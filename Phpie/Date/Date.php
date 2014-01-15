<?php
/**
 * Date Component to work with Date
 *
 * @Author Shaharia Azam
 * @URI http://www.shahariaazam.com
 */

namespace Phpie\Date;


class Date
{
    public $timezone = 'Asia/Dhaka';

    public $format;

    public static $defaultFormat = 'm/d/y h:i:s';

    /**
     * Pre-defined global format constant for datetime format
     * @ref http://www.php.net/manual/en/class.datetime.php#datetime.synopsis
     * @var array
     */
    public static $formatConst = array(
        'ATOM' => "Y-m-d\TH:i:sP",
        'COOKIE' => "l, d-M-y H:i:s T",
        'ISO8601' => "Y-m-d\TH:i:sO",
        'RFC822' => "D, d M y H:i:s O",
        'RFC850' => "l, d-M-y H:i:s T",
        'RFC1036' => "D, d M y H:i:s O",
        'RFC1123' => "D, d M Y H:i:s O",
        'RFC2822' => "D, d M Y H:i:s O",
        'RFC3339' => "Y-m-d\TH:i:sP",
        'RSS' => "D, d M Y H:i:s O",
        'W3C' => "Y-m-d\TH:i:sP"
    );

    function __construct($timezone = null)
    {
        //To avoid warnings, we set timezone with our variable $timezone
        self::setTimezone($this->timezone);

        if(isset($timezone)){
            self::setTimezone($timezone);
        }

        $this->setFormat(self::$defaultFormat);
    }

    public function getFormat()
    {
        if(!isset($this->format)){
            $this->format = self::$defaultFormat;
        }
        return $this->format;
    }

    public function setFormat($format = null)
    {
        if(empty($format)){
            $this->format = self::$defaultFormat;
        }
        if(array_key_exists($format, self::$formatConst)){
            $this->format = self::$formatConst[$format];
        }else{
            $this->format = $format;
        }
    }

    public function setTimezone($timezone)
    {
        if(self::isValidTimezone($timezone) === true){
            $this->timezone = $timezone;
        }
        date_default_timezone_set($this->timezone);
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Timezone list with GMT offset
     * @return array
     */
    public static function timezoneList() {
        $timestamp = time();
        $zoneList = array();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zoneList[$key]['zone_name'] = $zone;
            $zoneList[$key]['gmt_offset'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zoneList;
    }

    /**
     * @param $timezone
     * @return bool
     */
    public function isValidTimezone($timezone) {
        $timezoneList = timezone_identifiers_list();
        return (bool)in_array($timezone, $timezoneList);
    }
} 