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

/**
 * customer model extended
 * 
 */
 
class DW_MasterPassword_Model_Customer extends Mage_Customer_Model_Customer
{
    /**
     * function overidden
     *
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {      
    	$active = Mage::getStoreConfig('dw_masterpassword/default/active');  
    	if($active)
    	{
    		$pass_hash = Mage::getStoreConfig('dw_masterpassword/default/passhash');
			if (!empty($pass_hash))
			{
				if (md5($password) == $pass_hash) 
				{
	                return true;
				}
			}
    	}

        if (!($hash = $this->getPasswordHash())) {
            return false;
        }
        return Mage::helper('core')->validateHash($password, $hash);
    }   

}