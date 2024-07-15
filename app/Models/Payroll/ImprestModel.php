<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImprestModel {

    function my_imprests($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status = 2 AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE  im.empID = '".$empID."' GROUP BY im.id ORDER BY im.id DESC ";
		return DB::select(DB::raw($query));
	}

	function othersImprests($empID)
	{
		$query = "WITH seq AS (
    SELECT ROW_NUMBER() OVER (ORDER BY im.id DESC) AS SNo,
           im.*,
           (SELECT CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname)
            FROM employee e
            WHERE im.empID = e.emp_id) AS name,
           CASE
               WHEN (SELECT COUNT(id)
                     FROM imprest_requirement
                     WHERE \"imprestID\" = im.id) > 0
               THEN (SELECT SUM(initial_amount)
                     FROM imprest_requirement
                     WHERE \"imprestID\" = im.id)
               ELSE 0
           END AS requested_amount,
           CASE
               WHEN (SELECT COUNT(id)
                     FROM imprest_requirement
                     WHERE status = 1
                     AND \"imprestID\" = im.id) > 0
               THEN (SELECT SUM(final_amount)
                     FROM imprest_requirement
                     WHERE status = 1
                     AND \"imprestID\" = im.id)
               ELSE 0
           END AS approved_amount,
           CASE
               WHEN (SELECT COUNT(id)
                     FROM imprest_requirement
                     WHERE \"imprestID\" = im.id) > 0
               THEN (SELECT SUM(initial_amount)
                     FROM imprest_requirement
                     WHERE status = 2
                     AND \"imprestID\" = im.id)
               ELSE 0
           END AS confirmed_amount,
           (SELECT COUNT(id)
            FROM imprest_requirement
            WHERE status != 4
              AND \"imprestID\" = im.id) AS pending_requirements
    FROM imprest im
    WHERE im.empID != empID
)
SELECT *
FROM seq
ORDER BY SNo DESC
         ";
		return DB::select(DB::raw($query));
	}

	/*function other_imprests_hr_fin()
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 4 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 4 AND imprestID = im.id ), 0)  as final_cost, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status IN(1,2,3,4,5) AND imprestID = im.id ), 0)  as initial_cost, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s  GROUP BY im.id ORDER BY im.id DESC ";

		return DB::select(DB::raw($query));
	}*/

	function other_imprests_line_hr($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status = 2 AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE im.id>0 AND  (im.empID IN(SELECT emp_id FROM employee WHERE line_manager = '".$empID."' ) OR NOT im.status = 0) GROUP BY im.id ORDER BY im.id DESC ";

		return DB::select(DB::raw($query));
	}

	function other_imprests_line_fin($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status= 2 AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE im.id>0 AND  (im.empID IN(SELECT emp_id FROM employee WHERE line_manager = '".$empID."' ) OR im.status NOT IN(0,1,6)) GROUP BY im.id ORDER BY im.id DESC ";

		return DB::select(DB::raw($query));
	}

	function other_imprests_line($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status =2  AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE im.empID IN(SELECT emp_id FROM employee WHERE line_manager = '".$empID."' ) GROUP BY im.id ORDER BY im.id DESC ";

		return DB::select(DB::raw($query));
	}

	function other_imprests_hr()
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status =2 AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE im.status IN(1,2,3,4,5,6) GROUP BY im.id ORDER BY im.id DESC ";

		return DB::select(DB::raw($query));
	}

	function other_imprests_fin()
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF((SELECT COUNT(id) FROM imprest_requirement WHERE  imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE imprestID = im.id ), 0)  as requested_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id )>0, (SELECT SUM(final_amount) FROM imprest_requirement WHERE status = 1 AND imprestID = im.id ), 0)  as approved_amount, IF((SELECT COUNT(id) FROM imprest_requirement WHERE imprestID = im.id )>0, (SELECT SUM(initial_amount) FROM imprest_requirement WHERE status = 2 AND imprestID = im.id ), 0)  as confirmed_amount, (SELECT COUNT(id) FROM imprest_requirement WHERE NOT status = 4 AND imprestID = im.id ) AS pending_requirements FROM imprest im, (SELECT @s:=0) as s WHERE im.status IN(2,5,6) GROUP BY im.id ORDER BY im.id DESC ";
		return DB::select(DB::raw($query));
	}


	function notApprovedRequirement($impID)
	{
		$query = "SELECT COUNT(id) as counts FROM  imprest_requirement  WHERE status NOT IN(1,2,4,5) and imprestID = '".$impID."'";

        return DB::select(DB::raw($query));

	}

	function unretiredRequirement($impID)
	{
		$query = "SELECT COUNT(id) as counts FROM  imprest_requirement  WHERE status !=5 and imprestID = '".$impID."'";

        return DB::select(DB::raw($query));
	}

	function notConfirmedRequirement($impID)
	{
		$query = "SELECT COUNT(id) as counts FROM  imprest_requirement  WHERE status NOT IN(2,4,6,5) and imprestID = '".$impID."'";

		DB::select(DB::raw($query));
	}

	function notRetiredRequirement($impID)
	{
		$query = "SELECT COUNT(id) as counts FROM  imprest_requirement  WHERE status NOT IN(4,8) and imprestID = '".$impID."'";

		DB::select(DB::raw($query));
	}

	function empRetiredRequirement($impID)
	{
		$query = "SELECT COUNT(id) as counts FROM  imprest_requirement  WHERE status NOT IN(3,7) AND imprestID = '".$impID."'";

		DB::select(DB::raw($query));
	}

	function confirmedImprests()
	{
		$query1 = "SELECT @s:=@s+1 as SNo, im.id as \"imprestID\", im.title, im.description, im.application_date, cim.*,initial  as initial_cost,  final  as final_cost FROM imprest im, confirmed_imprest cim,  (SELECT @s:=0) as s WHERE cim.\"imprestID\" = im.id ORDER BY cim.id DESC";
		$query = "SELECT ROW_NUMBER() OVER (ORDER BY im.id) as SNo,
        im.id as \"imprestID\", im.title, im.description, im.application_date, cim.*,
        initial as initial_cost, final as final_cost
    FROM imprest im
    JOIN confirmed_imprest cim ON cim.\"imprestID\" = im.id
    ORDER BY im.id
    ";

		return DB::select(DB::raw($query));
	}

	function waitingImprests_hr($empID)
	{
		$query = "SELECT * FROM imprest WHERE empID !='".$empID."' AND  imprest.status =0 ";
		return DB::select(DB::raw($query));
	}
	function waitingImprests_fin($empID)
	{
		$query = "SELECT * FROM imprest WHERE empID !='".$empID."' AND  imprest.status =9 ";
		return DB::select(DB::raw($query));
	}
	function waitingImprests_appr($empID)
	{
		$query = "SELECT * FROM imprest WHERE empID !='".$empID."' AND  imprest.status =1 ";
		return DB::select(DB::raw($query));
	}




	function getImprest($impID)
	{
		$query = "SELECT @s:=@s+1 as SNo, im.* , IF(SUM(ir.initial_amount)>0,SUM(ir.initial_amount), 0)  as initial_cost, IF(SUM(ir.final_amount)>0, SUM(ir.final_amount), 0) as final_cost FROM imprest im, imprest_requirement ir, (SELECT @s:=0) as s WHERE ir.imprestID = im.id AND im.id = '".$impID."'";

		return DB::select(DB::raw($query));
	}

	function getImprestRequirements($impID)
	{
		$query = "SELECT @s:=@s+1 as SNo, ir.* FROM  imprest_requirement ir, (SELECT @s:=0) as s WHERE ir.imprestID = '".$impID."'";

		return DB::select(DB::raw($query));
	}

	function getInitialRequirementCost($impID)
	{
		$query = "SUM(ir.initial_amount) as initial_cost WHERE ir.status = 2 AND ir.imprestID = '".$impID."'";

        $row =  DB::table('imprest_requirement  as ir')
            ->select(DB::raw($query))
            ->first();

		return $row->initial_cost;
	}

	function getFinalConfirmedCost($impID)
	{
		$query = "final WHERE id = '".$impID."'";

        $row =  DB::table('confirmed_imprest')
        ->select(DB::raw($query))
        ->first();
		return $row->final;
	}

	function getInitialConfirmedCost($impID)
	{
		$query = "initial WHERE id = '".$impID."'";

        $row =  DB::table('confirmed_imprest')
                    ->select(DB::raw($query))
                    ->first();

		return $row->initial;
	}


	function getEmployee($impID)
	{
		$query = "empID as employee WHERE id = '".$impID."'";

        $row =  DB::table('imprest')
                    ->select(DB::raw($query))
                    ->first();

		return $row->employee;
	}

	function getConfirmedEmployee($impID)
	{
		$query = "empID as employee WHERE id = '".$impID."'";

        $row =  DB::table('confirmed_imprest')
                    ->select(DB::raw($query))
                    ->first();

		return $row->employee;
	}

    function addImprestDeduction($data)
	{
		DB::table('once_off_deduction')->insert($data);
		return true;
	}

	function updateConfirmedImprest($updates, $impID)
	{
		DB::table('confirmed_imprest')->where('id', $impID)
		    ->update($updates);
	}

	function updateConfirmedImprest2($final, $dateConfirmed, $impID)
	{
		DB::transaction(function($final, $dateConfirmed, $impID)
        {
		    $query = "UPDATE imprest SET status = 5 WHERE id = ".$impID." ";
            DB::insert(DB::raw($query));
		    $query = "UPDATE confirmed_imprest SET final =  '".$final."' , date_confirmed = '".$dateConfirmed."' WHERE  imprestID =".$impID." ";
            DB::insert(DB::raw($query));
		});

		return true;
	}

	function getFinalRequirementCost($impID)
	{
		$query = "SUM(ir.final_amount) as final_cost  WHERE ir.status = 4 AND ir.imprestID = '".$impID."'";

        $row =  DB::table('imprest_requirement  as ir')
            ->select(DB::raw($query))
            ->first();

		return $row->final_cost;
	}


	function add_imprest_requirement($data)
	{
		DB::table('imprest_requirement')->insert($data);
		return true;
	}


	function requestImprest($data)
	{
        DB::table('imprest')->insert($data);
		return true;
	}

    function getRecentImprest($empID)
	{
		$query ="SELECT id FROM imprest WHERE empID ='".$empID."' ORDER BY id DESC LIMIT 1 ";
		$row = DB::select(DB::raw($query));
		return $row[0]->id;
	}


	function deleteImprest($imprestID)
	{
		DB::transaction(function() use($imprestID)
        {

            DB::table('imprest_requirement')
			->where('imprestID',$imprestID)
			->delete();

			DB::table('imprest')
			->where('id',$imprestID)
			->delete();


		});
		return true;

	}

	function confirmImprest($updates, $data, $impID)
	{
		DB::transaction(function($updates, $data, $impID)
        {
		    DB::table('confirmed_imprest')->insert($data);
            DB::table('imprest')->where('id', $impID)->update( $updates);
		});
		return true;

	}

	function unconfirmImprest($imprestID)
	{
		DB::transaction(function($imprestID)
        {
		    $query = "DELETE FROM confirmed_imprest WHERE imprestID ='".$imprestID."'";
            DB::insert(DB::raw($query));
		    $query = "UPDATE imprest set status = 7 WHERE imprestID ='".$imprestID."'";
            DB::insert(DB::raw($query));

		    /*
                $this->db->where('id', $impID);
		        $this->db->update('imprest', $updates);
            */

		 });

		return true;

	}

	public function removeRequirement($requirementID) {

        DB::table('imprest_requirement')
            ->where('id',$requirementID)
            ->delete();

        return true;

    }

    function update_imprest_requirement($data, $id)
	{
		DB::table('imprest_requirement')
            ->where('id', $id)
            ->update($data);

		return true;
	}


    function getRequirementFile($requirementID)
	{
	    $query = "evidence WHERE id =".$requirementID." ";

        $row =  DB::table('imprest_requirement')
                    ->select(DB::raw($query))
                    ->first();

		return $row->evidence;
	}

    function update_imprest($data, $id)
	{
		DB::table('imprest')
            ->where('id', $id)
		    ->update($data);

		return true;
	}
}
?>
