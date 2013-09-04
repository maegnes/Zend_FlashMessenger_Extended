Zend_FlashMessenger_Extended
============================

The default Flash Messenger of the Zend Framework 1.x is not able to group different types of messages. If you want to handle error, information or success messages and display them in
different styles (e.g. green div for success, red div for alert etc.) you can now use the **extended FlashMessenger**. You can also add more than one message of different types.

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
			$this->_helper->flashMessenger->addSuccessMessage( 'I am a second success message!' );
			
			# Adds a error message
			$this->_helper->flashMessenger->addErrorMessage( 'I am a error message!' );
		
		}
	
	}
	
	?>
	
	# application/views/scripts/sample/index.phtml
	# To display the messages in your view, just call the printMessage() - View Helper
	<div class="container">
		<?php echo $this->printMessage();
	</div>
	
	# Output:
	<div class="container">
		<div class="alert alert-info">
			<div>I am a information message!</div>
		</div>	
		<div class="alert alert-success">
			<div>I am a success message!</div>
			<div>I am a second success message!</div>
		</div>
		<div class="alert alert-error">
			<div>I am a error message!</div>
		</div>
	</div>
	
Usage without groups
--------
It's also possible to group the messages. It's useful if you want to have multiple message outputs on your page.
If you want to group the messages, just use the second param of the "add(Information|Success|Error)Message-Methods to define the name of the group (see example).
To display messages of a group, just pass the group name into the printMessage View Helper (see example).

	<?php
	
	# application/controllers/SampleController.php	
	class SampleController extends Zend_Controller_Action {
	
		public function indexAction() {
		
			# Adds a success message
			$this->_helper->flashMessenger->addInformationMessage( 'I am a information message!', 'GROUPA' );
			
			# Adds a information message
			$this->_helper->flashMessenger->addSuccessMessage( 'I am a success message!', 'GROUPA' );
			$this->_helper->flashMessenger->addSuccessMessage( 'I am a second success message!', 'GROUPB' );
			
			# Adds a error message
			$this->_helper->flashMessenger->addErrorMessage( 'I am a error message!', 'GROUPB' );
		
		}
	
	}
	
	?>
	
	# application/views/scripts/sample/index.phtml
	# To display the messages in your view, just call the printMessage() - View Helper
	<div class="container">
		<div class="span6">
			<?php echo $this->printMessage( 'GROUPA' );
		</div>
		<div class="span6">
			<?php echo $this->printMessage( 'GROUPB' );
		</div>		
	</div>
	
	# Output:
	<div class="container">
		<div class="span6">
			<div class="alert alert-info">
				<div>I am a information message!</div>
			</div>	
			<div class="alert alert-success">
				<div>I am a success message!</div>
			</div>
		</div>
		<div class="span6">
			<div class="alert alert-success">
				<div>I am a second success message!</div>
			</div>		
			<div class="alert alert-error">
				<div>I am a error message!</div>
			</div>
	</div>
		</div>
	</div>
	
Store messages in the session
--------
Sometimes it's needed to show one or more messages after the reload of the page. In that case the messages should be stored in the session.
It's quite easy. 

	<?php
	
	# Just use these methods (in your controller) to store the messages into the session
	$this->_helper->flashMessenger->addSessionSuccessMessage( 'I am a success message and will be displayed on the next reload of the page!' );
	$this->_helper->flashMessenger->addSessionInformationMessage( 'I am a information message and will be displayed on the next reload of the page!' );
	$this->_helper->flashMessenger->addSessionErrorMessage( 'I am a error message and will be displayed on the next reload of the page!' );
	
	?>
	