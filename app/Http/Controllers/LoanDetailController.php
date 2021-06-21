<?php

namespace App\Http\Controllers;

use App\Models\LoanDetail;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!Auth::check()){
            return view('auth.login');
        }

        $loanDetails = LoanDetail::all();
        return view('loandetails', ['loanDetails' => $loanDetails]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanDetail  $loanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(LoanDetail $loanDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanDetail  $loanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanDetail $loanDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanDetail  $loanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanDetail $loanDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanDetail  $loanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanDetail $loanDetail)
    {
        //
    }
}
