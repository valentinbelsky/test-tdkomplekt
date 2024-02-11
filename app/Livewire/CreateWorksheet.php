<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateWorksheet extends Component
{
    use WithFileUploads;

    public $userData = [];
    public $userFilesUpload = [];

    public $countries = ['+375', '+7'];

    public $success = false;
    public $isFormValid = false;

    public function mount()
    {
        $this->userData['surname'] = '';
        $this->userData['name'] = '';
        $this->userData['patronymic'] = '';
        $this->userData['date_of_birth'] = '';
        $this->userData['email'] = '';
        $this->userData['phone'][0] = ['country' => "+375", 'number' => '']; // можно хранить в бд код стран по id 0 -"+375", 1 - "+7" и т.д.
        $this->userData['marital_status'] = 0;
        $this->userData['about_yourself'] = '';
    }

    // Добавление полей для телефона
    public function addPhone()
    {
        $count = count($this->userData['phone']);
        if ($count < 5) {
            $this->userData['phone'][] = ['country' => "+375", 'number' => ''];
        }
    }

    // Валидация каждого поля
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Валидация всей формы если ок, активируем кнопку "Отправить"
    public function updatedUserData($data)
    {
        $this->isFormValid = !Validator::make($this->userData, [
            'surname' => 'required|max:20',
            'name' => 'required|max:10',
            'patronymic' => 'max:20',
            'date_of_birth' => 'required|date',
            'phone.*.number' => 'required_without:email',
            'phone.*.country' => 'required',
            'email' => 'required_without:phone.*.number',
            'marital_status' => 'required',
            'about_yourself' => 'max:1000'])->fails();
    }

    public function render()
    {
        return view('livewire.create-worksheet');
    }

    public function saveForm()
    {
        $validatedData = $this->validate();

        // Создаем запись пользователя с валидированными данными.
        $user = $this->createUser($validatedData['userData']);

        // Сохраняем файлы пользователя, если они были загружены.
        if (!empty($validatedData['userFilesUpload'])) {
            $this->saveUserFiles($validatedData['userFilesUpload'], $user->id);
        }

        // Устанавливаем флаг успешного сохранения.
        $this->success = true;
    }

    protected function createUser(array $userData)
    {
        // Кодируем телефоны в формате JSON перед сохранением, если это массив.
        $phone = isset($userData['phone']) && is_array($userData['phone'])
            ? json_encode($userData['phone'])
            : null;

        // Создаем новую запись в базе данных.
        return User::create([
            'surname' => $userData['surname'],
            'name' => $userData['name'],
            'patronymic' => $userData['patronymic'],
            'date_of_birth' => $userData['date_of_birth'],
            'email' => $userData['email'],
            'phone' => $phone, // телефон уже в формате JSON
            'marital_status' => $userData['marital_status'],
            'about_yourself' => $userData['about_yourself'],
        ]);
    }

    private function saveUserFiles(array $validatedData, $userId)
    {
        foreach ($validatedData as $file) {

            // Получаем имя файла
            $originalFileName = $file->getClientOriginalName();

            // Очищаем от спец символов
            $sanitizedFileName = preg_replace("/[^\w\-_.]/", '', $originalFileName);

            $userDirectory = "users/{$userId}";

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

    public function rules()
    {
        return $this->getRulesValidation();
    }

    private function getRulesValidation(): array
    {
        return [
            'userData.surname' => 'required|max:20',
            'userData.name' => 'required|max:10',
            'userData.patronymic' => 'max:20',
            'userData.date_of_birth' => 'required|date',
            'userData.phone.*.number' => 'required_without:userData.email',
            'userData.phone.*.country' => 'required',
            'userData.email' => 'required_without:userData.phone.*.number',
            'userData.marital_status' => 'required',
            'userData.about_yourself' => 'max:1000',
            'userFilesUpload' => 'array|max:5',
            'userFilesUpload.*' => 'file|max:5120|mimes:jpg,png,pdf'
        ];
    }

    public function messages()
    {
        return $this->getMessagesValidation();
    }

    private function getMessagesValidation(): array
    {
        return [
            'required' => 'Данное поле обязательно для заполнения.',
            'max' => 'Для данного поля максимальное количество символов :max.',
            'date' => 'Данное поле должно быть заполнено как дата.',
            'userData.phone.*.number.required_without' => 'Поле "Телефон" обязательно для заполнения, если нет email.',
            'userData.email.required_without' => 'Поле "Email" обязательно для заполнения, если нет телефона.',
            'array' => 'Данное поле должно быть заполнено как массив.',
            'userFilesUpload.max' => 'Максимальное количество файлов :max.',
            'userFilesUpload.*.max' => 'Максимальный допустимый размер файла 5 мб.',
            'userFilesUpload.*.mimes' => 'Допустимые форматы файлов: jpg, png, pdf.'
        ];
    }
}
