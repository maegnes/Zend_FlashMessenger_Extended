Zend_FlashMessenger_Extended
============================

The default Flash Messenger of the Zend Framework 1.x is not able to group different types of messages. If you want to handle error, information or success messages and display them in
different styles (e.g. green div for success, red div for alert etc.) you can now use the **extended FlashMessenger**.

Installation
--------
1. Move the View-Helper "PrintMessage.php" to the folder where you've stored the ViewHelpers
2. Move the Controller Action Helper to a folder which can be accessed by your Autoloader.
3. Register your Controller Action Helper in the bootstrap file. Just use **Zend_Controller_Action_HelperBroker::addHelper( new Ezd_Controller_Action_Helper_FlashMessenger() );** 

Usage without groups
--------
	<?php
	
	# application/controllers/SampleController.php
	class SampleController extends Zend_Controller_Action {
	
		public function indexAction() {
		
			# Adds a success message
			$this->_helper->flashMessenger->addInformationMessage( 'I am a information message!' );
			
			# Adds a information message
			$this->_helper->flashMessenger->addSuccessMessage( 'I am a success message!' );
			
			# Adds a error message
			$this->_helper->flashMessenger->addErrorMessage( 'I am a error message!' );
		
		}
	
	}
	
	# application/views/scripts/sample/index.phtml
	<div class="container">
		<?php echo $this->printMessage();
	</div>
	
	# Output:
	<div class="alert alert-info">
		<div>I am a information message!</div>
	</div>
	
	<div class="alert alert-success">
		<div>I am a success message!</div>
	</div>

	<div class="alert alert-error">
		<div>I am a error message!</div>
	</div>
	
	
	
	?>
	