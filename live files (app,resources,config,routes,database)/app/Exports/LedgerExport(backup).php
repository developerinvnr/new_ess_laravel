<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LedgerExport implements FromView
{
    protected $type;
    protected $department;

    public function __construct($type, $department = null)
    {
        $this->type = $type;
        $this->department = $department;
    }

    public function view(): View
    {
        // === Copy your code logic from expensesLedger() ===

        $path = base_path('/Employee/Emp1Lgr/2024-25');
        $employeescode = [];

        if (File::exists($path)) {
            foreach (File::files($path) as $file) {
                $filename = $file->getFilename();
                if (preg_match('/^([EV])(\d+)\.pdf$/i', $filename, $matches)) {
                    $employeescode[] = [
                        'vcode' => strtoupper($matches[1]),
                        'empCode' => $matches[2],
                    ];
                }
            }
        }

        $uniqueEmployeesCode = collect($employeescode)->unique(fn($e) => $e['vcode'] . '-' . $e['empCode'])->values();

        $activeEmployeeIds = DB::table('hrm_employee')
            ->where('CompanyId', 1)
            ->where('EmpStatus', 'A')
            ->where(function ($query) use ($uniqueEmployeesCode) {
                foreach ($uniqueEmployeesCode as $emp) {
                    $code = $emp['vcode'] === 'V' ? 'V' . ltrim($emp['empCode'], '0') : ltrim($emp['empCode'], '0');
                    $query->orWhere('EmpCode', $code);
                }
            })
            ->pluck('EmployeeID')
            ->toArray();

        $confirmedEmployeeIds = DB::table('hrm_employee_ledger_confirmation')
            ->whereIn('EmployeeId', $activeEmployeeIds)
            ->pluck('EmployeeId')
            ->toArray();

        $ledgerQueryEmployeeIds = DB::table('hrm_employee_queryemp')
            ->whereIn('EmployeeID', $activeEmployeeIds)
            ->where('QuerySubject', 'like', '%Ledger Confirmation%')
            ->distinct()
            ->pluck('EmployeeID')
            ->toArray();

        $notConfirmedEmployeeIds = array_diff($activeEmployeeIds, $confirmedEmployeeIds);

        // === Get employee data based on type ===
        $data = collect();

        if ($this->type === 'pending' && !empty($notConfirmedEmployeeIds)) {
            $data = DB::table('hrm_employee as e')
                ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                ->select('e.EmployeeID', 'e.EmpCode', DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"), 'd.department_name', 'g.EmailId_Vnr')
                ->whereIn('e.EmployeeID', $notConfirmedEmployeeIds)
                ->when($this->department, fn($q) => $q->where('d.department_name', $this->department))
                ->where('e.CompanyId', 1)
                ->orderByRaw('CAST(e.EmpCode AS UNSIGNED) ASC')
                ->get();

        }

        if ($this->type === 'confirmed' && !empty($confirmedEmployeeIds)) {
        
                $data = DB::table('hrm_employee as e')
                        ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                        ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                        ->select(
                            'e.EmployeeID',
                            'e.EmpCode',
                            DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
                            'g.DepartmentId',
                            'd.department_name',
                            'g.EmailId_Vnr'
                        )
                        ->whereIn('e.EmployeeID', $confirmedEmployeeIds)
                        ->when($this->department, fn($q) => $q->where('d.department_name', $this->department))
                        ->where('e.CompanyId', 1)
                        ->orderByRaw('CAST(e.EmpCode AS UNSIGNED) ASC')
                        ->get();
        }

        if ($this->type === 'queried' && !empty($ledgerQueryEmployeeIds)) {
            $data = DB::table('hrm_employee as e')
                ->join('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                ->join('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                ->join('hrm_employee_queryemp as q', 'e.EmployeeID', '=', 'q.EmployeeID')
                ->select(
                    'e.EmployeeID',
                    'e.EmpCode',
                    DB::raw("CONCAT_WS(' ', e.Fname, e.Sname, e.Lname) as full_name"),
                    'd.department_name',
                    'g.EmailId_Vnr',
                    'q.QueryDT as QueryRaisedAt',
                    'q.Level_1QStatus as status'
                )
                ->whereIn('e.EmployeeID', $ledgerQueryEmployeeIds)
                ->where('q.QuerySubject', 'like', '%Ledger Confirmation%')
                ->when($this->department, fn($q) => $q->where('d.department_name', $this->department))
                ->where('e.CompanyId', 1)
                ->orderByRaw('CAST(e.EmpCode AS UNSIGNED) ASC')
                ->get();

        }

        return view('exports.ledger_excel', [
            'data' => $data,
            'type' => $this->type,
        ]);
        
    }
}