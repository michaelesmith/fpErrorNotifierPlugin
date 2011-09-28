<?php

require_once 'fpBaseErrorNotifierDriver.php';

/** 
 *
 * @package    fpErrorNotifier
 * @subpackage driver 
 * 
 * @author     Maksim Kotlyar <mkotlar@ukr.net>
 */
class fpErrorNotifierDriverDB extends fpBaseErrorNotifierDriver
{
  /**
   * 
   * @param array $options
   */
  public function __construct(array $options = array())
  {
    $options['model'] = isset($options['model']) ?
      $options['model'] :
      'fpError';

    parent::__construct($options);
  }
  
  /**
   * 
   * @param fpBaseErrorNotifierMessage $message
   */
  public function notify(fpBaseErrorNotifierMessage $decorator)
  {    
	  $model = $this->getOption('model');
	  $error = new $model();

	  $message = $decorator->getMessage();

	  $summary = $message->getSection('Summary');
	  $error->subject = $summary['subject'];
	  $error->uri = $summary['uri'];
	  $error->environment = $summary['environment'];
	  $error->module = $summary['module'];
	  $error->action = $summary['action'];

	  $exception = $message->getSection('Exception');
	  $error->exception_class = $exception['class'];
	  $error->exception_code = $exception['code'];
	  $error->exception_severity = $exception['severity'];
	  $error->exception_message = $exception['message'];
	  $error->file = $exception['file'];
	  $error->line = $exception['line'];
	  $error->trace = $exception['trace'];

	  $server = $message->getSection('Server');
	  $error->server = $server['server'];
	  $error->session = $server['session'];

	  if(sfContext::hasInstance()){
		  $error->referer = sfContext::getInstance()->getRequest()->getReferer();
		  $user = sfContext::getInstance()->getUser();
		  if($error->user_authenticated = $user->isAuthenticated()){
			  $error->user_name = $user->getGuardUser()->getUsername();
			  $error->user_id = $user->getGuardUser()->getId();
		  }
	  }

	  $error->save();
  }
}