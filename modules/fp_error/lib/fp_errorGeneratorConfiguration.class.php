<?php

/**
 * fp_error module configuration.
 *
 * @package    synoffice
 * @subpackage fp_error
 * @author     msmith
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fp_errorGeneratorConfiguration extends BaseFp_errorGeneratorConfiguration {

	public function getDefaultSort() {
		return array('created_at', 'desc');
	}

	public function getFilterDefaults() {
		return array('is_archived' => 0);
	}

}
