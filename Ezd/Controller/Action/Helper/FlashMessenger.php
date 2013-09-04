<?php
/**
 * Zend_FlashMessenger_Extended
 *
 * Extended the FlashMessenger of the Zend Framework to group messages and also store them into the session.
 *
 * @author Magnus Buk <MagnusBuk@gmx.de>
 */
class Ezd_Controller_Action_Helper_FlashMessenger extends Zend_Controller_Action_Helper_FlashMessenger {

    /**
     * Success code
     *
     * @var int
     */
    const CODE_SUCCESS 		= 1;

    /**
     * Error code
     *
     * @var int
     */
    const CODE_ERROR		= 2;

    /**
     * Information code
     *
     * @var int
     */
    const CODE_INFORMATION 	= 3;

    /**
     * Namespace where the messages should be stored
     *
     * @var String
     */
    const SESSION_NAMESPACE = 'Ezd_FlashMessenger_Namespace';

	/**
	 * Add a success message to the flash messenger
	 *
	 * @param String $message
	 * @return void
	 * @access public
	 */
	public function addSuccessMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_SUCCESS,
			$namespace
		);
	}

	/**
	 * Add a success message to the session. flash messenger is not able to handle it via different page requests
	 * @param null $message
	 * @param null $namespace
	 * @return void
	 * @access public
	 */
	public function addSessionSuccessMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_SUCCESS,
			$namespace,
			true
		);
	}

	/**
	 * Add a error message to the flash messenger
	 *
	 * @param String $message
	 * @return void
	 * @access public
	 */
	public function addErrorMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_ERROR,
			$namespace
		);
	}

	/**
	 * Add a error message to the session. flash messenger is not able to handle it via different page requests
	 * @param null $message
	 * @param null $namespace
	 * @return void
	 * @access public
	 */
	public function addSessionErrorMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_ERROR,
			$namespace,
			true
		);
	}

	/**
	 * Add a information message to the flash messenger
	 *
	 * @param String $message
	 * @return void
	 * @access public
	 */
	public function addInformationMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_INFORMATION,
			$namespace
		);
	}

	/**
	 * Add a information message to the session. flash messenger is not able to handle it via different page requests
	 * @param null $message
	 * @param null $namespace
	 * @return void
	 * @access public
	 */
	public function addSessionInformationMessage( $message = null, $namespace = null ) {
		$this->_addMessage(
			$message,
			self::CODE_INFORMATION,
			$namespace,
			true
		);
	}

	/**
	 * Wrapper-Class for the addMessage()-Method
	 *
	 * @param null $message
	 * @param int $type
	 * @return void
	 * @access private
	 * @see Zend_Controller_Action_Helper_FlashMessenger
	 */
	private function _addMessage( $message = null, $type = 0, $namespace = null, $toSession = false ) {

		// Ignore if no message is given
		if( is_null( $message ) )
			return;

		$skeleton = array(
			'message' => $message,
			'type' => $type,
            'namespace' => $namespace
		);

		// Store message to session?
		if( $toSession ) {

			$messageNamespace = new Zend_Session_Namespace( self::SESSION_NAMESPACE );
            $storageNamespace = is_null( $namespace ) ? 'default' : $namespace;

            if( !is_object( $messageNamespace->{$storageNamespace} ) ) {
                $messageNamespace->{$storageNamespace} = new stdClass();
                $messageNamespace->{$storageNamespace}->messages = array();
            }

			$messageNamespace->{$storageNamespace}->messages[] = $skeleton;

			return;

		}

		// Use method addMessage() in parent-Class to add message to flashMessenger
		$this->addMessage( $skeleton, $namespace );
	}

	/**
	 * Gets the manually stored messages from the session
	 */
	public static function getSessionMessages( $namespace = 'default' ) {

		$messageNamespace = new Zend_Session_Namespace( self::SESSION_NAMESPACE );

        if( is_null( $namespace ) )
            $namespace = 'default';

        // If no messages for the current namespace exist, return empty array
        if( !is_object( $messageNamespace->{$namespace} ) )
            return Array();

		// Create return array
		$returnMessages = array();
		$returnMessages = $messageNamespace->{$namespace}->messages;

		// Show the session messages just for one time - so unset namespace
		unset( $messageNamespace->{$namespace}->messages );
        unset( $messageNamespace->{$namespace} );

		return $returnMessages;

	}
}