<?php

namespace App\Http\Controllers;
use App\Models\Budget;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class BudgetCalculatorController extends Controller
{
    public function index()
    {
        return view('budget_calculator.index');
    }

    // public function calculate(Request $request)
    // {
       
    //     $incomes = collect($request->incomes);
    //     $incomeplanned=$incomes->sum(function ($item) {
    //         return (float)$item['planned']; // Convert to float
    //     });

    //    $givingslist=collect($request->givings);
    //     $givingsplanned =$givingslist->sum(function ($item) {
    //         return (float)$item['planned']; // Convert to float
    //     });
    //     $givingsrecieved = $givingslist->sum(function ($item) {
    //         return (float)$item['recieved']; // Convert to float
    //     });


    //    $savingslist=collect($request->savings);
    //     $savingsplanned =$savingslist->sum(function ($item) {
    //         return (float)$item['planned']; // Convert to float
    //     });
    //     $savingsrecieved = $savingslist->sum(function ($item) {
    //         return (float)$item['recieved']; // Convert to float
    //     });


    //    $housinglist=collect($request->housings);
    //     $housingsplanned =$housinglist->sum(function ($item) {
    //         return (float)$item['planned']; // Convert to float
    //     });
    //     $housingsrecieved = $housinglist->sum(function ($item) {
    //         return (float)$item['recieved']; // Convert to float
    //     });
      
        // $sum = 0.0;
        // foreach($request->givings as $new){
        //     $sum +=$new['planned'];
        // };
        // dd($sum );
       
    //     $data= [ $givingsplanned, $givingsrecieved];
    //     // return response()->json(['data' => $data]);
    //     return view('budget_calculator.create')->with(['givingsrecieved' => $givingsrecieved,'givingsplanned'=>$givingsplanned,'incomeplanned' =>$incomeplanned, 'incomerecieved'=>$incomerecieved,'housingsrecieved'=>$housingsrecieved, 'housingsplanned' => $housingsplanned, 'savingsplanned'=> $savingsplanned, 'savingsrecieved'=> $savingsrecieved]);
    // }

    public function store(Request $request)
    {
       
        $request->validate([
            'incomes' => 'required|array',
            'expenses' => 'required|array',
            'personal' => 'required|array',
            'food' => 'required|array',
            'lifestyle' => 'required|array',
            'month' => 'required|string',
            'year' => 'required',
            // Other validations as needed
        ]);
        // dd('reached here');
        $budget = Budget::create([
            'user_id' => auth()->id(),
            'month' => $request->month,
            'year' => $request->year,
            'incomes' => json_encode($request->incomes),
            'expenses' => json_encode($request->expenses),
            'personal' => json_encode($request->personal),
            'food' => json_encode($request->food),
            'lifestyle' => json_encode($request->lifestyle),
        ]);
    
        if($budget){
            return response()->json(['success' => true, 'budget' => $budget]);

        }
        else{
            return response()->json(['success' => false, 'budget' => $budget]);

        }
    }

    public function showMonthlyBudget($month, $year)
{
    $budget = Budget::where('user_id', auth()->id())
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

    if ($budget) {
        return response()->json($budget);
    } else {
        return response()->json(['error' => 'No budget found for this month.'], 404);
    }

  }  

  public function deleteBudget($id)
  {
      // Find the record by ID
      $budget = Budget::findOrFail($id);
  
      // Delete the record
      $budget->delete();
    return redirect(route('budget_calculator.list'));
  }

  public function myBudgets(){
        $budgets = Budget::where('user_id', auth()->id())->get();
        return view('budget_calculator.list',compact('budgets'));
    }

}
