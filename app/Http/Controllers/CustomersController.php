<?php

namespace App\Http\Controllers;

use App\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers=Customers::all();
return view('layout.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $customers= $this->validate(request(),[
            'name' => 'required',
            'email'=>'required',
            'gender' => 'required'
          ]);
          $customer= Customers::create($customers);
          return response()->json($customer);//returnform  inserted data
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customers  $customer_id
     * @return \Illuminate\Http\Response
     */
    public function show( $customer_id)
    {
           }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customers  $customer_id
     * @return \Illuminate\Http\Response
     */
    public function edit( $customer_id)
    {

    $customers = Customers::find($customer_id);
        return response()->json($customers); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customers  $customer_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $customer_id)
    {
    $customers = Share::find($id);
      $customers->name = $request->get('name');
      $customers->email = $request->get('email');
      $customers->gender = $request->get('gender');
      $customers->save();
       
        return response()->json($customers);    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customers  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)  
    {
        $customers = Customers::find($id)->delete($id);
        // return response()->json(['sucess'=>'data saved'], 200);
      

        return response()->json($customers);
        // return response()->json(['sucess'=>'data saved']);

    
    }
}
