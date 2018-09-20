<?php
use App\Models\PracticeModel as PracticeModel;

class AppComponent
{
    public $title='App Component Works!';
    private $practicModel;

    public $data;
    public function onInit()
    {
        // $this->practiceModel = new PracticeModel();
        // $this->data = $this->practiceModel->getitems('');
    }
}
