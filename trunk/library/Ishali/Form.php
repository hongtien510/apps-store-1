<?php

class HTS_Form extends Zend_Form
{
	protected $_social;
	protected $_params;

    /*
     * Define some options for form decorators
     */
	protected $_hidden_decorators = array(
		'ViewHelper',
		array('HtmlTag', array('tag' => 'div', 'class' => 'hidden'))
	);
    protected $_button_decorators = array(
		'ViewHelper',
		array('HtmlTag', array('tag' => 'div', 'class' => 'form_button'))
	);

    protected function _customDecorators($type_ele = null, $data_class = null, $label_class = null, $row_class = null)
    {
        $type   = 'ViewHelper';
        $data   = array('tag' => 'dd');
        $label  = array('tag' => 'dt');
        $row    = array('tag' => 'dl');

        if(!empty ($type_ele))      $type           = $type_ele;
        if(!empty ($data_class))    $data['class']  = $data_class;
        if(!empty ($label_class))   $label['class'] = $label_class;
        if(!empty ($row_class))     $row['class']   = $row_class;
        
        $decorators = array(
            $type, 'Description',
            array(array('data'  => 'HtmlTag'),$data),
            array(array('label' => 'Label'), $label),
            array(array('row'   => 'HtmlTag'), $row),
            array(array('error' => 'Errors'),   array('tag' => 'p',  'class' => 'errors'))
        );
        return $decorators;
    }

    /*
     * Define decorator for group 
     */
    protected $_group_decorators = array(
        'FormElements', 'Fieldset'
    );

    public function __construct($options = null)
	{
		$this->_preConstruct();
		parent::__construct($options);
		$this->_postConstruct();
	}

	private function _preConstruct()
	{
		$this->_social = HTS_Api::getInstance()->getSocialPlugin();
		$this->_params = Zend_Registry::get('params');
	}

	private function _postConstruct()
	{
		//TODO decorators don't work!?
		foreach ($this->_social->getPostedFields() as $name => $value)
		{
			$this->addElement('hidden', $name, array(
				'value' => $value,
				'decorators' => $this->_hidden_decorators
			));
		}
		$this->addElement('hidden', 'form_submitted', array(
			'value' => '1',
			'decorators' => $this->_hidden_decorators
		));
	}
    /**
     *
     * @param type $name
     * @param type $legend
     * @param type $order
     * @param type $elememts 
     * @return generate group from elements
     */
    protected function _generateGroup($name, $legend, $order, $elememts)
    {
        $this->addDisplayGroup(
            $elememts, 
            $name,
            array(
                'legend'    => $legend,
                'order'     =>$order
            )
        )->setDisplayGroupDecorators($this->_group_decorators);
    }     
    /**
     * @param type $message
     * @return string was translated 
     */
    protected function _translate($message)
    {
        return $this->getTranslator()->translate($message);
    }        

    /**
     * 
     * @param type $min
     * @param type $max
     * @param type $encoding
     * @param type $messages_prefixed
     * @return Zend_Validate_StringLength 
     */
    protected function _getValidatorStringLength($min = 0, $max = 255, $encoding = 'UTF-8', $messages_prefixed = "")
    {
        $messages_prefixed = strtoupper($messages_prefixed);
        $stringLength = new Zend_Validate_StringLength(array(
            'min' => $min,
            'max' => $max,
            'encoding' => $encoding
        ));
        $stringLength->setMessages(array(
            Zend_Validate_StringLength::INVALID => sprintf($this->_translate('ERROR_STRING_LENGTH_INVALID'), $this->_translate($messages_prefixed), $min, $max),
            Zend_Validate_StringLength::TOO_LONG => sprintf($this->_translate('ERROR_STRING_LENGTH_TOO_LONG'), $this->_translate($messages_prefixed), $max),
            Zend_Validate_StringLength::TOO_SHORT => sprintf($this->_translate('ERROR_STRING_LENGTH_TOO_SHORT'), $this->_translate($messages_prefixed), $min)
        ));
        return $stringLength;
    }
    /**
     *
     * @param type $messages_prefixed
     * @return \Zend_Validate_NotEmpty 
     */
    protected function _getValidatorNotEmpty($messages_prefixed = "")
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(sprintf($this->_translate("ERROR_NOT_EMPTY"), $this->_translate($messages_prefixed)), Zend_Validate_NotEmpty::IS_EMPTY);
        return $notEmpty;
    }
    /**
     *
     * @param type $max
     * @param type $messages_prefixed
     * @return \Zend_Validate_LessThan 
     */
    protected function _getValidatorLessThan($max = 100, $messages_prefixed = "")
    {
        $messages_prefixed = strtoupper($messages_prefixed);
        $lessThan = new Zend_Validate_LessThan($max);
        $lessThan->setMessage(sprintf($this->_translate('ERROR_LESS_THAN'), $this->_translate($messages_prefixed), $max), Zend_Validate_LessThan::NOT_LESS);
        return $lessThan;
    }
    /**
     *
     * @param type $min
     * @param type $messages_prefixed
     * @return \Zend_Validate_GreaterThan 
     */
    protected function _getValidatorGreaterThan($min = 5, $messages_prefixed = "")
    {
        $greaterThan = new Zend_Validate_GreaterThan($min);
        $greaterThan->setMessage(sprintf($this->_translate('ERROR_GREATER_THAN'), $this->_translate($messages_prefixed), $min), Zend_Validate_GreaterThan::NOT_GREATER);
        return $greaterThan;
    }
    /**
     *
     * @param type $min
     * @param type $max
     * @param type $messages_prefixed
     * @return \Zend_Validate_Between 
     */
    protected function _getValidatorBetween($min = 5, $max = 100, $messages_prefixed = "")
    {
        $between = new Zend_Validate_Between(array(
            'min' => $min,
            'max' => $max
        ));
        $between->setMessage(sprintf($this->_translate('ERROR_BETWEEN'), $this->_translate($messages_prefixed), $min, $max), Zend_Validate_Between::NOT_BETWEEN);
        return $between;
    }
    /**
     *
     * @param type $pattern
     * @param type $messages_prefixed
     * @return \Zend_Validate_Regex 
     */
    protected function _getValidatorRegex($pattern, $messages_prefixed = "")
    {
        $regex = new Zend_Validate_Regex(array(
            'pattern' => $pattern
        ));
        $regex->setMessage(sprintf($this->_translate('ERROR_NOT_MATCH_PATTERN'), $this->_translate($messages_prefixed)), Zend_Validate_Regex::NOT_MATCH);
        return $regex;
    }
    /**
     *
     * @param type $min
     * @param type $max
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_Count 
     */
    protected function _getValidatorFileCount($min = 0, $max = 1, $messages_prefixed = "")
    {
        $file = new Zend_Validate_File_Count(array(
            'min' => $min,
            'max' => $max
        ));
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_COUNT_TO_FEW'), $this->_translate($messages_prefixed), $min), Zend_Validate_File_Count::TOO_FEW);
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_COUNT_TO_MANY'), $this->_translate($messages_prefixed), $max), Zend_Validate_File_Count::TOO_MANY);
        return $file;
    }
    /**
     *
     * @param type $extensions
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_Extension 
     */
    protected function _getValidatorFileExtensions($extensions, $messages_prefixed = "")
    {
        $file = new Zend_Validate_File_Extension($extensions);
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_FALSE_EXTENSION'), $this->_translate($messages_prefixed)), Zend_Validate_File_Extension::FALSE_EXTENSION);
        return $file;
    }
    /**
     *
     * @param type $min
     * @param type $max
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_Size 
     */
    protected function _getValidatorFileSize($min = 0, $max = "200kB", $messages_prefixed = "")
    {
        $file = new Zend_Validate_File_Size(array(
            'min' => $min,
            'max' => $max
        ));
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_TO_BIG'), $this->_translate($messages_prefixed), $max), Zend_Validate_File_Size::TOO_BIG);
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_TO_SMAILL'), $this->_translate($messages_prefixed), $min), Zend_Validate_File_Size::TOO_SMALL);
        return $file;
    }
    /**
     *
     * @param string $mime_type
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_IsImage 
     */
    protected function _getValidateIsImage($mime_type = array(), $messages_prefixed = "")
    {
        if (empty($mime_type))
        {
            $mime_type = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
        }
        $image = new Zend_Validate_File_IsImage($mime_type);
        $image->setMessage(sprintf($this->_translate('ERROR_IMAGE_FALSE_TYPE'), $this->_translate($messages_prefixed)), Zend_Validate_File_IsImage::FALSE_TYPE);
        return $image;
    }
    /**
     *
     * @param type $minHeight
     * @param type $maxHeight
     * @param type $minWidth
     * @param type $maxWidth
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_ImageSize 
     */
    protected function _getValidateImageSize($minHeight = 40, $maxHeight = 320, $minWidth = 40, $maxWidth = 800, $messages_prefixed = "")
    {
        $image = new Zend_Validate_File_ImageSize(array(
            'minHeight' => $minHeight,
            'maxHeight' => $maxHeight,
            'minWidth'  => $minWidth,
            'maxWidth'  => $maxWidth
        ));
        $image->setMessage(sprintf($this->_translate('ERROR_IMAGE_HEIGHT_TOO_SMALL'), $this->_translate($messages_prefixed), $minHeight), Zend_Validate_File_ImageSize::HEIGHT_TOO_SMALL);
        $image->setMessage(sprintf($this->_translate('ERROR_IMAGE_HEIGHT_TOO_BIG'), $this->_translate($messages_prefixed), $maxHeight), Zend_Validate_File_ImageSize::HEIGHT_TOO_BIG);
        $image->setMessage(sprintf($this->_translate('ERROR_IMAGE_WIDTH_TO_SMALL'), $this->_translate($messages_prefixed), $minWidth), Zend_Validate_File_ImageSize::WIDTH_TOO_SMALL);
        $image->setMessage(sprintf($this->_translate('ERROR_IMAGE_WIDTH_TO_BIG'), $this->_translate($messages_prefixed), $maxWidth), Zend_Validate_File_ImageSize::WIDTH_TOO_BIG);
        return $image;
    }
    /**
     *
     * @param type $messages_prefixed
     * @return \Zend_Validate_File_Upload 
     */
    protected function _getValidatorFileUpload($messages_prefixed = "")
    {
        $file = new Zend_Validate_File_Upload();
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_NOT_UPLOADED'), $this->_translate($messages_prefixed)), Zend_Validate_File_Upload::NO_FILE);
        $file->setMessage(sprintf($this->_translate('ERROR_FILE_MAX_SIZE'), $this->_translate($messages_prefixed)), Zend_Validate_File_Upload::INI_SIZE);
        return $file;
    }
    /**
     *
     * @param <type> $element
     * @param <type> $prefixed
     * @param <type> $thumbnail
     * @return string 
     */
    public function receiveFile($element, $prefixed, $thumbnail = false)
    {
        $file_element = $this->$element;
        $file_info = $file_element->getFileInfo();
        if(!empty($file_info[$element]['name']))
        {    
            $file_name = $prefixed . $file_info[$element]['name'];
            $file_path = UPLOAD_PATH . '/' . $file_name;
            $adapter = $file_element->getTransferAdapter();
            $adapter->addFilter('Rename',array('target' => $file_path));
            if($adapter->receive())
            {
                if($thumbnail)
                {
                    $target = UPLOAD_THUMBAIL_PATH . '/' . $file_name;
                    $this->generateThumbnail(132, 132, $file_path, $target);
                }
                return $file_name;
            }
        }
        return "";
    }

    public function generateThumbnail($width, $height, $source, $target)
    {
        $this->resizeImage($width, $height, $source, $target);
    }

    protected function resizeImage($width, $height, $file, $target, $keepRatio = true, $keepSmaller = true)
    {
        list($oldWidth, $oldHeight, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($file);
                break;
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($file);
                break;
        }

        if (!$keepSmaller || $oldWidth > $width || $oldHeight > $height) {
            if ($keepRatio) {
                list($width, $height) = $this->_calculateWidth($oldWidth, $oldHeight, $width, $height);
            }
        } else {
            $width = $oldWidth;
            $height = $oldHeight;
        }

        $thumb = imagecreatetruecolor($width, $height);

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);

        switch ($type) {
            case IMAGETYPE_PNG:
                imagepng($thumb, $target);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($thumb, $target);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumb, $target);
                break;
        }
        return $target;
    }
    
    protected function _calculateWidth($oldWidth, $oldHeight, $width, $height)
    {
        $factor = max(($oldWidth/$width), ($oldHeight/$height));
        return array($oldWidth/$factor, $oldHeight/$factor);
    }
}