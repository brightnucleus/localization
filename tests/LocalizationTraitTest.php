<?php
/**
 * Bright Nucleus Localization Component.
 *
 * @package   BrightNucleus\Localization
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Localization\Tests;

use BrightNucleus\Localization\Localization;
use BrightNucleus\Localization\LocalizationTrait;
use Brain\Monkey\Functions;
use Brain\Monkey\Filters;

/**
 * @covers \BrightNucleus\Localization\LocalizationTrait
 */
class LocalizationTraitTest extends TestCase
{
	use LocalizationTrait {
		loadLocalization as public;
	}

	/**
	 * Test that localization is not loaded if textdomain is already loaded.
	 */
	public function test_does_not_load_if_textdomain_already_loaded()
	{
		Functions\expect('is_textdomain_loaded')
			->once()
			->with('test-domain')
			->andReturn(true);

		Functions\expect('get_locale')->never();
		Functions\expect('apply_filters')->never();
		Functions\expect('load_textdomain')->never();

		$result = $this->loadLocalization('test-domain', '/path/to/languages');
		$this->assertNull($result);
	}

	/**
	 * Test that localization loads textdomain when not already loaded.
	 */
	public function test_loads_textdomain_when_not_loaded()
	{
		$domain = 'test-domain';
		$path = '/path/to/languages';
		$locale = 'en_US';
		$mofile = sprintf('%s/%s-%s.mo', $path, $domain, $locale);

		Functions\expect('is_textdomain_loaded')
			->once()
			->with($domain)
			->andReturn(false);

		Functions\expect('get_locale')
			->once()
			->andReturn($locale);

		// Expect locale filter
		Filters\expectApplied(Localization::LOCALE_FILTER)
			->once()
			->with($locale, $domain)
			->andReturn($locale);

		// Expect mofile filter
		Filters\expectApplied(Localization::MOFILE_FILTER)
			->once()
			->with($mofile, $locale, $domain)
			->andReturn($mofile);

		Functions\expect('load_textdomain')
			->once()
			->with($domain, $mofile)
			->andReturn(true);

		$result = $this->loadLocalization($domain, $path);
		$this->assertTrue($result);
	}

	/**
	 * Test that locale filter can modify the locale.
	 */
	public function test_locale_filter_modifies_locale()
	{
		$domain = 'test-domain';
		$path = '/path/to/languages';
		$original_locale = 'en_US';
		$filtered_locale = 'de_DE';
		$mofile = sprintf('%s/%s-%s.mo', $path, $domain, $filtered_locale);

		Functions\expect('is_textdomain_loaded')
			->once()
			->with($domain)
			->andReturn(false);

		Functions\expect('get_locale')
			->once()
			->andReturn($original_locale);

		// Locale filter returns different locale
		Filters\expectApplied(Localization::LOCALE_FILTER)
			->once()
			->with($original_locale, $domain)
			->andReturnUsing(function() use ($filtered_locale) {
				return $filtered_locale;
			});

		// Mofile should use filtered locale
		Filters\expectApplied(Localization::MOFILE_FILTER)
			->once()
			->with($mofile, $filtered_locale, $domain)
			->andReturn($mofile);

		Functions\expect('load_textdomain')
			->once()
			->with($domain, $mofile)
			->andReturn(true);

		$result = $this->loadLocalization($domain, $path);
		$this->assertTrue($result);
	}

	/**
	 * Test that mofile filter can modify the mofile path.
	 */
	public function test_mofile_filter_modifies_path()
	{
		$domain = 'test-domain';
		$path = '/path/to/languages';
		$locale = 'en_US';
		$original_mofile = sprintf('%s/%s-%s.mo', $path, $domain, $locale);
		$filtered_mofile = '/custom/path/custom-file.mo';

		Functions\expect('is_textdomain_loaded')
			->once()
			->with($domain)
			->andReturn(false);

		Functions\expect('get_locale')
			->once()
			->andReturn($locale);

		Filters\expectApplied(Localization::LOCALE_FILTER)
			->once()
			->with($locale, $domain)
			->andReturn($locale);

		// Mofile filter returns different path
		Filters\expectApplied(Localization::MOFILE_FILTER)
			->once()
			->with($original_mofile, $locale, $domain)
			->andReturnUsing(function() use ($filtered_mofile) {
				return $filtered_mofile;
			});

		Functions\expect('load_textdomain')
			->once()
			->with($domain, $filtered_mofile)
			->andReturn(true);

		$result = $this->loadLocalization($domain, $path);
		$this->assertTrue($result);
	}

	/**
	 * Test that the method returns false when load_textdomain fails.
	 */
	public function test_returns_false_when_load_textdomain_fails()
	{
		$domain = 'test-domain';
		$path = '/path/to/languages';
		$locale = 'en_US';
		$mofile = sprintf('%s/%s-%s.mo', $path, $domain, $locale);

		Functions\expect('is_textdomain_loaded')
			->once()
			->with($domain)
			->andReturn(false);

		Functions\expect('get_locale')
			->once()
			->andReturn($locale);

		Filters\expectApplied(Localization::LOCALE_FILTER)
			->once()
			->with($locale, $domain)
			->andReturn($locale);

		Filters\expectApplied(Localization::MOFILE_FILTER)
			->once()
			->with($mofile, $locale, $domain)
			->andReturn($mofile);

		Functions\expect('load_textdomain')
			->once()
			->with($domain, $mofile)
			->andReturn(false);

		$result = $this->loadLocalization($domain, $path);
		$this->assertFalse($result);
	}
}