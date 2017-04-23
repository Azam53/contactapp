<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use App\Contact;

class DashboardController extends Controller
{
       /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
public function index(){
               // Checking whether user logged or not  
                 if(Auth::check()) {
                    $id =  Auth::user()->id;
                    $name = Auth::user()->name;
                    $contact = DB::table('contact_data')
				    ->where('user_id',$id)
                                    ->where('status',1)
				    ->get();
              // Age calculation from birthday date
                    foreach($contact as $value){
                          $date = $value->birthday;
                          $birthDate = $date;
			  //explode the date to get month, day and year
			  $birthDate = explode("/", $birthDate);
			  //get age from date or birthdate
			  $tmpage = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			    ? ((date("Y") - $birthDate[2]) - 1)
			    : (date("Y") - $birthDate[2]));
                          $age[] = $tmpage; 
                    }
                      
		   
                    return view('dashboard.index' , compact('contact','name','age'));
                 } 
                 else{
                    
                    return Redirect::to('login');
                 }
               
		
	}
 
 
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
                 $name = Auth::user()->name;
		return view('dashboard.create',compact('name'));
	}
 
 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		
                $contact = new Contact;
                $contact->user_id = Auth::user()->id;
                $contact->status = 1;
                $contact->name = Input::get('name');
                $contact->email = Input::get('email');
                $contact->phone = Input::get('phone');
                $contact->company = Input::get('company');
                $contact->birthday = Input::get('birthday');
                $contact->address = Input::get('address');
                
                $contact->save();
		
			return Redirect::route('dashboard.index');
		
	}
 
 
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function archived(){
		
                 if(Auth::check()) {
                    $id =  Auth::user()->id;
                    $name = Auth::user()->name;
                    $contact = DB::table('contact_data')
				    ->where('user_id',$id)
                                    ->where('status',0)
				    ->get();
		   
                    return view('dashboard.archived' , compact('contact','name'));
                 } 
                 else{
                    
                    return Redirect::to('login');
                 }
               
	}
 
 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
		$name = Auth::user()->name;
		$contact = Contact::find($id);
 
		return view('dashboard.edit',compact('contact','name'));
	}
 
 
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
                
                $contact = Contact::find($id);
                
                $contact->name = Input::get('name');
                $contact->email = Input::get('email');
                $contact->phone = Input::get('phone');
                $contact->company = Input::get('company');
                $contact->birthday = Input::get('birthday');
                $contact->address = Input::get('address');
                
                $contact->save();
		
			return Redirect::route('dashboard.index');
	}
 
 
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
		 
                   DB::table('contact_data')
                            ->where('id', $id)
                            ->update(['status' => 0]);
                   
		return Redirect::route('dashboard.index');
	}
}
