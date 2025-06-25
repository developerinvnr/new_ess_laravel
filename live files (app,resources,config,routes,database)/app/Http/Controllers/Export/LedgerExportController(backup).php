<?php

namespace App\Http\Controllers\Export;

use App\Exports\LedgerExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LedgerExportController extends Controller
{
    /**
     * Export ledger data to Excel, CSV, or PDF
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type        'pending', 'confirmed', 'queried'
     * @param  string  $format      'excel', 'csv', 'pdf'
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function export(Request $request, $type, $format)
    {
        $department = $request->input('department');

        if (!in_array($type, ['pending', 'confirmed', 'queried']) || !in_array($format, ['excel', 'csv', 'pdf'])) {
            abort(404, 'Invalid export type or format.');
        }

        $export = new LedgerExport($type, $department);

       if ($format === 'excel') {
                return Excel::download($export, "ledger_{$type}.xlsx", \Maatwebsite\Excel\Excel::XLSX);
            }

            if ($format === 'csv') {
                return Excel::download($export, "ledger_{$type}.csv", \Maatwebsite\Excel\Excel::CSV);
            }

        if ($format === 'pdf') {
            $view = $export->view();
            $pdf = PDF::loadHTML($view->render());
            return $pdf->download("ledger_{$type}.pdf");
        }

        abort(404);
    }
}


