<?php

namespace Database\Seeders;

use App\Models\Status;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $status_leads = [
            [
                'name' => 'Novo',
                'color' => '#3498DB',
                'description' => 'Lead recém-capturado, ainda não houve nenhuma interação.',
            ],
            [
                'name' => 'Qualificado',
                'color' => '#1ABC9C',
                'description' => 'Lead qualificado com base nos critérios definidos, pronto para contato inicial.',
            ],
            [
                'name' => 'Primeiro Contato',
                'color' => '#F39C12',
                'description' => 'Primeira interação realizada, aguardando resposta ou próxima ação.',
            ],
            [
                'name' => 'Aguardando Resposta',
                'color' => '#FFC107',
                'description' => 'Lead foi contatado, aguardando retorno ou feedback para prosseguir.',
            ],
            [
                'name' => 'Proposta Enviada',
                'color' => '#8E44AD',
                'description' => 'Proposta ou orçamento enviado ao lead, aguardando aprovação ou negociação.',
            ],
            [
                'name' => 'Negociação',
                'color' => '#E67E22',
                'description' => 'Em fase de negociação de termos ou condições da proposta enviada.',
            ],
            [
                'name' => 'Segunda Tentativa',
                'color' => '#E74C3C',
                'description' => 'Tentativa de contato adicional após a falta de resposta ou interesse inicial.',
            ],
            [
                'name' => 'Fechamento Pendente',
                'color' => '#2ECC71',
                'description' => 'Lead demonstrou interesse e está perto de fechar, aguardando assinatura ou pagamento.',
            ],
            [
                'name' => 'Concluído',
                'color' => '#27AE60',
                'description' => 'Lead convertido em cliente, contrato fechado ou venda concluída.',
            ],
            [
                'name' => 'Perdido',
                'color' => '#95A5A6',
                'description' => 'Lead não demonstrou interesse ou decidiu não prosseguir; contato encerrado.',
            ],
            [
                'name' => 'Inativo',
                'color' => '#BDC3C7',
                'description' => 'Lead inativo ou sem resposta após múltiplas tentativas; pode ser reativado no futuro.',
            ],
        ];

        foreach ($status_leads as $row) {

            $status = new Status();
            $status->name = $row['name'];
            $status->slug = Str::slug($row['name']);
            $status->color = $row['color'];
            $status->description = $row['description'];
            $status->companyId = 1;
            $status->save();
        }
    }
}
