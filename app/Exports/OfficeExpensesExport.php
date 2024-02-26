<?php

namespace App\Exports;

use Modules\Admin\app\Models\Trip;
use Modules\Admin\app\Models\TruckDriver;
use Modules\Admin\app\Models\{Truck, OfficeExpense, Category};
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
                                         
class OfficeExpensesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    
    public function collection(){
       
       
       
        $getexpense = OfficeExpense::latest()->get();
        
        $exist_category  = OfficeExpense::pluck('expense_type')->unique()->toArray();
        $getcategory     = Category::whereIn('id',$exist_category)->get();
        $arraydata         = [];
        foreach($getcategory as $row){
            
                $January     = OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['January']);
                if($this->fromDate && $this->toDate){
                $January     = $January->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $January     = $January->sum('expense_amount');
                
                $February    = OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['February']);
                if($this->fromDate && $this->toDate){
                $February    = $February->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $February    = $February->sum('expense_amount');
                
                
                $March       = OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['March']);
                if($this->fromDate && $this->toDate){
                $March       = $March->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $March       = $March->sum('expense_amount');
                
                
                $April       =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['April']);
                if($this->fromDate && $this->toDate){
                $April = $April->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $April = $April->sum('expense_amount');
                
                
                $May         = OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['May']);
                if($this->fromDate && $this->toDate){
                $May         = $May->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $May         = $May->sum('expense_amount');
                
                
                $June        =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['June']);
                if($this->fromDate && $this->toDate){
                $June   = $June->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $June = $June->sum('expense_amount');
                
                
                $July        =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['July']);
                if($this->fromDate && $this->toDate){
                $July = $July->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $July = $July->sum('expense_amount');
                
                
                $August      =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['August']);
                if($this->fromDate && $this->toDate){
                $August = $August->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $August = $August->sum('expense_amount');
                
                
                $September   =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['September']);
                if($this->fromDate && $this->toDate){
                $September = $September->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $September = $September->sum('expense_amount');
                
                
                $October     =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['October']);
                if($this->fromDate && $this->toDate){
                $October = $October->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $October = $October->sum('expense_amount');
                
                
                $November    =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['November']);
                if($this->fromDate && $this->toDate){
                $November = $November->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $November = $November->sum('expense_amount');
                
                
                $December    =OfficeExpense::where('expense_type',$row->id)->whereRaw("MONTHNAME(created_at) = ?", ['December']);
                if($this->fromDate && $this->toDate){
                $December = $December->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
                }
                $December = $December->sum('expense_amount');
        
        
                  
             $arraydata[] = [
                  'Expense Type'=>$row->name,
                  'January'     =>$January?:'0',
                  'February'    =>$February?:'0', 
                  'March'       =>$March?:'0',
                  'April'       =>$April?:'0',
                  'May'         =>$May?:'0',
                  'June'        =>$June?:'0',
                  'July'        =>$July?:'0',
                  'August'      =>$August?:'0',
                  'September'   =>$September?:'0',
                  'October'     =>$October?:'0',
                  'November'    =>$November?:'0',
                  'December'    =>$December?:'0',
                  'Total'       =>array_sum([$January,$February,$March,$April,$May,$June,$July,$August,$September,$October,$November,$December]),
                 ];
        }
        
        
        
        $January     =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['January']);
        if($this->fromDate && $this->toDate){
        $January = $January->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $January = $January->sum('expense_amount');
        
        $February    =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['February']);
        if($this->fromDate && $this->toDate){
        $February = $February->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $February    = $February->sum('expense_amount'); 
        
        $March       =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['March']);
        if($this->fromDate && $this->toDate){
        $March = $March->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $March       = $March->sum('expense_amount'); 
        
        $April       =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['April']);
        if($this->fromDate && $this->toDate){
        $April = $April->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $April       =$April->sum('expense_amount'); 
        
        $May         =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['May']);
        if($this->fromDate && $this->toDate){
        $May = $May->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $May         = $May->sum('expense_amount'); 
        
        $June        =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['June']);
        if($this->fromDate && $this->toDate){
        $June  = $June->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $June        = $June->sum('expense_amount');
        
        $July        =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['July']);
        if($this->fromDate && $this->toDate){
        $July = $July->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $July        =$July->sum('expense_amount');
        
        $August      =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['August']);
        if($this->fromDate && $this->toDate){
        $August = $August->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $August      =$August->sum('expense_amount'); 
        
        $September   =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['September']);
        if($this->fromDate && $this->toDate){
        $September = $September->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $September   = $September->sum('expense_amount');
        
        $October     =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['October']);
        if($this->fromDate && $this->toDate){
        $October = $October->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $October     = $October->sum('expense_amount'); 
        
        $November    =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['November']);
        if($this->fromDate && $this->toDate){
        $November = $November->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $November    = $November->sum('expense_amount');
        
        $December    =OfficeExpense::whereRaw("MONTHNAME(created_at) = ?", ['December']);
        if($this->fromDate && $this->toDate){
        $December = $December->whereDate('created_at','>=',$this->fromDate)->whereDate('created_at','<=',$this->toDate);
        }
        $December    = $December->sum('expense_amount');
             
             
         $arraydata[] = [
                  'Expense Type'=>'Total',
                  'January'     =>$January?:'0',
                  'February'    =>$February?:'0', 
                  'March'       =>$March?:'0',
                  'April'       =>$April?:'0',
                  'May'         =>$May?:'0',
                  'June'        =>$June?:'0',
                  'July'        =>$July?:'0',
                  'August'      =>$August?:'0',
                  'September'   =>$September?:'0',
                  'October'     =>$October?:'0',
                  'November'    =>$November?:'0',
                  'December'    =>$December?:'0',
                  'Total'       =>array_sum([$January,$February,$March,$April,$May,$June,$July,$August,$September,$October,$November,$December]),
                 ];
        
        
        return collect($arraydata);
        
    }

    public function headings(): array
    {
        return [
            'Expense Name',
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'Sepetmber',
            'October',
            'November',
            'December',
            'Total'
        ];
    }
}
