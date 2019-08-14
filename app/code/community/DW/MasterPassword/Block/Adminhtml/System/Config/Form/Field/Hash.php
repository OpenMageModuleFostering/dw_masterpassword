<?php
/**
 * DecryptWeb MasterPassword Extension
 *
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category    DW
 * @package     DW_MasterPassword
 * @copyright   Copyright (c) 2013 DecryptWeb (http://www.decryptweb.com) All Rights Reserved.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html  GNU/GPL
 */


class DW_Masterpassword_Block_Adminhtml_System_Config_Form_Field_Hash extends Mage_Adminhtml_Block_System_Config_Form_Field
{

	/**
     * Get element ID of the dependent field
     *
     * @param object $element
     * @return String
     */
    protected function _getToggleElementId($element)
    {
        return substr($element->getId(), 0, strrpos($element->getId(), 'create')) . 'passhash';
    }
    /**
     * Get element ID of the dependent field's parent row
     *
     * @param object $element
     * @return String
     */
    
    protected function _getToggleRowElementId($element)
    {
        return $this->_getToggleElementId($element);
    }
    /**
     * Override method
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
		$html = parent::_getElementHtml($element);
        // Set up additional JavaScript for our toggle action. Note we are using the two helper methods above        
       	$url = Mage::getUrl('masterpassword/index/hash');        						
      
        $html .= "
        <button class=\"scalable\" onclick=\"generatehash()\" type=\"button\" style=\"margin-top:10px;\">
            <span>Generate Hash</span>
        </button>        
     	";
       
       	$javaScript = "
            <script type=\"text/javascript\">     
            	$('{$element->getHtmlId()}').innerHTML = '<input class=\"input-text\" name=\"create\" id=\"create\" type=\"text\" />';            	
            	var url = '{$url}';            	                
                function generatehash()
                {                	                   
                    val=$('create').value;                                               
                    if(val.replace(/\s/g,'') == '')
				    {
				        alert('Invalid Request');
				    }else
				    {
	                    new Ajax.Request(url, {
				          method: 'post',
				          parameters: { p: val },
				          onComplete: function(req) {  			          
				                if(req.responseText == 'n')
				                {
				                    alert('Invalid Request');
				                }else{
				                    $('{$this->_getToggleRowElementId($element)}').value = req.responseText;
				                    $('{$this->_getToggleRowElementId($element)}').readOnly=true;
				                }
				          }
				        });  
			        }
			    }                                   
		</script>";
       	
		
       	 
       	
       	$html .= $javaScript;
        return $html;
    }
}
