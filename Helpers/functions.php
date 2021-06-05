<?php

if (!function_exists('array_keys_merge')) {
    /**
     * @param array $array
     * @return array
     */
    function array_keys_merge(array $array): array
    {
        $result = [];
        foreach ($array as $value) {
            $result = array_merge($result, $value);
        }

        return $result;
    }
}

if (!function_exists('slug')) {
    /**
     * @param string $title
     * @param string $separator
     * @param string $language
     * @return string
     */
    function slug(string $title, string $separator = '-', string $language = ''): string
    {
        if (!$language) {
            $language = config('app.locale', 'en');
        }

        return \Illuminate\Support\Str::slug($title, $separator, $language);
    }
}

if (!function_exists('getClientIp')) {
    /**
     * @return string
     */
    function getClientIp(): string
    {
        $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        foreach ($keys as $k) {
            if (!empty(request()->server($k)) && filter_var(request()->server($k), FILTER_VALIDATE_IP)) {
                return request()->server($k);
            }
        }
        return 'Unknown';
    }
}

if (!function_exists('getClientOS')) {
    /**
     * @param string $userAgent
     * @return string
     */
    function getClientOS(string $userAgent = ''): string
    {
        if (!$userAgent) {
            $userAgent = request()->header('User-Agent');
        }

        // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
        $osArray = [
            'windows nt 10'                             => 'Windows 10',
            'windows nt 6.3'                            => 'Windows 8.1',
            'windows nt 6.2'                            => 'Windows 8',
            'windows nt 6.1|windows nt 7.0'             => 'Windows 7',
            'windows nt 6.0'                            => 'Windows Vista',
            'windows nt 5.2'                            => 'Windows Server 2003/XP x64',
            'windows nt 5.1'                            => 'Windows XP',
            'windows xp'                                => 'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000' => 'Windows 2000',
            'windows me'                                => 'Windows ME',
            'windows nt 4.0|winnt4.0'                   => 'Windows NT',
            'windows ce'                                => 'Windows CE',
            'windows 98|win98'                          => 'Windows 98',
            'windows 95|win95'                          => 'Windows 95',
            'win16'                                     => 'Windows 3.11',
            'mac os x 10.1[^0-9]'                       => 'Mac OS X Puma',
            'macintosh|mac os x'                        => 'Mac OS X',
            'mac_powerpc'                               => 'Mac OS 9',
            'linux'                                     => 'Linux',
            'ubuntu'                                    => 'Linux - Ubuntu',
            'iphone'                                    => 'iPhone',
            'ipod'                                      => 'iPod',
            'ipad'                                      => 'iPad',
            'android'                                   => 'Android',
            'blackberry'                                => 'BlackBerry',
            'webos'                                     => 'Mobile',

            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})' => 'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})'             => 'Windows',
            '(win)([0-9]{2})'                            => 'Windows',
            '(windows)([0-9x]{2})'                       => 'Windows',

            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg

            'Win 9x 4.90'                                           => 'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})'                     => 'Windows',
            'win32'                                                 => 'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'            => 'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'               => 'Solaris',
            'dos x86'                                               => 'DOS',
            'Mac OS X'                                              => 'Mac OS X',
            'Mac_PowerPC'                                           => 'Macintosh PowerPC',
            '(mac|Macintosh)'                                       => 'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'                  => 'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'                   => 'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})'                     => 'RISC OS',
            'unix'                                                  => 'Unix',
            'os/2'                                                  => 'OS/2',
            'freebsd'                                               => 'FreeBSD',
            'openbsd'                                               => 'OpenBSD',
            'netbsd'                                                => 'NetBSD',
            'irix'                                                  => 'IRIX',
            'plan9'                                                 => 'Plan9',
            'osf'                                                   => 'OSF',
            'aix'                                                   => 'AIX',
            'GNU Hurd'                                              => 'GNU Hurd',
            '(fedora)'                                              => 'Linux - Fedora',
            '(kubuntu)'                                             => 'Linux - Kubuntu',
            '(ubuntu)'                                              => 'Linux - Ubuntu',
            '(debian)'                                              => 'Linux - Debian',
            '(CentOS)'                                              => 'Linux - CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'     => 'Linux - SUSE',
            '(Dropline)'                                            => 'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)'                                            => 'Linux - ASPLinux',
            '(Red Hat)'                                             => 'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)'                                               => 'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'                     => 'AmigaOS',
            'amiga-aweb'                                            => 'AmigaOS',
            'amiga'                                                 => 'Amiga',
            'AvantGo'                                               => 'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}'                    => 'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'                      => 'WebTV',
            'Dreamcast'                                             => 'Dreamcast OS',
            'GetRight'                                              => 'Windows',
            'go!zilla'                                              => 'Windows',
            'gozilla'                                               => 'Windows',
            'gulliver'                                              => 'Windows',
            'ia archiver'                                           => 'Windows',
            'NetPositive'                                           => 'Windows',
            'mass downloader'                                       => 'Windows',
            'microsoft'                                             => 'Windows',
            'offline explorer'                                      => 'Windows',
            'teleport'                                              => 'Windows',
            'web downloader'                                        => 'Windows',
            'webcapture'                                            => 'Windows',
            'webcollage'                                            => 'Windows',
            'webcopier'                                             => 'Windows',
            'webstripper'                                           => 'Windows',
            'webzip'                                                => 'Windows',
            'wget'                                                  => 'Windows',
            'Java'                                                  => 'Unknown',
            'flashget'                                              => 'Windows',

            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage'                                          => 'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'                     => 'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})'                         => 'Windows',
            'libwww-perl'                                           => 'Unix',
            'UP.Browser'                                            => 'Windows CE',
            'NetAnts'                                               => 'Windows',
        ];

        // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
        $archRegex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($archRegex, $userAgent) ? '64' : '32';

        foreach ($osArray as $regex => $value) {
            if (preg_match('{\b(' . $regex . ')\b}i', $userAgent)) {
                return $value . ' x' . $arch;
            }
        }

        return 'Unknown';
    }
}

if (!function_exists('_asset')) {
    /**
     * @param $asset
     * @return string
     */
    function _asset($asset): string
    {
        $asset = $asset[0]!='/' ? '/'.$asset:$asset;

        $file = public_path().$asset;

        if (file_exists($file)) {
            return asset($asset.'?='.filemtime($file));
        }
        return '<!-- '.$asset.' not found -->';
    }
}

if (!function_exists('parseMarkdown')) {
    /**
     * @param string $markdown
     * @param bool $leftTrim
     * @return \Illuminate\Support\HtmlString
     */
    function parseMarkdown(string $markdown, bool $leftTrim = true): \Illuminate\Support\HtmlString
    {
        if ($leftTrim) {
            $markdown = textLtrim($markdown);
        }

        return \Illuminate\Mail\Markdown::parse($markdown);
    }
}

if (!function_exists('parseMarkdownFile')) {
    /**
     * @param $file
     * @param bool $leftTrim
     * @return \Illuminate\Support\HtmlString
     */
    function parseMarkdownFile($file, bool $leftTrim = true): \Illuminate\Support\HtmlString
    {
        $markdown = file_get_contents($file);

        return parseMarkdown($markdown, $leftTrim);
    }
}

if (!function_exists('textTrim')) {
    /**
     * Strip whitespace (or other characters) from the beginning and end in each line of a string
     *
     * @param string $string
     * @param bool $trim
     * @return string
     */
    function textTrim(string $string, bool $trim = true): string
    {
        if ($trim) {
            $string = trim($string);
        }

        return implode("\n", array_map('trim', explode("\n", $string)));
    }
}

if (!function_exists('textLtrim')) {
    /**
     * Strip whitespace (or other characters) from the beginning in each line of a string
     *
     * @param string $string
     * @param bool $trim
     * @return string
     */
    function textLtrim(string $string, bool $trim = true): string
    {
        if ($trim) {
            $string = trim($string);
        }

        return implode("\n", array_map('ltrim', explode("\n", trim($string))));
    }
}

if (!function_exists('textRtrim')) {
    /**
     * Strip whitespace (or other characters) from the end in each line of a string
     *
     * @param string $string
     * @param bool $trim
     * @return string
     */
    function textRtrim(string $string, bool $trim = true): string
    {
        if ($trim) {
            $string = trim($string);
        }

        return implode("\n", array_map('rtrim', explode("\n", trim($string))));
    }
}

if (!function_exists('routeIs')) {
    /**
     * @param $route
     * @return bool
     */
    function routeIs($route): bool
    {
        return request()->routeIs($route);
    }
}

if (!function_exists('UtcToLocal')) {
    /**
     * Convert UTC to local time
     *
     * @param $string
     * @return \Illuminate\Support\Carbon
     */
    function UtcToLocal($string): \Illuminate\Support\Carbon
    {
        return \Illuminate\Support\Carbon::parse($string)->setTimezone(config('app.timezone'));
    }
}

if (!function_exists('strRealLimit')) {
    /**
     * \Illuminate\Support\Str::limit ignore the length of the end.
     * This function not
     *
     * @param $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    function strRealLimit($value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        if (strlen($value) > $limit) {
            $endLength = strlen($end);
            return rtrim(mb_strimwidth($value, 0, $limit-$endLength, '', 'UTF-8')).$end;
        }
        return $value;
    }
}

if (!function_exists('randFloat')) {
    /**
     * Create a random float
     *
     * @param int $min
     * @param int $max
     * @param int $decimals
     * @return float
     */
    function randFloat(int $min = 1, int $max = 100, int $decimals = 2): float
    {
        if ($min > $max) {
            $workMin = $max;
            $workMax = $min;
            $min = $workMin;
            $max = $workMax;
        }

        $step = 1;
        for ($i = 1; $i <= $decimals; $i++) {
            $step = $step/10;
        }

        return mt_rand(floor($min / $step), floor($max / $step)) * $step;
    }
}

if (!function_exists('explodeDelimiter2')) {
    /**
     * Creates an array of single words
     *
     * @param $string
     * @param string $separator
     * @return array
     */
    function explodeDelimiter2($string, string $separator = ' '): array
    {
        return array_map(
            function ($value) use ($separator) {
                return implode($separator, $value);
            },
            array_chunk(explode($separator, $string), 2)
        );
    }
}

if (!function_exists('andWordReplace')) {
    /**
     * Replaces the last comma in an enumeration with the word "and".
     *
     * @param $string
     * @param string $word
     * @param string $glue
     * @return string
     */
    function andWordReplace($string, string $word = '', string $glue = ','): string
    {
        if (!$word) {
            $locale = config('app.locale');
            if ($locale == 'de' || $locale == 'de_DE') {
                $word = 'und';
            } else {
                $word = __('and');
            }
        }

        return substr_replace($string, ' '.$word, strrpos($string, $glue), 1);
    }
}
