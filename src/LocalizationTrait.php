<?php
/**
 * Bright Nucleus Localization.
 *
 * WordPress localization for Bright Nucleus components.
 *
 * @package   BrightNucleus\Localization
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Localization;

/**
 * Trait LocalizationTrait.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Localization
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
trait LocalizationTrait {

	/**
	 * Load localized strings.
	 *
	 * @since 0.1.0
	 *
	 * @param string $domain Textdomain to load.
	 * @param string $path   Path to languages files.
	 */
	protected function loadLocalization( $domain, $path ) {
		if ( is_textdomain_loaded( $domain ) ) {
			return;
		}

		$locale = get_locale();

		/**
		 * Filter the locale of a Bright Nucleus library.
		 *
		 * @since v0.1.0
		 *
		 * @param string $locale The plugin's current locale.
		 * @param string $domain Text domain. Unique identifier for retrieving
		 *                       translated strings.
		 * @return string $locale Filtered locale.
		 */
		$locale = apply_filters(
			Localization::LOCALE_FILTER,
			$locale,
			$domain
		);

		/**
		 * Filter the name of the MO-file of a Bright Nucleus library.
		 *
		 * @since v0.1.0
		 *
		 * @param string $path   Path to the MO-file.
		 * @param string $locale The plugin's current locale.
		 * @param string $domain Text domain. Unique identifier for retrieving
		 *                       translated strings.
		 * @return string $path Filtered path to the MO-file.
		 */
		$mofile = apply_filters(
			Localization::MOFILE_FILTER,
			sprintf(
				'%1$s/%2$s-%3$s.mo',
				$path,
				$domain,
				$locale
			),
			$locale,
			$domain
		);

		return load_textdomain(
			$domain,
			$mofile
		);
	}
}
