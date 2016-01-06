<?php
/**
  * role management model
  *
  * This is the main model for role management on the administration part.
  *
  * @author  	Donald Leiva <admin@donaldleiva.com>
  * @package	Admin/role_Management/Models
  */
class Role_model extends CI_Model {

	/**
	 * Constructor for this controller.
	 *
	 */

    function  __construct() {
        parent::__construct();
    }
	
	/**
	 * Gets role modules access information
	 *
	 * @param	int			role ID
	 * @return	array		role modules information
	 */		
	function get_access_modules($role_id = NULL)
	{
		$this->db->from('administrator_module m')
			->join('administrator_module_closure as mc', 'm.module_id=mc.child AND mc.depth=1', 'left')
			->order_by('m.order, mc.child, mc.parent, mc.depth');
	
		if ($role_id != NULL)
		{
			$this->db->select('mc.parent, m.module_id, m.name, IF(ma.module_id IS NULL, 0, 1) as access', FALSE)
				->join('administrator_module_access ma', 'm.module_id=ma.module_id AND ma.role_id=' . $role_id, 'left');
		} else
		{
			$this->db->select('mc.parent, m.module_id, mc.parent, m.name, 0 as access', FALSE);
		}
	
        $query = $this->db->get();

        if ($query->num_rows() > 0)
		{
			return $query->result();
		}
        else
            return 0;
	}

	/**
	 * Inserts role's modules access
	 *
	 * @param	int			Role ID
	 * @param	array		Module accesses data
	 * @return	bool		TRUE if successful, false if not
	 */		
	function insert_modules_access($role_id, $access)
	{
		if (is_array($this->modules_access))
		{
			$this->db->trans_start();
		
			$this->db->where('role_id', $rol_id);
			$this->db->delete('administrator_module_access'); 
		
			$this->db->distinct()
				->select('mc.parent')
				->from('administrator_module m')
				->join('administrator_module_closure as mc', 'm.module_id=mc.child AND mc.depth=1', 'left')
				->where_in('module_id', $access);

			$query	= $this->db->get();
			if ($query->num_rows() > 0)
			{
				$rows	= $query->result();
				foreach ($rows as $row)
				{
					$access[]	= $row->parent;
				}
			}
			
			foreach($access as $module_id)
			{
				$this->db->insert('administrator_module_access', array(
				   'role_id' => $role_id,
				   'module_id' => $module_id,
				   'add' => 1,
				   'edit' => 1,
				   'delete' => 1
				));
			}

			$this->db->trans_complete();
		
			if ($this->db->trans_status() === FALSE)
			{
				return FALSE;
			}
			else
				return TRUE;
		}
		else
			return FALSE;
	}	
}