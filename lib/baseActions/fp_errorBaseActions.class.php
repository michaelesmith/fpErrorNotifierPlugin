<?php

require_once dirname(__FILE__) . '/../../modules/fp_error/lib/fp_errorGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../../modules/fp_error/lib/fp_errorGeneratorHelper.class.php';

/**
 * fp_error actions.
 *
 * @package    synoffice
 * @subpackage fp_error
 * @author     msmith
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fp_errorBaseActions extends autoFp_errorActions {
	public function executeShow(sfWebRequest $request){
		$error = $this->error = $this->getRoute()->getObject();

		$similar = fpErrorTable::getInstance()->createQuery('e')->where('e.exception_class = ? AND e.file = ? AND e.line = ?', array($error->exception_class, $error->file, $error->line))->addWhere('e.is_archived = ?');
		$this->count_similar = $similar->count(array(0)) -  - ($error->is_archived ? 0 : 1);
		$this->count_similar_archived = $similar->count(array(1)) - ($error->is_archived ? 1 : 0);

		$identical = fpErrorTable::getInstance()->createQuery('e')->where('e.exception_class = ? AND e.file = ? AND e.line = ? AND e.exception_message = ?', array($error->exception_class, $error->file, $error->line, $error->exception_message))->addWhere('e.is_archived = ?');
		$this->count_identical = $identical->count(array(0)) - ($error->is_archived ? 0 : 1);
		$this->count_identical_archived = $identical->count(array(1)) - ($error->is_archived ? 1 : 0);
	}

	public function executeArchiveIdentical(sfWebRequest $request){
		$error = $this->getRoute()->getObject();
		$num_errors = fpErrorTable::getInstance()->createQuery('e')->update()->set('is_archived', '?', 1)
				->where('e.is_archived = 0 AND e.exception_class = ? AND e.file = ? AND e.line = ? AND e.exception_message = ?', array($error->exception_class, $error->file, $error->line, $error->exception_message))
				->execute();
		$this->getUser()->addFlashNotice(sprintf('The %d identical errors have been archived', $num_errors));

		$this->redirect($request->getReferer());
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
