<?php

require_once dirname(__FILE__) . '/../lib/fp_errorGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/fp_errorGeneratorHelper.class.php';

/**
 * fp_error actions.
 *
 * @package    synoffice
 * @subpackage fp_error
 * @author     msmith
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fp_errorActions extends autoFp_errorActions {
	public function executeShow(sfWebRequest $request){
		$error = $this->error = $this->getRoute()->getObject();
		$this->count_similar = fpErrorTable::getInstance()->createQuery('e')->where('e.exception_class = ? AND e.file = ? AND e.line = ?', array($error->exception_class, $error->file, $error->line))->count() - 1;
	}

	public function executeListArchive(sfWebRequest $request){
		$error = $this->getRoute()->getObject();
		$error->is_archived = true;
		$error->save();
		$this->getUser()->addFlashNotice('The error has been archived');

		$this->redirect($request->getReferer());
	}

	public function executeBatchArchive(sfWebRequest $request){
		$errors = fpErrorTable::getInstance()->createQuery('e')->whereIn('id', $request->getParameter('ids'))->execute();
		foreach($errors as $error){
			$error->is_archived = true;
		}

		$errors->save();
		$this->getUser()->addFlashNotice(sprintf('The %d errors have been archived', $errors->count()));

		$this->redirect($request->getReferer());
	}
}