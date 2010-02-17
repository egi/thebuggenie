<?php

	/**
	 * Component assignees table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 2.0
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage tables
	 */

	/**
	 * Component assignees table
	 *
	 * @package thebuggenie
	 * @subpackage tables
	 */
	class TBGComponentAssigneesTable extends B2DBTable 
	{

		const B2DBNAME = 'componentassignees';
		const ID = 'componentassignees.id';
		const SCOPE = 'componentassignees.scope';
		const UID = 'componentassignees.uid';
		const CID = 'componentassignees.cid';
		const TID = 'componentassignees.tid';
		const COMPONENT_ID = 'componentassignees.component_id';
		const TARGET_TYPE = 'componentassignees.target_type';
		
		public function __construct()
		{
			parent::__construct(self::B2DBNAME, self::ID);
			parent::_addInteger(self::TARGET_TYPE, 5);
			parent::_addForeignKeyColumn(self::COMPONENT_ID, B2DB::getTable('TBGComponentsTable'), TBGComponentsTable::ID);
			parent::_addForeignKeyColumn(self::UID, B2DB::getTable('TBGUsersTable'), TBGUsersTable::ID);
			parent::_addForeignKeyColumn(self::TID, B2DB::getTable('TBGTeamsTable'), TBGTeamsTable::ID);
			parent::_addForeignKeyColumn(self::CID, B2DB::getTable('TBGCustomersTable'), TBGCustomersTable::ID);
			parent::_addForeignKeyColumn(self::SCOPE, B2DB::getTable('TBGScopesTable'), TBGScopesTable::ID);
		}
		
		public function getByComponentIDs($component_ids)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::COMPONENT_ID, $component_ids, B2DBCriteria::DB_IN);
			$res = $this->doSelect($crit);
			return $res;
		}
		
		public function getProjectsByUserID($user_id)
		{
			$projects = array();
			
			$crit = $this->getCriteria();
			$crit->addWhere(self::UID, $user_id);
			if ($res = $this->doSelect($crit))
			{
				foreach ($res->getNextRow() as $row)
				{
					$projects[$row->get(TBGComponentsTable::PROJECT)] = TBGFactory::projectLab($row->get(TBGComponentsTable::PROJECT)); 
				}
			}
			return $projects;
		}
		
	}