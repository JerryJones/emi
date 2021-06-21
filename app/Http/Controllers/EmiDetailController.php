<?php

namespace App\Http\Controllers;

use App\Models\EmiDetail;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EmiDetailController extends Controller
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
        return view('emidetails');
    }

    public function processData(Request $request)
    {
        $min_data = LoanDetail::min('first_payment_date');
        $max_date = LoanDetail::max('last_payment_date');

        $month = strtotime($min_data);
        $end = strtotime($max_date);
        $duration = '';

        while($month < $end)
        {
            $duration .= '`'.date('Y_M', $month).'` VARCHAR( 100 ), ';
            $month = strtotime("+1 month", $month);
        }

        $create_table_query = "CREATE TABLE `emi_details` (
            `id` TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            {$duration}
            PRIMARY KEY (`id`)
        )";

        try {
            $success = true;

            DB::beginTransaction();
            DB::statement('DROP TABLE IF EXISTS `emi_details`');
            DB::statement($create_table_query);
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollback();
            $success = false;
        }

        if ($success == true) {
            //TODO: insert data into database
            
            //TODO fetch and return data from the table
            return response()->json($create_table_query); // This out put just to verify the generated query
        } else {
            //error, return failure message
            return response()->json(["message" => $e->getMessage()]);
        }
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
     * @param  \App\Models\EmiDetail  $emiDetail
     * @return \Illuminate\Http\Response
     */
    public function show(EmiDetail $emiDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmiDetail  $emiDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(EmiDetail $emiDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmiDetail  $emiDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmiDetail $emiDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmiDetail  $emiDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmiDetail $emiDetail)
    {
        //
    }
}
