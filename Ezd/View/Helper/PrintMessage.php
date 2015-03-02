<?php
/**
 * Zend_FlashMessenger_Extended
 *
 * Extended the FlashMessenger of the Zend Framework to group messages and also store them into the session.
 *
 * Use this helper to output your messages in a HTML View
 *
 * @author Magnus Buk <MagnusBuk@gmx.de>
 */
class Ezd_View_Helper_PrintMessage extends Zend_View_Helper_Abstract {

	/**
	 * Match Message Types to css classes
	 *
	 * @var array
	 * @access private
	 */
	private $_cssClasses = array(
		Ezd_Controller_Action_Helper_FlashMessenger::CODE_ERROR			=> 'error',
		Ezd_Controller_Action_Helper_FlashMessenger::CODE_INFORMATION	=> 'alert',
		Ezd_Controller_Action_Helper_FlashMessenger::CODE_SUCCESS		=> 'success'
	);

	/**
	 * Method called via the view templates
	 *
	 * @param String $namespace
	 * @param int $type
	 * @return String
	 * @access public
	 */
	public function printMessage( $namespace = null, $type = 0 ) {

		// Get the flashMessenger Helper
		$helper = Zend_Controller_Action_HelperBroker::getStaticHelper( 'flashMessenger' );

		// Create array with the categorized messages
		$messages = array();

		// First, get the messages
		$flashMessages = $helper->getCurrentMessages( $namespace );

		// Check for manually stored session messages
		$sessionMessages = Ezd_Controller_Action_Helper_FlashMessenger::getSessionMessages( $namespace );

		// If session messages exist, merge with other messages
		if( count( $sessionMessages ) > 0 )
			$flashMessages = array_merge( $sessionMessages, $flashMessages );

		// If messages exists, categorize them
		if( count( $flashMessages ) ) {

			foreach( $flashMessages as $message ) {

				if( $type > 0 && $type != $message['type'] )
					continue;

				if( !array_key_exists( $message['type'], $messages ) )
					$messages[$message['type']] = array();

				$messages[$message['type']][] = $message;

			}

			// Deliver generated html-code
			return $this->_getHTML( $messages );

		}

        return $this->_getHTML( Array() );

	}

	/**
	 * Creates the HTML-Code for the messages. In that case it's based upon Twitter bootstraps alert divs
	 *
     * @access private
	 * @param array $messages contains the messages
	 * @return String
	 * @todo - move logic to separate class and add Interface
	 */
	private function _getHTML( $messages = array() ) {

		// If no messages given return nothing
		if( 0 == count( $messages ) )
			return '';

		// Define String for HTML-Output
		$output = '';

		// Generate HTML-Code
		foreach( $messages as $messageType => $message ) {
			$output .= '<div class="alert alert-' . $this->_cssClasses[$messageType] . '">';
			foreach( $message as $messageDetails )
				$output .= '<div>'.$this->view->translate( $messageDetails['message'] ).'</div>';
			$output .= '</div>';
		}

		// Return HTML-Code
		return $output;

	}

}
