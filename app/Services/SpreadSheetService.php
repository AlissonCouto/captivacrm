<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SpreadSheetService
{

    public function store(Request $data)
    {

        try {

            $user = Auth::user();
            $company = $user->company()->first();

            // Verificando se o arquivo está presente
            if ($data->hasFile('spreadsheet')) {

                $file = $data->file('spreadsheet');
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

                            //if (!is_null($value)) {
                            // Slug do nome
                            if ($headersFile[$c] == 'name') {
                                $slug = Str::slug((string) $value);
                                $valuesFile[$r]['slug'] = $slug;
                            }

                            $valuesFile[$r][$headersFile[$c]] = (string) $value;
                            $valuesFile[$r]['companyId'] = $company->id;
                            $valuesFile[$r]['nicheId'] = $data->nicheId;
                            $valuesFile[$r]['cityId'] = $data->cityId;
                            $valuesFile[$r]['statusId'] = 1;
                            //}
                        }
                    } // Percorre colunas
                } // Percorre linhas

                $leads = DB::table('leads')->insert($valuesFile);

                if ($leads) {
                    $return = [
                        'success' => true,
                        'message' => 'Leads cadastrados com sucesso.',
                        'data' => []
                    ];
                } else {
                    $return = [
                        'success' => false,
                        'message' => 'Erro ao cadastrar leads.',
                        'data' => []
                    ];
                }

                return $return;
            } // Se arquivo presente

        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => 'Erro ao cadastrar leads.',
                'data' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage()
                ]
            ];
        }
    }
}
