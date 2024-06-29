<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\EnderecoAlunoService;
use App\Models\Aluno;
use App\Models\Endereco;
use App\Models\EnderecoAluno;
use App\Models\Serie;
use App\Models\TipoEndereco;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnderecoAlunoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Serie::factory()->count(12)->create();
        TipoEndereco::factory()->count(3)->create();
    }

    public function testCreateEnderecoAlunoWithExistingEndereco()
    {
        $alunoMock = Aluno::factory()->create();
        $enderecoMock = Endereco::factory()->create(['cep' => '12345678']);
        $tipoEnderecoMock = TipoEndereco::factory()->create();

        $data = [
            'cep' => '12345678',
            'rua' => 'Rua Exemplo',
            'numero' => '100',
            'complemento' => 'Apto 101',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ];

        $service = new EnderecoAlunoService($alunoMock, $data);
        $enderecoAluno = $service->createEnderecoAluno();

        $this->assertInstanceOf(EnderecoAluno::class, $enderecoAluno);
        $this->assertEquals($data['numero'], $enderecoAluno->numero);
        $this->assertEquals($data['complemento'], $enderecoAluno->complemento);
        $this->assertEquals($data['tipo_endereco_id'], $enderecoAluno->tipo_endereco_id);
        $this->assertEquals($alunoMock->id, $enderecoAluno->aluno_id);
        $this->assertEquals($enderecoMock->id, $enderecoAluno->endereco_id);
    }

    public function testCreateEnderecoAlunoWithNewEndereco()
    {
        $alunoMock = Aluno::factory()->create();
        $tipoEnderecoMock = TipoEndereco::factory()->create();

        $data = [
            'cep' => '12345678',
            'rua' => 'Rua Exemplo',
            'numero' => '100',
            'complemento' => 'Apto 101',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ];

        $service = new EnderecoAlunoService($alunoMock, $data);
        $enderecoAluno = $service->createEnderecoAluno();

        $this->assertInstanceOf(EnderecoAluno::class, $enderecoAluno);
        $this->assertEquals($data['numero'], $enderecoAluno->numero);
        $this->assertEquals($data['complemento'], $enderecoAluno->complemento);
        $this->assertEquals($data['tipo_endereco_id'], $enderecoAluno->tipo_endereco_id);
        $this->assertEquals($alunoMock->id, $enderecoAluno->aluno_id);
        $this->assertNotNull($enderecoAluno->endereco_id);
    }

    public function testUpdateEnderecoAlunoWithExistingEndereco()
    {
        $alunoMock = Aluno::factory()->create();
        $enderecoMock = Endereco::factory()->create(['cep' => '12345678']);
        $tipoEnderecoMock = TipoEndereco::factory()->create();

        $data = [
            'cep' => '12345678',
            'rua' => 'Rua Exemplo',
            'numero' => '100',
            'complemento' => 'Apto 101',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ];

        EnderecoAluno::factory()->create([
            'aluno_id' => $alunoMock->id,
            'endereco_id' => $enderecoMock->id,
            'numero' => '99',
            'complemento' => 'Apto 99',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ]);

        $service = new EnderecoAlunoService($alunoMock, $data);
        $enderecoAluno = $service->updateEnderecoAluno();

        $this->assertInstanceOf(EnderecoAluno::class, $enderecoAluno);
        $this->assertEquals($data['numero'], $enderecoAluno->numero);
        $this->assertEquals($data['complemento'], $enderecoAluno->complemento);
        $this->assertEquals($data['tipo_endereco_id'], $enderecoAluno->tipo_endereco_id);
        $this->assertEquals($alunoMock->id, $enderecoAluno->aluno_id);
        $this->assertEquals($enderecoMock->id, $enderecoAluno->endereco_id);
    }

    public function testUpdateEnderecoAlunoWithNewEndereco()
    {
        $alunoMock = Aluno::factory()->create();
        $tipoEnderecoMock = TipoEndereco::factory()->create();

        $data = [
            'cep' => '12345678',
            'rua' => 'Rua Exemplo',
            'numero' => '100',
            'complemento' => 'Apto 101',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ];

        EnderecoAluno::factory()->create([
            'aluno_id' => $alunoMock->id,
            'endereco_id' => Endereco::factory()->create()->id,
            'numero' => '99',
            'complemento' => 'Apto 99',
            'tipo_endereco_id' => $tipoEnderecoMock->id
        ]);

        $service = new EnderecoAlunoService($alunoMock, $data);
        $enderecoAluno = $service->updateEnderecoAluno();

        $this->assertInstanceOf(EnderecoAluno::class, $enderecoAluno);
        $this->assertEquals($data['numero'], $enderecoAluno->numero);
        $this->assertEquals($data['complemento'], $enderecoAluno->complemento);
        $this->assertEquals($data['tipo_endereco_id'], $enderecoAluno->tipo_endereco_id);
        $this->assertEquals($alunoMock->id, $enderecoAluno->aluno_id);
        $this->assertNotNull($enderecoAluno->endereco_id);
    }
}