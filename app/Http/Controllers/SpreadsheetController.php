<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Niche;
use App\Models\City;

class SpreadsheetController extends Controller
{
    public function create()
    {

        $niches = Niche::where('status', 1)->orderby('name', 'ASC')->get();
        $cities = City::where('id_estado', 1)->orderby('nome', 'ASC')->get();

        return view('admin.leads.spreadsheet.create')->with(compact('niches', 'cities'));
    } // create()

    public function store(Request $request)
    {

        $user = Auth::user();
        $company = $user->company()->first();

        // Verificando se o arquivo está presente
        if ($request->hasFile('spreadsheet')) {

            $file = $request->file('spreadsheet');
            $path = $file->path();
            $extension = $file->extension();

            $spreadsheet = IOFactory::load($path); // Abrindo a planilha como objeto
            $sheet = $spreadsheet->getActiveSheet(); // Pegando a aba ativa da planilha

            $headersFile = [];
            $valuesFile = [];

            $qtdRows = $sheet->getHighestDataRow();
            $highestColumn = $sheet->getHighestDataColumn();
            $qtdCollumns = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // Percorrendo as linhas
            for ($r = 1; $r <= $qtdRows; $r++) {

                // Percorrendo colunas
                for ($c = 1; $c <= $qtdCollumns; $c++) {

                    if ($r == 1) {
                        // Definindo pelo indice da coluna
                        $headersFile[$c] = strtolower($sheet->getCell([$c, $r])->getValue());
                    } else {
                        // Adicionando valores aos campos
                        $value = $sheet->getCell([$c, $r])->getValue();

                        if (!is_null($value)) {
                            // Slug do nome
                            if ($headersFile[$c] == 'name') {
                                $slug = Str::slug((string) $value);
                                $valuesFile[$r]['slug'] = $slug;
                            }

                            $valuesFile[$r][$headersFile[$c]] = (string) $value;
                            $valuesFile[$r]['companyId'] = $company->id;
                            $valuesFile[$r]['nicheId'] = $request->nicheId;
                            $valuesFile[$r]['cityId'] = $request->cityId;
                            $valuesFile[$r]['statusId'] = 1;
                        }
                    }
                } // Percorre colunas
            } // Percorre linhas

            DB::table('leads')->insert($valuesFile);
        } // Se arquivo presente
    } // store()
}
