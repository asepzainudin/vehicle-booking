<?php

if (!function_exists('theme')) {
    function theme(): \App\Core\Theme {
        return app(App\Core\Theme::class);
    }
}


if (!function_exists('getName')) {
    /**
     * @return string
     */
    function getName(): string
    {
        return config('settings.KT_THEME');
    }
}


if (!function_exists('addHtmlAttribute')) {
    /**
     * @param  string  $scope
     * @param  string  $name
     * @param  string  $value
     *
     * @return void
     */
    function addHtmlAttribute(string $scope, string $name, string $value): void
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
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
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
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
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param  string  $scope
     *
     * @return string
     */
    function printHtmlAttributes(string $scope): string
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
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
        return theme()->printHtmlClasses($scope, $full);
    }
}


if (!function_exists('getSvgIcon')) {
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
        return theme()->getSvgIcon($path, $classNames, $folder);
    }
}


if (!function_exists('setModeSwitch')) {
    /**
     * Set dark mode enabled status
     *
     * @param  bool  $flag
     *
     * @return void
     */
    function setModeSwitch(bool $flag): void
    {
        theme()->setModeSwitch($flag);
    }
}


if (!function_exists('isModeSwitchEnabled')) {
    /**
     * Check dark mode status
     *
     * @return bool
     */
    function isModeSwitchEnabled(): bool
    {
        return theme()->isModeSwitchEnabled();
    }
}


if (!function_exists('setModeDefault')) {
    /**
     * Set the mode to dark or light
     *
     * @param  string  $mode
     *
     * @return void
     */
    function setModeDefault(string $mode): void
    {
        theme()->setModeDefault($mode);
    }
}


if (!function_exists('getModeDefault')) {
    /**
     * Get current mode
     *
     * @return string
     */
    function getModeDefault(): string
    {
        return theme()->getModeDefault();
    }
}


if (!function_exists('setDirection')) {
    /**
     * Set style direction
     *
     * @param  string  $direction
     *
     * @return void
     */
    function setDirection(string $direction): void
    {
        theme()->setDirection($direction);
    }
}


if (!function_exists('getDirection')) {
    /**
     * Get style direction
     *
     * @return string
     */
    function getDirection(): string
    {
        return theme()->getDirection();
    }
}


if (!function_exists('isRtlDirection')) {
    /**
     * Check if style direction is RTL
     *
     * @return bool
     */
    function isRtlDirection(): bool
    {
        return theme()->isRtlDirection();
    }
}


if (!function_exists('extendCssFilename')) {
    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param  string  $path
     *
     * @return string
     */
    function extendCssFilename(string $path): string
    {
        return theme()->extendCssFilename($path);
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon(): string
    {
        return theme()->includeFavicon();
    }
}


if (!function_exists('includeFonts')) {
    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts(): string
    {
        return theme()->includeFonts();
    }
}


if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param  string  $type
     *
     * @return array
     */
    function getGlobalAssets(string $type = 'js'): array
    {
        return theme()->getGlobalAssets($type);
    }
}

if (!function_exists('addGlobalCss')) {
    /**
     * @param string $file
     * @return void
     */
    function addGlobalCss(string $file): void
    {
        theme()->addGlobalCss($file);
    }
}

if (!function_exists('addGlobalJs')) {
    /**
     * @param string $file
     * @return void
     */
    function addGlobalJs(string $file): void
    {
        theme()->addGlobalJs($file);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param  array  $vendors
     *
     * @return void
     */
    function addVendors(array $vendors): void
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param  string  $vendor
     *
     * @return void
     */
    function addVendor(string $vendor): void
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param  string  $file
     *
     * @return void
     */
    function addJavascriptFile(string $file): void
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param  string  $file
     *
     * @return void
     */
    function addCssFile(string $file): void
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param  string  $type
     *
     * @return array
     */
    function getVendors(string $type): array
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs(): array
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss(): array
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param  string  $scope
     * @param  array<string>  $attribute
     *
     * @return array
     */
    function getHtmlAttribute(string $scope, array $attribute): array
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}


if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param  string|null  $url
     *
     * @return mixed
     */
    function isUrl(string|null $url): bool
    {
        return !$url ? false : filter_var($url, FILTER_VALIDATE_URL);
    }
}


if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param  string|null  $path
     *
     * @return string
     */
    function image(string|null $path): string
    {
        return !$path ? '' : cachedAsset('assets/media/' . $path);
    }
}


if (!function_exists('getIcon')) {
    /**
     * Get icon
     *
     * @param  string  $name
     * @param  string  $class
     * @param  string  $type
     * @param  string  $tag
     *
     * @return string
     */
    function getIcon(string $name, string $class = '', string $type = '', string $tag = 'span'): string
    {
        return theme()->getIcon($name, $class, $type, $tag);
    }
}
