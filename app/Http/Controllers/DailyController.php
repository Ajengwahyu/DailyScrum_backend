<?php

namespace App\Http\Controllers;
use App\Daily;
use Auth;
use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Support\Facades\Validator;

class DailyController extends Controller
{
    public function index(){
        // $data = Daily::all();
        // return response ($data);
        try{
	        $data["count"] = Daily::count();
	        $Daily = array();
	        $dataDaily = DB::table('daily_scrum')->join('users','users.id','=','daily_scrum.id_users')
                                               ->select('daily_scrum.id', 'daily_scrum.id_users','daily_scrum.team', 'daily_scrum.activity_yesterday', 
                                                        'daily_scrum.activity_today', 'daily_scrum.problem_yesterday', 'solution')
	                                           ->get();

	        foreach ($dataDaily as $p) {
	            $item = [
	                "id"          	    	=> $p->id,
                    "id_users"               => $p->id_users,
	                "team"  		        => $p->team,
	                "activity_yesterday"    => $p->activity_yesterday,
	                "activity_today"    	=> $p->activity_today,
                    "problem_yesterday"     => $p->problem_yesterday,
	                "solution"              => $p->solution,
	            ];

	            array_push($Daily, $item);
	        }
            $data["Daily"] = $Daily;
	        $data["status"] = 1;
	        return response($data);
            
	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function getAll($limit = 10, $offset = 0){
        $data["count"] = Daily::count();
	        $Daily = array();
	        $dataDaily = DB::table('daily_scrum')->join('users','users.id','=','daily_scrum.id_users')
                                               ->select('daily_scrum.id', 'daily_scrum.id_users','daily_scrum.team', 'daily_scrum.activity_yesterday', 'daily_scrum.activity_today', 'daily_scrum.problem_yesterday', 'solution')
	                                           ->skip($offset)
                                               ->take($limit)
	                                           ->get();

	        foreach ($dataDaily as $p) {
	            $item = [
	                "id"          	    	=> $p->id,
                    "id_users"               => $p->id_users,
	                "team"  		        => $p->team,
	                "activity_yesterday"    => $p->activity_yesterday,
	                "activity_today"    	=> $p->activity_today,
                    "problem_yesterday"     => $p->problem_yesterday,
	                "solution"              => $p->solution,
	            ];
            array_push($user, $item);
        }
        return response($data);
    }

    public function store (Request $request) {
        try{
    		$validator = Validator::make($request->all(), [
                'id_users'               => 'required',
    			'team'                  => 'required',
				'activity_yesterday'    => 'required|max:255',
                'activity_today'		=> 'required|max:255',
                'problem_yesterday'     => 'required|max:255',
                'solution'              => 'required|max:255',
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
            }

            if(User::where('id', $request->input('id_users'))->count() > 0){
    				$data = new Daily();
              		$data->id_users = $request->input('id_users');
			        $data->team = $request->input('team');
			        $data->activity_yesterday = $request->input('activity_yesterday');
			        $data->activity_today = $request->input('activity_today');
                    $data->problem_yesterday= $request->input('problem_yesterday');
                    $data->solution= $request->input('solution');
			        $data->save();

		    		return response()->json([
		    			'status'	=> '1',
		    			'message'	=> 'Data berhasil ditambahkan!'
		    		], 201);
    			} else {
    				return response()->json([
		                'status' => '0',
		                'message' => 'Data tidak ditemukan.'
		            ]);
                }
           
      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete ($id){
        try{

            $delete = Daily::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data gagal dihapus."
              ]);
            }
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
