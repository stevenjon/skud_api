<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OtchotController extends Controller {

	public function getlogs() {
	
		$users = DB::select("select employeeID, authDateTime, deviceSN from attlog where (employeeID, authDateTime) in ( select employeeID, max(authDateTime) as date from attlog group by employeeID ORDER BY authDateTime DESC )");

		return $users;
	}

	public function getLogsbydate(Request $request) {
		$curdate = $request->input("date");
		switch ($curdate) {
			case "today":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog WHERE DATE(authDateTime) = CURDATE() AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
			case "thisweek":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog WHERE WEEK(authDateTime) = WEEK(NOW()) AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
		  case "week":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog WHERE WEEK(authDateTime) = WEEK(NOW()) - 1 AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
			case "thismonth":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog where MONTH(authDateTime) = MONTH(NOW()) AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
		  case "month":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog where MONTH(authDateTime) = MONTH(NOW()) - 1 AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
		  case "year":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog where YEAR(authDateTime) = YEAR(NOW()) AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
				case "quarter":
			$sql = "SELECT employeeID, authDateTime, authDate FROM attlog WHERE authDateTime >= DATE_ADD(NOW(), INTERVAL -3 MONTH) AND deviceSN LIKE 'DS-K1T671M20210203V030200ENE19196584' GROUP BY employeeID, authDateTime, authDate ORDER BY authDateTime";
			break;
		  default:
			
		}

		$users = DB::select($sql);

		return $users;

	}




	public function getErtaByDate(Request $request) {

		$curdate = $request->input("date");
		switch ($curdate) {
			case "today":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime, deviceSN FROM attlog WHERE DATE(authDateTime) = CURDATE()";
			break;
			case "thisweek":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime, deviceSN FROM attlog WHERE WEEK(authDateTime) = WEEK(NOW())";
			break;
		  case "week":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime, deviceSN FROM attlog WHERE WEEK(authDateTime) = WEEK(NOW()) - 1 ";
			break;
			case "thismonth":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime, deviceSN FROM attlog where MONTH(authDateTime) = MONTH(NOW()) ";
			break;
		  case "month":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime, deviceSN FROM attlog where MONTH(authDateTime) = MONTH(NOW()) - 1";
			break;
		  case "year":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime,deviceSN FROM attlog where YEAR(authDateTime) = YEAR(NOW())";
			break;
				case "quarter":
			$sql = "SELECT employeeID, authDateTime, authDate,authTime,deviceSN FROM attlog WHERE authDateTime >= DATE_ADD(NOW(), INTERVAL -3 MONTH)";
			break;
		  default:
			
		}

		$users = DB::select($sql);

		return $users;

	}
	
}


?>