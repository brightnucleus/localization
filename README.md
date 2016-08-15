# Bright Nucleus Localization

[![Latest Stable Version](https://img.shields.io/packagist/v/brightnucleus/localization.svg)](https://packagist.org/packages/brightnucleus/localization)
[![Total Downloads](https://img.shields.io/packagist/dt/brightnucleus/localization.svg)](https://packagist.org/packages/brightnucleus/localization)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/brightnucleus/localization.svg)](https://packagist.org/packages/brightnucleus/localization)
[![License](https://img.shields.io/packagist/l/brightnucleus/localization.svg)](https://packagist.org/packages/brightnucleus/localization)

WordPress localization for Bright Nucleus components.

## Table Of Contents

* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Filters](#filters)
* [Contributing](#contributing)
* [License](#license)

## Installation

The best way to use this package is through Composer:

```BASH
composer require brightnucleus/localization
```

## Basic Usage

This package provides a trait to be used within Bright Nucleus components to load the translation files (compiled `*.mo`-files) for a given locale.

To use the trait, import it into your class, and call the `loadLocalization( $domain, $path )` method.

__Example:__

```PHP
<?php namespace Localization\Example;

use BrightNucleus\Localization\LocalizationTrait;

class TranslatedClass {

	use LocalizationTrait;

	public function register() {

		$this->loadLocalization(
			'bn-localization-example',
			__DIR__ . '/../languages'
		);

		// Your normal registration comes here, knowing that all `gettext`
		// strings have already been translated.
	}
}
```

## Filters

Each loading of localization files passes through two filters:

1. __`Localization::LOCALE_FILTER`__ - Filter the locale of a Bright Nucleus library.

	Arguments:
	* `$locale` (string) - The plugin's current locale.
	* `$domain` (string) - Text domain. Unique identifier for retrieving translated strings.

	Return value:
	* `$locale` (string) - Filtered locale.

2. __`Localization::MOFILE_FILTER`__ - Filter the name of the MO-file of a Bright Nucleus library.

	Arguments:
	* `$path` (string) - Path to the MO-file.
	* `$locale` (string) - The plugin's current locale.
	* `$domain` (string) - Text domain. Unique identifier for retrieving translated strings.

	Return value:
	* `$path` (string) - Fitlered path to the MO-file.

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2016 Alain Schlesser, Bright Nucleus

This code is licensed under the [MIT License](LICENSE).
