<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateWorksheet extends Component
{
    use WithFileUploads;

    public $userData = [];
    public $userFilesUpload = [];

    public $success = false;
    public $isFormValid = false;

    public function mount()
    {
        $this->userData['surname'] = '';
        $this->userData['name'] = '';
        $this->userData['patronymic'] = '';
        $this->userData['date_of_birth'] = '';
        $this->userData['email'] = '';
        $this->userData['phone'][0] = '';
        $this->userData['marital_status'] = 0;
        $this->userData['about_yourself'] = '';
    }

    public function addPhone($index)
    {
        $count = count($this->userData['phone']);
        if ($count < 5){
            $this->userData['phone'][] = '';
        }

    }

    public function updated($propertyName)
    {
        $this->transformKeys();
        $this->validateOnly($propertyName);
    }

    public function updatedUserData($data)
    {
        $this->isFormValid = !Validator::make($this->userData, [
            'surname' => 'required|max:20',
            'name' => 'required|max:10',
            'patronymic' => 'max:20',
            'date_of_birth' => 'required|date',
            'phone' => 'required_without:email',
            'email' => 'required_without:phone',
            'marital_status' => 'required',
            'about_yourself' => 'max:1000'])->fails();
    }

    public function updatedUserFilesUpload()
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.create-worksheet');
    }

    public function saveForm()
    {
        $validatedData = $this->validate();

        // Сохраняем данные пользователя
        $user = User::create($validatedData['userData']);

        $this->saveUserFiles($validatedData['userFilesUpload'], $user->id);
        $this->success = true;
    }

    public function rules()
    {
        return $this->getRulesValidation();
    }

    public function messages()
    {
        return $this->getMessagesValidation();
    }

    private function saveUserFiles(array $validatedData, $userId)
    {
        foreach ($validatedData as $file) {
            $originalFileName = $file->getClientOriginalName();
            $sanitizedFileName = preg_replace("/[^\w\-_.]/", '', $originalFileName); // Очищаем от специальных символов

            $userDirectory = "user/{$userId}";

            if (!is_dir('storage/' . $userDirectory)) {
                mkdir('storage/' . $userDirectory, 0777, true);
            }
            $file->storeAs($userDirectory, $sanitizedFileName, 'public');

            UserFile::create([
                'file_path' => $sanitizedFileName,
                'user_id' => $userId,
            ]);
        }
    }

    private function getRulesValidation(): array
    {
        return [
            'userData.surname' => 'required|max:20',
            'userData.name' => 'required|max:10',
            'userData.patronymic' => 'max:20',
            'userData.date_of_birth' => 'required|date',
            'userData.phone' => 'required_without:userData.email',
            'userData.email' => 'required_without:userData.phone',
            'userData.marital_status' => 'required',
            'userData.about_yourself' => 'max:1000',
            'userFilesUpload' => 'array|max:5',
            'userFilesUpload.*' => 'file|max:5120|mimes:jpg,png,pdf'
        ];
    }

    private function getMessagesValidation(): array
    {
        return [
            'required' => 'Данное поле обязательно для заполнения.',
            'max' => 'Для данного поля максимальное количество символов :max.',
            'date' => 'Данное поле должно быть заполнено как дата.',
            'userData.phone.required_without' => 'Поле "Телефон" обязательно для заполнения, если нет email.',
            'userData.email.required_without' => 'Поле "Email" обязательно для заполнения, если нет телефона.',
            'array' => 'Данное поле должно быть заполнено как массив.',
            'userFilesUpload.max' => 'Максимальное количество файлов :max.',
            'userFilesUpload.*.max' => 'Максимальный допустимый размер файла 5 мб.',
            'userFilesUpload.*.mimes' => 'Допустимые форматы файлов: jpg, png, pdf.'
        ];
    }
}
