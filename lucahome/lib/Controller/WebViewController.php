<?php
/**
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Stefan Klemm <mail@stefan-klemm.de>
 * @copyright Stefan Klemm 2014
 * @link https://github.com/nextcloud/bookmarks/blob/master/lib/Controller/WebViewController.php
 */

namespace OCA\LucaHome\Controller;

use \OCA\LucaHome\LucaHome;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\AppFramework\Controller;
use \OCP\IRequest;
use OCP\IURLGenerator;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class WebViewController extends Controller {

	/** @var string */
    private $userId;
    
	/** @var IURLGenerator  */
    private $urlgenerator;
    
	/** @var LucaHome */
    private $lucahome;
    
	/** @var EventDispatcherInterface */
    private $eventDispatcher;
    
	/**
	 * WebViewController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param string $userId
	 * @param IURLGenerator $urlgenerator
	 * @param LucaHome $lucahome
	 * @param EventDispatcherInterface $eventDispatcher
	 */
	public function __construct($appName, IRequest $request, string $userId, IURLGenerator $urlgenerator, LucaHome $lucahome, EventDispatcherInterface $eventDispatcher) {
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->urlgenerator = $urlgenerator;
		$this->lucahome = $lucahome;
		$this->eventDispatcher = $eventDispatcher;
    }
    
	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
        $params = ['user' => $this->userId];
        
		$policy = new ContentSecurityPolicy();
		$policy->addAllowedFrameDomain("'self'");
        $policy->allowEvalScript(true);
        
		$this->eventDispatcher->dispatch(
			'\OCA\LucaHome::loadAdditionalScripts',
			new GenericEvent(null, [])
        );
        
		$response = new TemplateResponse('lucahome', 'main', $params);
        $response->setContentSecurityPolicy($policy);
        
		return $response;
    }
}