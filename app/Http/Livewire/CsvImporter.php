<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\Supply;
use WireUi\Traits\Actions;

class CsvImporter extends Component
{
    use WithFileUploads;
    use Actions;

    protected $listeners = ['import' => 'toggle'];
    
    public bool $open = false;
    public $model;
    public $file;
    public $headers = [];

    public $columnsToMap = [];
    public $requiredColumns = [];
    public $columnLabels = [];
    public $imported = false;

    public function mount(){
        $this->requiredColumns = $this->columnsToMap;
        $this->columnsToMap = collect($this->columnsToMap)
        ->mapWithKeys(fn($column) => [$column => ''])
        ->toArray();
    }

    public function rules(){
        $columnRule = collect($this->requiredColumns)
        ->mapWithKeys(function ($column) {
            return ['columnsToMap.'.$column => ['required']];
        })
        ->toArray();

        return array_merge($columnRule, [
            'file' => ['required', 'mimes:csv,txt', 'max:10240'],
        ]);
    }

    public function validationAttributes(){
        return collect($this->requiredColumns)
        ->mapWithKeys(function ($column) {
            return ['columnsToMap.'.$column => strtolower($this->columnLabels[$column]) ?? $column];
        })
        ->toArray();
    }

    public function updatedFile(){
        $this->validateOnly('file');
        $csv = $this->readCsv;

        $this->headers = $csv->getHeader();
    }

    public function getReadCsvProperty(): Reader{
        return $this->readCsv($this->file->getRealPath());
    }

    public function getReadCsvRecordsProperty(){
        return Statement::create()->process($this->readCsv);
    }

    protected function readCsv(string $path): Reader{
        $stream = fopen($path, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setHeaderOffset(0);

        return $csv;
    }

    public function import(){
        $this->validate();
        $records = [];
        $this->imported = true;
   
        foreach($this->getReadCsvRecordsProperty()->getRecords() as $ins_columns){
            Supply::create(
                array_intersect_key($ins_columns, $this->columnsToMap),
                collect($this->columnsToMap)->keys()->toArray()
            );
        }

        $this->emit('itemUpdated');
        $this->reset('file', 'headers');
        $this->dialog()->show([
            'title'       => 'CSV Imported!',
            'description' => 'The CSV is Succesfully Imported!',
            'icon'        => 'success',
        ]);

     
    }

    public function toggle(){
        $this->open = !$this->open;
    }

    public function render()
    {
        return view('livewire.csv-importer');
    }
}
