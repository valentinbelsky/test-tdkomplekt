<div>
    @if(!$success)
    <x-form>

        {{-- ФИО --}}
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-2">
                <x-label for="surname">Фамилия</x-label>
                <div class="mt-2">
                    <x-input wire:model="userData.surname" type="text" name="surname" id="surname" maxlength="20" autocomplete="surname"/>
                </div>
                @error('userData.surname') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-2">
                <x-label for="name">Имя</x-label>
                <div class="mt-2">
                    <x-input wire:model="userData.name" type="text" name="name" id="name" maxlength="10" autocomplete="name" required/>
                </div>
                @error('userData.name') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-2">
                <x-label for="patronymic">Отчество</x-label>
                <div class="mt-2">
                    <x-input wire:model="userData.patronymic" type="text" name="patronymic" id="patronymic" maxlength="20" autocomplete="patronymic"/>
                </div>
                @error('userData.patronymic') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Дата --}}
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6">
                <x-label for="date-of-birth">Дата</x-label>
                <div class="mt-2">
                    <x-input type="date" wire:model="userData.dateOfBirth" name="date-of-birth" id="date-of-birth" required/>
                </div>
                @error('userData.date') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        {{--Email, Phone--}}
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <x-label for="email">Email</x-label>
                <div class="mt-2">
                    <x-input wire:model="userData.email" type="email" name="email" id="email" autocomplete="email"/>
                </div>
                @error('userData.email') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-3">
                <x-label for="phone">Phone</x-label>
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <label for="country" class="sr-only">Phone</label>
                        <select wire:model="country" id="country" name="country"
                                class="h-full rounded-md border-0 bg-transparent bg-none py-0 pl-2 pr-3 text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            <option selected>+375</option>
                            <option>+7</option>
                        </select>
                    </div>
                    <x-tel-input wire:model="userData.phone" type="tel" name="phone" id="phone" autocomplete="tel"/>
                </div>
                @error('userData.phone') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        {{--Marital-status--}}
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6">
                <x-label for="marital-status">Семейное положение</x-label>
                <div class="mt-2">
                    <select wire:model="userData.maritalStatus" id="marital-status" name="marital-status"
                            class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option selected value="0">Холост/не замужем</option>
                        <option value="1">Женат/замужем</option>
                        <option value="2">В разводе</option>
                        <option value="3">Вдовец/вдова</option>
                    </select>
                </div>
                @error('userData.maritalStatus') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        {{--About-yourself--}}
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6">
                <x-label for="about-yourself">О себе</x-label>
                <div class="mt-2">
                    <x-textarea wire:model="userData.aboutYourself" data-limit-rows="true" id="about-yourself" name="about-yourself"></x-textarea>
                </div>
                @error('userData.aboutYourself') <span class="error">{{ $message }}</span> @enderror
            </div>

        </div>

        {{--About-yourself--}}
        <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="col-span-full">
                <label for="cover-files" class="block text-sm font-medium leading-6 text-gray-900">Добавить
                    файлы</label>
                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                            <label for="file-upload"
                                   class="relative cursor-pointer rounded-md bg-white px-3 py-2 font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                <span>Загрузить файлы</span>

                                <input wire:model="userFilesUpload" multiple id="file-upload" name="file-upload" type="file" class="sr-only">


                            </label>
                        </div>
                    </div>
                </div>
                @error('userFilesUpload.filesUpload') <span class="">{{ $message }}</span> @enderror
                @error('userFilesUpload.filesUpload.*') <span class="">{{ $message }}</span> @enderror
            </div>

        </div>

        {{--About-yourself--}}
        <div class="flex mt-5 gap-x-4 sm:col-span-2">
            <div class="relative flex gap-x-3">
                <div class="flex h-6 items-center">
                    <input wire:model="agree" id="agree" name="agree" type="checkbox" checked required
                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                </div>
                <div class="text-sm leading-6">
                    <label for="agree" class="font-medium text-gray-900">Я ознакомился с правилами.</label>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <button type="submit" wire:submit.prevent="saveForm"
                    class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Отправить
            </button>
        </div>
    </x-form>
        @else
        <div class="text-center"><h1>Success</h1></div>
    @endif
</div>
