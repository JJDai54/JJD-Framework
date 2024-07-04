<?php
/**
 * XOOPS Form Class Elements
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         JJD_Framework
 * @subpackage      form
 * @since           2.5.0
 * @author          JJDai <jjdelalandre@orange.fr>
 * @version         $Id: formbuttontray.php 8066 2011-11-06 05:09:33Z beckmi $
 * 
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');
if(defined('JJD_DEBUG'))
if (JJD_DEBUG) echo "<hr>========= " . __FILE__. " =================<hr>";

/**
 *
 * @author 		JJDai <jjdelalandre@orange.fr>
 * @package 	JJD_Framework
 * @access 		public
 */
class jjdPermissions{
var $memberHandler;
var $groupList;
var $fullList;
var $grouppermHandler;
var $dirname;
var $module;

/***************************************************************************
Renvoie la valeur d'un bit préciser par un index dans la valeur binaire
****************************************************************************/
  function __construct($dirname='')
  {global $xoopsModule;
		$this->memberHandler = xoops_getHandler('member');
		$this->groupList = $this->memberHandler->getGroupList();
		$this->fullList[] = array_keys($this->groupList);
		$this->grouppermHandler = xoops_getHandler('groupperm');
		$this->dirname = $dirname;
        
        if($dirname){
          $module_handler = xoops_getHandler('module');
          $this->module = $module_handler->getByDirname($this->dirname);
        }else{
          $this->module = $xoopsModule;
        }
        
  }


	/**
	 * @public function checkAndRedirect
	 * redirige sur "url" si pas de permisssion
	 *
	 * @param $permName  nom des permissions "gpermName"
	 * @param $permId  id des permisssions "gpermId"
	 * @param $varName  nom de la raible qui contient $permId
	 * @param $url  url de redirection si il n'y a pas de permission
	 * @return true si pas e redirection
	 */
    function checkAndRedirect($permName, $permId,$varName, $url, $adminOk=false){
    global $clPerms;
    \define('_CO_JJD_NO_PERM2', "Vous n'avez pas les permissions pour accéder à cette fonctionalité !<br>mod : %s : Permission=%s ===> %s=%s");
        if (!$clPerms->getPermissions($permName, $permId, $adminOk)){
            $msg =  sprintf(_CO_JJD_NO_PERM2, $this->module->mid(), $permName,$varName,$permId);
            redirect_header($url, 5, $msg);
        }  
    }
    
	/**
	 * @public function getGroupIds
	 * returns arr liste des groupes
	 *
	 * @param $adminOk bool force topus les groupes si admin
	 * @return array
	 */
	function getGroupIds(){
        global $xoopsUser,$memberHandler;
        
		$currentuid = 0;
		if (isset($xoopsUser) && is_object($xoopsUser)) {
            $currentuid = ($xoopsUser) ? $xoopsUser->uid() : 2;
		}
        
        $mid = $this->module->mid();
		if ($currentuid == 0) {
			$my_group_ids = [XOOPS_GROUP_ANONYMOUS]; //XOOPS_GROUP_ADMIN
		}else{
		    $memberHandler = xoops_getHandler('member');
			$my_group_ids = $memberHandler->getGroupsByUser($currentuid);
        }
        
        //echo "<code>mid = {$mid} - uid = {$currentuid}<br><pre>" . print_r($my_group_ids,true) . "</pre></code><hr>";
		return $my_group_ids;
    }


	/**
	 * @public function permGlobalApprove
	 * returns right for global approve
	 *
	 * @param $itemId int id des permission
	 * @param $permName string nom des permissions sans le nom du module
	 * @return bool
	 */
	function getPermissions($permName, $itemId = 0, $adminOk=false)
	{
		global $xoopsUser, $xoopsModule;
        
        if($itemId == 0){
            $ids = $this->getIdsPermissions($permName, $adminOk);
            return(isset($ids));
        }
		$mid = $this->module->mid();
 
		//-----------------------------------------------------------
        if($xoopsUser->isAdmin($mid) && $adminOk) return true;
		//-----------------------------------------------------------
        $fullPermName = $this->module->getVar('dirname') . '_' . $permName; 
        $my_group_ids = $this->getGroupIds($adminOk);

        if ($this->grouppermHandler->checkRight($fullPermName, $itemId, $my_group_ids, $mid, false)) {
			return true;
		}
 
		return false;
	}

	function getIdsPermissions($permName, $adminOk=false)
	{
		global $xoopsUser, $xoopsModule;
		$fullPermName = $this->module->getVar('dirname') . '_' . $permName; 
        $idsArr = null;
        
        $my_group_ids = $this->getGroupIds($adminOk);

		$this->grouppermHandler = xoops_getHandler('groupperm');
		$mid = $this->module->mid();
		$memberHandler = xoops_getHandler('member');
        
        $idsArr =  $this->grouppermHandler->getItemIds($fullPermName, $my_group_ids, $mid);
		return $idsArr;
	}
    
	/**
	 * @public function getWhereIdsPermissions
	 * returns right for global approve
	 *
	 * @param $permName string nom des permissions sans le nom du module
	 * @param $fldId nom du champ qui contient l'id qui correspopnd a celui des permission (gperm_id)
	 * @return string condition pour la clause Where
	 */
	function getWhereIdsPermissions($permName, $fldId){
        $arr = getIdsPermissions($permName);
        if ($arr){
          $ids = implode(',', $arr);
          $where = "{$fldId} IN ($ids)";
          return $where;
          }
    }
    
    
    
	/**
	 * @public function addPermissions
	 * returns right for global approve
	 *
	 * @param &$criteria Criteria passé en reference object criteria deja instancie ou non
	 * @param $permName string nom des permissions sans le nom du module
	 * @param $fldId nom du champ qui contient l'id qui correspopnd a celui des permission (gperm_id)
	 * @return bool
	 */
	function addPermissions(&$criteria,$permName, $fldId){
        $arr = $this->getIdsPermissions($permName);
        if(!$criteria) $criteria = new CriteriaCompo();
        if ($arr){
            $ids = implode(',', $arr);
          $criteria->add(new Criteria($fldId, '(' . $ids . ')', 'IN'));
          //echo "<hr>addPermissions => " . $criteria->renderWhere(). "<hr>";
          return true;
        }else{
          $criteria->add(new Criteria($fldId, -1, '='));
          return false;
        }
        
    }
    
    
    
	/**
	 * @public function getPermForm
	 * returns form for perm
	 *
	 * @param $formTitle Titre du formulaire
	 * @param $permName  Nom des permissions sans le nom du module
	 * @param $permDesc  Description des permissions
	 * @param $permArr   Tableau itemId/name des permission
	 * @return XoopsGroupPermForm
	 */
     
	function getPermissionsForm($formTitle, $permName, $permDesc, $permArr)
	{
    global $xoopsModule;
		$fullPermName = $this->module->getVar('dirname') . '_' . $permName;
		//$handler = $quizmakerHelper->getHandler('quiz');
        $moduleId = $this->module->getVar('mid');
        $permform = new \XoopsGroupPermForm($formTitle, $moduleId, $fullPermName, $permDesc, 'admin/permissions.php');
    	foreach($permArr as $permId => $name) {
    		$permform->addItem($permId, $name);
    	}
        return $permform;
	}

	/**
	 * @public function getPermForm
	 * returns form for perm
	 *
	 * @param $formTitle Titre du formulaire
	 * @param $permName  Nom des permissions sans le nom du module
	 * @param $permDesc  Description des permissions
	 * @param $permArr   Tableau itemId/name des permission
	 * @return XoopsGroupPermForm
	 */
	function getCheckboxByGroup($label, $name, $itemId, $permName, $isNew)
	{
        $fullPermName = $this->module->getVar('dirname') . '_' . $permName;
		
        if ($isNew) {
			$groupsIdsEdit = new \XoopsFormCheckBox( $label, $name, $this->fullList);
        }else{
			$groupsIdsEdit = $this->grouppermHandler->getGroupIds($fullPermName, $itemId, $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsEdit[] = array_values($groupsIdsEdit);
			$groupsIdsEdit = new \XoopsFormCheckBox($label , $name, $groupsIdsEdit);
        }
        $groupsIdsEdit->addOptionArray($this->groupList);
        return $groupsIdsEdit;
	}


	function savePermission($permName, $permId, $permArr)
	{
        $fullPermName = $this->module->getVar('dirname') . '_' . $permName;
        $mid = $this->module->getVar('mid') ;
        // delete permissions before add new
        $this->grouppermHandler->deleteByModule($mid, $fullPermName, $permId);
        
		if (isset($permArr)) {
			foreach($permArr as $onegroupId) {
				$this->grouppermHandler->addRight($fullPermName , $permId, $onegroupId, $mid);
			}
		}
            


	}


 }  // ----- Fin de la classe -----
 
?>
