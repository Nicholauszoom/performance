<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{


	public function allProjects() {
		$query ="SELECT * FROM project where state = 1 ";
    	return DB::select(DB::raw($query));
	}
	public function myProjects($empID) {
		$query ="SELECT p.* FROM project p, activity a, employee_activity_grant eag WHERE p.code = a.project_ref AND a.code = eag.activity_code AND eag.empID = '".$empID."' ";
    	return DB::select(DB::raw($query));
	}
	public function allGrants() {
		$query ="SELECT * FROM grants ";
    	return DB::select(DB::raw($query));
	}
	public function activeGrants($activityCode) {
		$query ="SELECT * FROM grants WHERE code NOT IN(SELECT grant_code from activity_grant, activity WHERE  activity.code = activity_grant.activity_code AND activity.isActive = 1 AND activity.id = ".$activityCode.") ";
    	return DB::select(DB::raw($query));
	}

	public function activityGrants($activityCode) {
		$query ="SELECT * FROM activity_grant WHERE activity_code = (SELECT code FROM activity WHERE id = ".$activityCode.") ";
    	return DB::select(DB::raw($query));
	}

	public function checkExistance($activityCode) {
		$query ="SELECT COUNT(id) as counts FROM activity WHERE code = '".$activityCode."' ";
    	$row = $query->row();
    	return $row->counts;
	}


	public function allActivities() {
		$query ="SELECT * FROM activity Where isActive=1 ";
    	return DB::select(DB::raw($query));
	}

	public function myActivities($empID) {
		$query ="SELECT a.* FROM activity a, employee_activity_grant eag WHERE a.code = eag.activity_code AND eag.empID='".$empID."' ";
    	return DB::select(DB::raw($query));
	}

    public function anActivity($id) {
        $query ="SELECT id,code FROM activity WHERE id='".$id."' ";
        if ($query->row()){
            return DB::select(DB::raw($query));
        }else{
         return null;
        }
    }

    public function aProject($id) {
        $query ="SELECT id,code FROM project WHERE id='".$id."' ";
        if ($query->row()){
            return DB::select(DB::raw($query));
        }else{
            return null;
        }
    }

    public function allActivityInProject($code){
        $query ="SELECT * FROM activity WHERE project_ref='".$code."' and isActive = 1 ";
        return DB::select(DB::raw($query));

    }

    public function allEmployeeInActivity($code){
        $query ="SELECT * FROM employee_activity_grant WHERE activity_code='".$code."' and isActive = 1 ";
        return DB::select(DB::raw($query));

    }

	public function addProject($data)
	{
		$this->db->insert("project", $data);
    	return true;
	}

    public function addDeliverable($data)
	{
		$this->db->insert("deliverables", $data);
    	return true;
	}

	public function updateProject($updates, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('project', $updates);
		return true;
	}

	public function projectInfo($projectId) {
		$query ="SELECT p.*  FROM project p WHERE p.id = '".$projectId."' ";
    	return DB::select(DB::raw($query));
	}

    public function deliverableInfo($Id) {
		$query ="SELECT *  FROM deliverables  WHERE id = '".$Id."' ";
    	return DB::select(DB::raw($query));
	}
    
    public function getDepInfoById($Id){
        $query ="SELECT *  FROM department  WHERE id = '".$Id."' ";
    	return DB::select(DB::raw($query));
    }
    public function getEmpInfoById($Id){
        $query ="SELECT *  FROM employee  WHERE emp_id = '".$Id."' ";
    	return DB::select(DB::raw($query));
    }
    public function getActivityByID($Id) {
		$query ="SELECT *  FROM activities  WHERE id = '".$Id."' ";
    	return DB::select(DB::raw($query));
	}

    public function getProjectById($Id) {
		$query ="SELECT *  FROM project  WHERE id = '".$Id."' ";
    	return DB::select(DB::raw($query));
	}
    
    
    
    public function getAllActivity($projectId) {
		$query ="SELECT *  FROM activities  WHERE deliverable_id = '".$projectId."' ";
    	return DB::select(DB::raw($query));
	}
    
    public function getAllActivityResultByEmployeeID($emp_id) {
		$query ="SELECT *  FROM activity_results  WHERE managed_by = '".$emp_id."' ";
    	return DB::select(DB::raw($query));
	}

    public function getAllActivityByEmployeeID($emp_id) {
		$query ="SELECT *  FROM activities  WHERE managed_by = '".$emp_id."' ";
    	return DB::select(DB::raw($query));
	}
    

    public function getAllDeliverable($projectId) {
		$query ="SELECT *  FROM deliverables  WHERE project_id = '".$projectId."' ";
    	return DB::select(DB::raw($query));
	}

    public function projectInfoCode($projectId) {
        $query =" SELECT p.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name FROM project p, employee e WHERE e.emp_id = p.managed_by and p.code = '".$projectId."'";
        return DB::select(DB::raw($query));
    }

    public function projectInfoManager($projectId) {
        $query ="SELECT p.*, e.*, concat(e.fname,' ',e.mname,' ',e.lname) as name  FROM project p, employee e WHERE e.emp_id = p.managed_by and p.id = ".$projectId."";
        return DB::select(DB::raw($query));
    }


	public function addGrant($data)
	{
		$this->db->insert("grants", $data);
    	return true;
	}

	public function updateGrant($updates, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('grants', $updates);
		return true;
	}

	public function grantInfo($GrantId) {
		$query ="SELECT  * FROM grants WHERE id = ".$GrantId."";
    	return DB::select(DB::raw($query));
	}

	public function fetchActivities($projectCode) {
		$query ="SELECT  * FROM activity WHERE isActive = 1 AND project_ref = '".$projectCode."'";
    	return DB::select(DB::raw($query));
	}

	public function fetchGrants($activityCode) {
		$query ="SELECT  ag.*, g.name FROM activity_grant ag, grants g WHERE ag.grant_code = g.code AND ag.activity_code = '".$activityCode."'";
    	return DB::select(DB::raw($query));
	}

    public function fetchActivityEmployee($activityCode) {
        $query ="SELECT  eg.*, concat(e.fname,' ',e.mname,' ',e.lname) as name FROM employee_activity_grant eg, employee e WHERE eg.empID = e.emp_id AND eg.activity_code = '".$activityCode."' and e.state != 4 ";
        return DB::select(DB::raw($query));
    }
    

    public function addActivityResult($activityData)
    {
      $this->db->insert("activity_results", $activityData);
     // $this->db->insert("activity_grant", $grantData);
      return true;
    }

  	public function addActivity($activityData)
    {
      $this->db->insert("activities", $activityData);
     // $this->db->insert("activity_grant", $grantData);
      return true;
    }

    // public function addActivity($activityData, $grantData)
    // {
    //   $this->db->insert("activity", $activityData);
    //   $this->db->insert("activity_grant", $grantData);
    //   return true;
    // }

    public function updateActivity($updates, $id)
    {
      $this->db->where('id', $id);
      $this->db->update('activity', $updates);
      return true;
    }

    public function allocateGrantToActivity($data)
    {
      $this->db->insert("activity_grant", $data);
      return true;
    }

    public function activityInfo($ActivityId) {
      $query ="SELECT  a.*, p.name as projectName,  p.code as projectCode FROM activity a, project p WHERE a.project_ref = p.code  AND a.id = ".$ActivityId."";
        return DB::select(DB::raw($query));
    }

	public function checkDuplicateAllocation($activityId, $employeeId,$grant_code) {
		$query ="SELECT count(id) as counts FROM employee_activity_grant WHERE isActive = 1 and empID = '".$employeeId."' AND activity_code = '".$activityId."' AND grant_code = '".$grant_code."'";
    	$row = $query->row();
    	return $row->counts;
	}
	public function checkEmployeeTotalPercentAllocation($employeeId) {
		$query ="SELECT SUM(eag.percent) as totalPercent FROM employee_activity_grant eag WHERE eag.isActive = 1 and eag.empID = '".$employeeId."'";
    	$row = $query->row();
    	return $row->totalPercent;
	}

    public function employeeAllocationPercentage($empID) {
        $query ="SELECT empID, SUM(eag.percent) as totalPercent FROM employee_activity_grant eag where empID = '".$empID."' and isActive = 1 group by empID";
        $default_allocation = $this->employeeDefaultAvailablePercentage($empID);
        return [$query->result(),$default_allocation];
    }

    public function employeeDefaultAvailablePercentage($empID) {
        $query ="SELECT SUM(eag.percent) as totalPercent FROM employee_activity_grant eag where activity_code = 'AC0018'and grant_code = 'VSO' and empID = '".$empID."' and isActive = 1";
        if ($query->row()){
            $row = $query->row();
            return $row->totalPercent;
        }else{
            return null;
        }

    }

    public function allocatedPercentage($id) {
        $query ="SELECT empID FROM employee_activity_grant eag where id = '".$id."' and isActive = 1";
        $row = $query->row();
        return $row->empID;
    }

    public function checkDefaultAllocation($empID) {
        $query ="select * from employee_activity_grant where empID='".$empID."' and activity_code = 'AC0018'and grant_code = 'VSO'";
        return DB::select(DB::raw($query));
    }

    public function updateDefaultAllocationPercentage($data) {
       "UPDATE employee_activity_grant SET percent='".$data['percent']."', isActive = '".$data['active']."' WHERE empID='".$data['empID']."' and activity_code = 'AC0018'and grant_code = 'VSO'";
        return true;
    }

    public function insertDefault($data){
	    $this->db->insert('employee_activity_grant',$data);
	    return true;
    }

    public function inactiveAllocation($activityId, $employeeId,$grant_code) {
        $query ="SELECT id FROM employee_activity_grant WHERE isActive = 0 and empID = '".$employeeId."' AND activity_code = '".$activityId."' AND grant_code = '".$grant_code."'";
        if ($query->row()){
            $row = $query->row();
            return $row->id;
        }else{
            return null;
        }
    }

  	public function allocateActivity($data)
    {
      $this->db->insert("employee_activity_grant", $data);
        return true;
    }

    public function updateAllocationActivity($data)
    {
       "UPDATE employee_activity_grant SET percent='".$data['percent']."',isActive='".$data['active']."' WHERE id='".$data['row_id']."'";
        return true;
    }

	public function getProjectAllocations() {

//		$query ="SELECT eag.*, g.name as grant_name, pr.name as project_name, pr.code as project_code, a.name as activity_name, CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee_name, d.name as department, p.name AS position
//FROM  activity a, employee e, grants g, project pr, position p, department d, (SELECT * FROM employee_activity_grant UNION SELECT * FROM vw_employee_auto_activity_allocation ) as eag
//WHERE e.emp_id = eag.empID AND e.position = p.id AND e.department = d.id AND g.code = eag.grant_code AND a.code = eag.activity_code AND a.isActive = 1 AND  eag.isActive = 1 AND a.project_ref = pr.code";
        $query ="SELECT eag.*, g.name as grant_name, pr.name as project_name, pr.code as project_code, a.name as activity_name, CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee_name, d.name as department, p.name AS position
FROM  activity a, employee e, grants g, project pr, position p, department d, employee_activity_grant as eag
WHERE e.emp_id = eag.empID AND e.position = p.id AND e.department = d.id AND g.code = eag.grant_code AND a.code = eag.activity_code AND a.isActive = 1 AND  eag.isActive = 1 AND a.project_ref = pr.code and e.state != 4";

        return DB::select(DB::raw($query));
	}

    public function getProjectAllocationsByLineManager($empID) {
	    $query ="SELECT eag.*, g.name as grant_name, pr.name as project_name, pr.code as project_code, a.name as activity_name, CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee_name, d.name as department, p.name AS position
FROM  activity a, employee e, grants g, project pr, position p, department d, employee_activity_grant as eag
WHERE e.emp_id = eag.empID AND e.position = p.id AND e.department = d.id AND g.code = eag.grant_code AND a.code = eag.activity_code AND a.isActive = 1 AND  eag.isActive = 1 AND a.project_ref = pr.code and e.line_manager = '".$empID."' and e.state != 4";

        return DB::select(DB::raw($query));
    }


	public function myProjectAllocations($empID) {
		$query ="SELECT eag.*, g.name as grant_name, pr.name as project_name, pr.code as project_code, a.name as activity_name, CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee_name, d.name as department, p.name AS position
FROM  activity a, employee e, grants g, project pr, position p, department d, employee_activity_grant eag
WHERE e.emp_id = eag.empID AND e.position = p.id AND e.department = d.id AND g.code = eag.grant_code AND a.code = eag.activity_code AND a.isActive = 1 AND  eag.isActive = 1 AND a.project_ref = pr.code AND eag.empID = '".$empID."'";
    	return DB::select(DB::raw($query));
	}

	public function deleteActivity($activityCode)
	{
		$this->db->trans_start();
		$query ="DELETE FROM activity_grant WHERE activity_code = (SELECT code FROM activity  WHERE id = ".$activityCode.")";
		$query ="DELETE FROM employee_activity_grant WHERE activity_code = (SELECT code FROM activity  WHERE id = ".$activityCode." ) ";
		$query ="DELETE FROM activity WHERE id = ".$activityCode."";
		$this->db->trans_complete();
		return true;
	}

	public function employeeCurrentAllocation($empID){
		$query ="SELECT SUM(percent) as currentAllocation FROM employee_activity_grant WHERE empID = '".$empID."'";
		$row = $query->row();
    	return $row->currentAllocation;
	}

	public function deleteAllocation($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("employee_activity_grant");
		return true;
	}

	public function deactivateAllocation($id, $data)
	{
		$this->db->where("id", $id);
		$this->db->update("employee_activity_grant", $data);
		return true;
	}
	public function deleteActivityGrant($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("activity_grant");
		return true;
	}

    public function deactivateActivity($id, $data)
    {
        $this->db->where("id", $id);
        $this->db->update("activity", $data);
        return true;
    }

    public function deactivateProject($id, $data)
    {
        $this->db->where("id", $id);
        $this->db->update("project", $data);
        return true;
    }

    public function addAssignment($data)
    {
        $this->db->insert("assignment", $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateAssignment($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('assignment', $data);
        return true;
    }

    public function addAssignmentEmployee($data)
    {
        $this->db->insert("assignment_employee", $data);
        return true;
    }

    public function myAssignments($emp_id,$assignID){
	    $query ="select distinct a.*, ae.id as assignment_employee_id from assignment a, assignment_employee ae where a.id = ae.assignment_id
and ae.emp_id = '".$emp_id."' and a.id = '".$assignID."' ";
	    return DB::select(DB::raw($query));
    }

    public function myAssignmentsAll($emp_id){
        $query ="select distinct a.*, ae.id as assignment_employee_id from assignment a, assignment_employee ae where a.id = ae.assignment_id
and ae.emp_id = '".$emp_id."'";
        return DB::select(DB::raw($query));
    }

    public function allAssignments($id){
        $query ="select a.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name, e.emp_id from assignment a, assignment_employee ae, employee e where a.id = ae.assignment_id and e.emp_id = ae.emp_id and a.id = '".$id."' ";
        return DB::select(DB::raw($query));
    }

    public function deleteEmployeeAssignment($assignID,$emp_id){
	   "delete from assignment_employee where assignment_id = '".$assignID."' and emp_id ='".$emp_id."' and status = 0 ";
	    return true;
    }

    public function addTask($data){
        $this->db->insert("assignment_task", $data);
        return true;
    }

    public function addException($data){
        $this->db->insert("assignment_exception", $data);
        return true;
    }

    public function allTimeTrackAll($emp_id,$assignID){
	    $query ="select ast.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name from assignment_task ast, assignment_employee ae, assignment a, employee e where ast.assignment_employee_id = ae.id
and a.id = ae.assignment_id and e.emp_id = ae.emp_id and a.assigned_by = '".$emp_id."'  and a.id = '".$assignID."'  ";
	    return DB::select(DB::raw($query));
    }

    public function myTimeTrack($emp_id, $assignID){
        $query ="select ast.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name from assignment_task ast, assignment_employee ae, assignment a, employee e where ast.assignment_employee_id = ae.id
and a.id = ae.assignment_id and e.emp_id = ae.emp_id and ae.emp_id = '".$emp_id."' and a.id = '".$assignID."' ";
        return DB::select(DB::raw($query));
    }

    public function myTimeTrackAll($emp_id){
        $query ="select ast.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name from assignment_task ast, assignment_employee ae, assignment a, employee e where ast.assignment_employee_id = ae.id
and a.id = ae.assignment_id and e.emp_id = ae.emp_id and ae.emp_id = '".$emp_id."' ";
        return DB::select(DB::raw($query));
    }

    public function allException($emp_id){
        $query ="select aex.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name from assignment_exception aex, assignment_employee ae, assignment a, employee e where aex.emp_id = ae.emp_id and a.id = ae.assignment_id and e.emp_id = ae.emp_id and a.assigned_by = '".$emp_id."' ";
        return DB::select(DB::raw($query));
    }

    public function myException($emp_id){
        $query ="select aex.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as e_name from assignment_exception aex, assignment_employee ae, assignment a, employee e where aex.emp_id = ae.emp_id and a.id = ae.assignment_id and e.emp_id = ae.emp_id and aex.emp_id = '".$emp_id."' ";
        return DB::select(DB::raw($query));
    }

    public function updateTask($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('assignment_task', $data);
        return true;
    }

    public function taskComment($data){
        $this->db->insert("assignment_task_comment", $data);
        return true;
    }

    public function allComment($id){
	    $query ="select atc.*, at.task_name,concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from assignment_task_comment atc, assignment_task at, employee e where at.id = atc.task_id and e.emp_id = atc.remark_by and task_id = '".$id."' ";
	    return DB::select(DB::raw($query));
    }

    public function deleteComment($id){
	   "delete from assignment_task_comment where id = '".$id."' ";
	    return true;
    }

    public function allAssignmentCosts($id){
        $query ="select ac.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from activity_cost ac, employee e
            where e.emp_id = ac.emp_id and ac.assignment = '".$id."' ";
        return DB::select(DB::raw($query));
    }

}
