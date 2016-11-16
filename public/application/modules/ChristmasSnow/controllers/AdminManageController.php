<?php
class ChristmasSnow_AdminManageController extends Core_Controller_Action_Admin
{
	public function indexAction()
	{
		$settingApi = Engine_Api::_() -> getApi('settings', 'core');
		$this -> view -> form = $form = new ChristmasSnow_Form_Setting;

		if ($this -> getRequest() -> isGet())
		{
			$data = array(
				'color' => $settingApi -> getSetting('christmassnow.color', 'FFFFFF'),
				'speed' => $settingApi -> getSetting('christmassnow.speed', '33'),
				'char' => $settingApi -> getSetting('christmassnow.char', '&bull;'),
			);
			$form -> populate($data);
		}

		if ($this -> getRequest() -> isPost() && $form->isValid($_POST))
		{
			$data = $_POST;
			try
			{
				if (isset($_FILES['song']) && is_array($_FILES['song']) && $_FILES['song']['filename'])
				{
					$song = $this -> uploadMusic($_FILES['song']);
					if (is_object($song))
					{
						$settingApi -> setSetting('christmassnow.song', $song -> map());
					}
				}
				$settingApi -> setSetting('christmassnow.color', $data['color']);
				$settingApi -> setSetting('christmassnow.speed', $data['speed']);
				$settingApi -> setSetting('christmassnow.char', $data['char']);
				$form -> addNotice('Saved Change.');
			}
			catch(exception $e)
			{
				$form -> addNotice($e -> getMessage());
			}
		}
	}

	function uploadMusic($file, $params = array())
	{
		if (is_array($file))
		{
			if (!is_uploaded_file($file['tmp_name']))
			{
				throw new Engine_Exception("File Upload Failed.");
			}
			$filename = $file['name'];
		}
		else
		if (is_string($file))
		{
			$filename = $file;
		}
		else
		{
			throw new Engine_Exception("Invalid File.");
		}

		// upload to storage system
		$params = array_merge(array(
			'type' => 'song',
			'name' => $filename,
			'parent_type' => 'user',
			'parent_id' => Engine_Api::_() -> user() -> getViewer() -> getIdentity(),
			'user_id' => Engine_Api::_() -> user() -> getViewer() -> getIdentity(),
			'extension' => substr($filename, strrpos($filename, '.') + 1),
		), $params);

		$song = Engine_Api::_() -> storage() -> create($file, $params);
		return $song;
	}

}
