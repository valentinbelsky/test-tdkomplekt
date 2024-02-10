<?php

namespace App\Livewire;

use App\Http\Controllers\WorksheetController;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateWorksheet extends Component
{
    use WithFileUploads;

    public $success = false;

    public $userData;
    public $userFilesUpload = [];

    public function mount()
    {
        $this->userData['surname'] = '';
        $this->userData['name'] = '';
        $this->userData['patronymic'] = '';
        $this->userData['dateOfBirth'] = '';
        $this->userData['email'] = '';
        $this->userData['phone'] = '';
        $this->userData['maritalStatus'] = 0;
        $this->userData['aboutYourself'] = '';
    }

    public function render()
    {
        $this->userData['maritalStatus'] = 0;
        return view('livewire.create-worksheet');
    }


    public function saveForm()
    {
        $validatedData = $this->validate();
        $user = $this->saveUserData($validatedData);
        $this->saveUserFiles($this->getFilePaths($validatedData), $user->id);
        $this->success = true;
    }

    private function saveUserData(mixed $validatedData)
    {
        return User::create([
           'surname' => $validatedData['userData']['surname'],
           'name' => $validatedData['userData']['name'],
           'patronymic' => $validatedData['userData']['patronymic'],
           'date_of_birth' => $validatedData['userData']['dateOfBirth'],
           'email' => $validatedData['userData']['email'],
           'phone' => $validatedData['userData']['phone'],
           'marital_status' => $validatedData['userData']['maritalStatus'],
           'about_yourself' => $validatedData['userData']['aboutYourself']
       ]);
    }

    private function saveUserFiles(array $validatedData, $user_id)
    {
        foreach ($validatedData as $item) {
            UserFile::create([
                'file_path' => $item,
                'user_id' => $user_id,
            ]);
        }

    }

    private function getFilePaths($validatedData): array
    {
        $arrayFilePaths = [];
        if (isset($validatedData['userFilesUpload'])) {
            foreach ($validatedData['userFilesUpload'] as $data) {
                $arrayFilePaths[] = $data->getClientOriginalName();
            }
        }
        return $arrayFilePaths;
    }

    // Validate

    public function updatedFilesUpload()
    {
        $this->validate();
    }

    public function rules()
    {
        return [
            'userData.surname' => 'required|max:20',
            'userData.name' => 'required|max:10',
            'userData.patronymic' => 'max:20',
            'userData.dateOfBirth' => 'required|date',
            'userData.phone' => 'required_without:userData.email',
            'userData.email' => 'required_without:userData.phone',
            'userData.maritalStatus' => 'required',
            'userData.aboutYourself' => 'max:1000',
            'userFilesUpload' => 'array|max:5',
            'userFilesUpload.*' => 'file|max:5120|mimes:jpg,png,pdf'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Данное поле обязательно для заполнения.',
            'max' => 'Для данного поля максимальное количество символов :max.',
            'date' => 'Данное поле должно быть заполнено как дата.',
            'phone.required_without' => 'Поле "Телефон" обязательно для заполнения, если нет email.',
            'email.required_without' => 'Поле "Email" обязательно для заполнения, если нет телефона.',
            'array' => 'Данное поле должно быть заполнено как массив.',
            'userFilesUpload.max' => 'Максимальное количество файлов :max.',
            'userFilesUpload.*.file' => 'Данное поле должно быть заполнено как файл.',
            'userFilesUpload.*.max' => 'Максимальный допустимый размер файла 5 мб.',
            'userFilesUpload.*.mimes' => 'Допустимые форматы файлов: jpg, png, pdf.'
        ];
    }
}
