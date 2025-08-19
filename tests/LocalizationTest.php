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

/**
 * @covers \BrightNucleus\Localization\Localization
 */
class LocalizationTest extends TestCase
{
	/**
	 * Test that LOCALE_FILTER constant has the correct value.
	 */
	public function test_locale_filter_constant()
	{
		$this->assertSame('bn_library_locale', Localization::LOCALE_FILTER);
	}

	/**
	 * Test that MOFILE_FILTER constant has the correct value.
	 */
	public function test_mofile_filter_constant()
	{
		$this->assertSame('bn_library_mofile', Localization::MOFILE_FILTER);
	}

	/**
	 * Test that Localization class can be instantiated.
	 */
	public function test_can_be_instantiated()
	{
		$localization = new Localization();
		$this->assertInstanceOf(Localization::class, $localization);
	}
}