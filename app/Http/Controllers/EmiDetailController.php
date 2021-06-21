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
            $duration .= '`'.date('Y_M', $month).'` DOUBLE(16,2) DEFAULT 0.00, ';
            $month = strtotime("first day of next month", $month);
        }

        $create_table_query = "CREATE TABLE `emi_details` (
            `id` TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT,
            `clientid` INT,
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
            $loanDetails = LoanDetail::all();

            // foreach ($loanDetails as $key => $value) {
            foreach ($loanDetails as $loanDetail) {

                $column_name = '';
                $emi_value = '';
                $monthly_emi = 0;
                $remainder = 0;
                $clientid = $loanDetail->clientid;
                $start = strtotime( $loanDetail->first_payment_date);
                $end = strtotime( $loanDetail->last_payment_date);
                
                $amount = $loanDetail->loan_amount; //get total amouunt
                $total_emi = $loanDetail->num_of_payment; //get total emi

                $monthly_emi = round($amount / $total_emi, 2); // calculate monthly emi
                $last_emi = ( $amount - ($monthly_emi * ($total_emi - 1) ) ); // calculate last emi

                $remainder = $amount / $monthly_emi; // get reminder to adjust in total

                while($start < $end)
                {
                    $column_name .= '`'.date('Y_M', $start).'`,';
                    $start = strtotime("first day of next month", $start);
                }

                for ($i=0; $i < ($total_emi -1 ); $i++) { 
                    $emi_value .= ', '. $monthly_emi;
                }
                // prepare insert query
                $column_name = rtrim($column_name,','); //remove unwanted string
                $insert_query = "INSERT INTO `emi_details`(`clientid`, $column_name) VALUES ($clientid $emi_value, $last_emi)";

                DB::statement($insert_query);
            }

            // get all data from emi_details and sent it to view
            $emiDetails = EmiDetail::all();
            //TODO fetch and return data from the table
            return response()->json($emiDetails); // This out put just to verify the generated query
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
