<?php
namespace OCA\LucaHome\Settings;

use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\Settings\IIconSection;

class AdminSection implements IIconSection {

	/** @var IL10N */
    private $l;
    
	/** @var IURLGenerator */
    private $urlgen;
    
	public function __construct(IL10N $l, IURLGenerator $urlgen) {
		$this->l = $l;
		$this->urlgen = $urlgen;
    }
    
	/**
	 * returns the ID of the section. It is supposed to be a lower case string
	 *
	 * @return string
	 */
	public function getID() {
		return 'lucahome';
    }
    
	/**
	 * returns the translated name as it should be displayed, e.g. 'LDAP / AD
	 * integration'. Use the L10N service to translate it.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->l->t('LucaHome');
    }
    
	public function getIcon() {
		return $this->urlgen->imagePath('lucahome', 'lucahome-black.svg');
    }
    
	/**
	 * @return int whether the form should be rather on the top or bottom of
	 * the settings navigation. The sections are arranged in ascending order of
	 * the priority values. It is required to return a value between 0 and 99.
	 */
	public function getPriority() {
		return 80;
	}
}