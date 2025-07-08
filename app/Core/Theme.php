<?php

namespace App\Core;

class Theme
{
    /**
     * Variables
     *
     * @var bool
     */
    public static bool $modeSwitchEnabled = false;
    public static string $modeDefault = 'light';

    public static string $direction = 'ltr';

    public static array $htmlAttributes = [];
    public static array $htmlClasses = [];


    /**
     * Keep page level assets
     *
     * @var array
     */
    public static array $globalCss = [];
    public static array $globalJs = [];
    public static array $javascriptFiles = [];
    public static array $cssFiles = [];
    public static array $vendorFiles = [];

    /**
     * Get product name
     *
     * @return string
     */
    function getName(): string
    {
        return '';
    }

    /**
     * Add HTML attributes by scope
     *
     * @param  string  $scope
     * @param  string  $name
     * @param  string  $value
     *
     * @return void
     */
    function addHtmlAttribute(string $scope, string $name, string $value): void
    {
        self::$htmlAttributes[$scope][$name] = $value;
    }

    /**
     * Add multiple HTML attributes by scope
     *
     * @param  string  $scope
     * @param  array<string, string>  $attributes
     *
     * @return void
     */
    function addHtmlAttributes(string $scope, array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            self::$htmlAttributes[$scope][$key] = $value;
        }
    }

    /**
     * Add HTML class by scope
     *
     * @param  string  $scope
     * @param  string  $value
     *
     * @return void
     */
    function addHtmlClass(string $scope, string $value): void
    {
        self::$htmlClasses[$scope][] = $value;
    }

    /**
     * Remove HTML class by scope
     *
     * @param  string  $scope
     * @param  string  $value
     *
     * @return void
     */
    function removeHtmlClass(string $scope, string $value): void
    {
        $key = array_search($value, self::$htmlClasses[$scope]);
        unset(self::$htmlClasses[$scope][$key]);
    }

    /**
     * Print HTML attributes for the HTML template
     *
     * @param  string  $scope
     *
     * @return string
     */
    function printHtmlAttributes(string $scope): string
    {
        $attributes = [];
        if (isset(self::$htmlAttributes[$scope])) {
            foreach (self::$htmlAttributes[$scope] as $key => $value) {
                $attributes[] = sprintf('%s="%s"', $key, $value);
            }
        }

        return join(' ', $attributes);
    }

    /**
     * Print HTML classes for the HTML template
     *
     * @param  string  $scope
     * @param  bool  $full
     *
     * @return string
     */
    function printHtmlClasses(string $scope, bool $full = true): string
    {
        if (empty(self::$htmlClasses)) {
            return '';
        }

        $classes = [];
        if (isset(self::$htmlClasses[$scope])) {
            $classes = self::$htmlClasses[$scope];
        }

        if ($full) {
            return sprintf('class="%s"', implode(' ', (array)$classes));
        }

        return $classes;
    }

    /**
     * Get SVG icon content
     *
     * @param  string  $path
     * @param  string  $classNames
     * @param  string  $folder
     *
     * @return string
     */
    function getSvgIcon(string $path, string $classNames = 'svg-icon', string $folder = 'assets/media/icons/'): string
    {
        if (file_exists(public_path($folder . $path))) {
            return sprintf('<span class="%s">%s</span>', $classNames, file_get_contents(public_path('assets/media/icons/' . $path)));
        }

        return '';
    }

    /**
     * Set dark mode enabled status
     *
     * @param  bool  $flag
     *
     * @return void
     */
    function setModeSwitch(bool $flag): void
    {
        self::$modeSwitchEnabled = $flag;
    }

    /**
     * Check dark mode status
     *
     * @return bool
     */
    function isModeSwitchEnabled(): bool
    {
        return self::$modeSwitchEnabled;
    }

    /**
     * Set the mode to dark or light
     *
     * @param  string  $mode
     *
     * @return void
     */
    function setModeDefault(string $mode): void
    {
        if (in_array($mode, ['dark', 'light'])) {
            self::$modeDefault = $mode;
        }
    }

    /**
     * Get current mode
     *
     * @return string
     */
    function getModeDefault(): string
    {
        return self::$modeDefault;
    }

    /**
     * Set style direction
     *
     * @param  string  $direction
     *
     * @return void
     */
    function setDirection(string $direction): void
    {
        self::$direction = $direction;
    }

    /**
     * Get style direction
     *
     * @return string
     */
    function getDirection(): string
    {
        return self::$direction;
    }

    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon(): string
    {
        // return sprintf('<link rel="shortcut icon" href="%s" />', asset(config('settings.KT_THEME_ASSETS.favicon')));
        return
            '<link rel="apple-touch-icon" sizes="57x57" href="'. cachedAsset('favicon/apple-icon-57x57.png') .'">'.
            '<link rel="apple-touch-icon" sizes="60x60" href="'. cachedAsset('favicon/apple-icon-60x60.png') .'">'.
            '<link rel="apple-touch-icon" sizes="72x72" href="'. cachedAsset('favicon/apple-icon-72x72.png') .'">'.
            '<link rel="apple-touch-icon" sizes="76x76" href="'. cachedAsset('favicon/apple-icon-76x76.png') .'">'.
            '<link rel="apple-touch-icon" sizes="114x114" href="'. cachedAsset('favicon/apple-icon-114x114.png') .'">'.
            '<link rel="apple-touch-icon" sizes="120x120" href="'. cachedAsset('favicon/apple-icon-120x120.png') .'">'.
            '<link rel="apple-touch-icon" sizes="144x144" href="'. cachedAsset('favicon/apple-icon-144x144.png') .'">'.
            '<link rel="apple-touch-icon" sizes="152x152" href="'. cachedAsset('favicon/apple-icon-152x152.png') .'">'.
            '<link rel="apple-touch-icon" sizes="180x180" href="'. cachedAsset('favicon/apple-icon-180x180.png') .'">'.
            '<link rel="icon" type="image/png" sizes="192x192"  href="'. cachedAsset('favicon/android-icon-192x192.png') .'">'.
            '<link rel="icon" type="image/png" sizes="32x32" href="'. cachedAsset('favicon/favicon-32x32.png') .'">'.
            '<link rel="icon" type="image/png" sizes="96x96" href="'. cachedAsset('favicon/favicon-96x96.png') .'">'.
            '<link rel="icon" type="image/png" sizes="16x16" href="'. cachedAsset('favicon/favicon-16x16.png') .'">'.
            '<link rel="manifest" href="'. cachedAsset('favicon/manifest.json') .'">'.
            '<meta name="msapplication-TileColor" content="#ffffff">'.
            '<meta name="msapplication-TileImage" content="'. cachedAsset('favicon/ms-icon-144x144.png') .'">'.
            '<meta name="theme-color" content="#ffffff">';
    }

    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts(): string
    {
        $content = '';

        foreach (config('settings.KT_THEME_ASSETS.fonts') as $url) {
            $content .= sprintf('<link rel="stylesheet" href="%s">', cachedAsset($url));
        }

        return $content;
    }

    /**
     * Get the global assets
     *
     * @param  string  $type
     *
     * @return array
     */
    function getGlobalAssets(string $type = 'js'): array
    {
        return in_array($type, ['css', 'js']) ? array_merge(
            array_map(function ($path) {
                return $this->extendCssFilename($path);
            }, config('settings.KT_THEME_ASSETS.global.' . $type)),
            ($type == 'js' ? self::$globalJs : self::$globalCss)
        ) : [];
    }

    /**
     * set global css
     *
     * @param string $file
     * @return void
     */
    function addGlobalCss(string $file): void
    {
        self::$globalCss[] = $file;
    }

    /**
     * set global js
     *
     * @param string $file
     * @return void
     */
    function addGlobalJs(string $file): void
    {
        self::$globalJs[] = $file;
    }

    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return string
     */
    function extendCssFilename(string $path): string
    {
        if ($this->isRtlDirection()) {
            $path = str_replace('.css', '.rtl.css', $path);
        }

        return $path;
    }

    /**
     * Check if style direction is RTL
     *
     * @return bool
     */
    function isRtlDirection(): bool
    {
        return self::$direction === 'rtl';
    }

    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param  array<string>  $vendors
     *
     * @return array
     */
    function addVendors(array $vendors): array
    {
        foreach ($vendors as $value) {
            self::$vendorFiles[] = $value;
        }

        return array_unique(self::$vendorFiles);
    }

    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param  string  $vendor
     *
     * @return void
     */
    function addVendor(string $vendor): void
    {
        self::$vendorFiles[] = $vendor;
    }

    /**
     * Add custom javascript file to the page
     *
     * @param  string  $file
     *
     * @return void
     */
    function addJavascriptFile(string $file): void
    {
        self::$javascriptFiles[] = $file;
    }

    /**
     * Add custom CSS file to the page
     *
     * @param  string  $file
     *
     * @return void
     */
    function addCssFile(string $file): void
    {
        self::$cssFiles[] = $file;
    }

    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param  string  $type
     *
     * @return array
     */
    function getVendors(string $type): array
    {
        $files = [];
        foreach (self::$vendorFiles as $vendor) {
            $vendors = config('settings.KT_THEME_VENDORS.' . $vendor);
            if (isset($vendors[$type])) {
                foreach ($vendors[$type] as $path) {
                    $files[] = $path;
                }
            }
        }

        return array_unique($files);
    }

    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs(): array
    {
        return self::$javascriptFiles;
    }

    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss(): array
    {
        return self::$cssFiles;
    }

    /**
     * Get HTML attribute based on the scope
     *
     * @param  string  $scope
     * @param  string  $attribute
     *
     * @return array
     */
    function getHtmlAttribute(string $scope, string $attribute): array
    {
        return self::$htmlAttributes[$scope][$attribute] ?? [];
    }

    /**
     * @param  string  $name
     * @param  string  $class
     * @param  string  $type
     * @param  string  $tag
     *
     * @return string
     */
    function getIcon(string $name, string $class = '', string $type = '', string $tag = 'span'): string
    {
        $type = config('settings.KT_THEME_ICONS', 'duotone');

        if ($type === 'duotone') {
            $icons = cache()->remember('duotone-icons', 3600, function () {
                return json_decode(file_get_contents(public_path('icons.json')), true);
            });

            $pathsNumber = data_get($icons, 'duotone-paths.' . $name, 0);

            $output = '<' . $tag . ' class="ki-' . $type . ' ki-' . $name . (!empty($class) ? " " . $class : '') . '">';

            for ($i = 0; $i < $pathsNumber; $i++) {
                $output .= '<' . $tag . ' class="path' . ($i + 1) . '"></' . $tag . '>';
            }

            $output .= '</' . $tag . '>';
        } else {
            $output = '<' . $tag . ' class="ki-' . $type . ' ki-' . $name . (!empty($class) ? " " . $class : '') . '"></' . $tag . '>';
        }

        return $output;
    }
}
