<?php

/**
 * Class HealthCheck_Controller
 */
class HealthCheck_Controller extends Controller {

	private static $allowed_actions = array (
		'index' => 'ADMIN'
	);

	public function init() {
		parent::init();
		Requirements::css("healthcheck/css/simplegrid.css");
		Requirements::css("healthcheck/css/app.css");
		Requirements::css("https://fonts.googleapis.com/css?family=Open+Sans");
	}

	/**
     * Display information when default route is viewed
	 * Default routes is /health/check
     */
	public function index()
	{
		$data = array(
			'Title' => 'Health check',
			'Content' => 'Health check content...',
			'Environment' => Director::get_environment_type(),
			'Mailer' => Email::mailer()->class,
			'AdminEmail' => Email::getAdminEmail(),
			'SendAllEmailsTo' => Config::inst()->get('Email', 'send_all_emails_to'),
			'Nofollow' => $this->getRobotsMetaTag(),
			'Logging' => $this->getLogWriters(),
			'SiteMap' => $this->hasSiteMap(),
			'LastCommit' => $this->getLastCommit()
		);
		$this->extend('updateIndexData', $data);
		return $this->customise($data)->renderWith(array("HealthCheck"));
	}

	/**
     * Use PHP to check for robots meta tag
	 * NOTE this doesn't work locally (dev mode)
     */
	public function getRobotsMetaTag()
	{
		if (!Director::isDev()) {
			$metatags = get_meta_tags(Director::absoluteBaseURL());
			$robots = empty($metatags['robots']) ? false : true;
		}
		return false;
	}

	/**
     * Get the current SS log writers and their default configuration
     */
	public function getLogWriters()
	{
		$writers = SS_Log::get_writers();
		if ($writers && !empty($writers)) {
			$writersArray = ArrayList::create();
			foreach($writers as $writer) {
				$writersArray->push(ArrayData::create(array("Type" => get_class($writer), "Details" => reset($writer))));
			}
			return $writersArray;
		}
		return false;
	}

	/**
     * Check if the website has an XML sitemap
     */
	public function hasSiteMap()
	{
		$file = Director::absoluteBaseURL().'sitemap.xml';
		$file_headers = @get_headers($file);
		if ($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
		    return false;
		} else {
		    return true;
		}
	}

	/**
     * Get the last commit for shits and giggles (#gitblame)
     */
	public function getLastCommit()
	{
		if(exec("cd ../ && git log -1 --pretty=format:'%s - (%cr) - %an'", $output)){
			return $output[0];
		}
		return false;
	}

	/**
     * NOTE this isn't yet implemented. Plans are to allow a quick test.
	 * to ensure emails are being sent.
     */
	public function canSendEmail()
	{
		$email = new Email("no-reply@platocreative.co.nz","no-reply@platocreative.co.nz", "Test Email", "This is a test email message.");
		$this->extend('updateSendEmail', $email);
		if ($email->send()) {
			return true;
		} else {
			return false;
		}
	}

}
