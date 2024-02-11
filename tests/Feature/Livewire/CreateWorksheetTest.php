<?php

namespace Tests\Feature\Livewire;

use App\Livewire\CreateWorksheet;
use Livewire\Livewire;
use Tests\TestCase;

class CreateWorksheetTest extends TestCase
{

    /** @test */
    public function renders_successfully()
    {
        Livewire::test(CreateWorksheet::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_set_required_user_data()
    {
        Livewire::test(CreateWorksheet::class)
            ->set('userData.surname', 'Ivanov')
            ->assertSet('userData.surname', 'Ivanov');

        Livewire::test(CreateWorksheet::class)
            ->set('userData.name', 'Ivan')
            ->assertSet('userData.name', 'Ivan');

        Livewire::test(CreateWorksheet::class)
            ->set('userData.date_of_birth', '01.01.2000')
            ->assertSet('userData.date_of_birth', '01.01.2000');

        Livewire::test(CreateWorksheet::class)
            ->set('userData.email', 'mail@example.com')
            ->assertSet('userData.email', 'mail@example.com');
    }

    /** @test */
    public function title_field_is_required()
    {
        Livewire::test(CreateWorksheet::class)
            ->set('userData.surname', '')
            ->call('saveForm')
            ->assertHasErrors(['userData.surname' => 'required']);

        Livewire::test(CreateWorksheet::class)
            ->set('userData.name', '')
            ->call('saveForm')
            ->assertHasErrors(['userData.name' => 'required']);

        Livewire::test(CreateWorksheet::class)
            ->set('userData.date_of_birth', '')
            ->call('saveForm')
            ->assertHasErrors(['userData.date_of_birth' => 'required']);

        Livewire::test(CreateWorksheet::class)
            ->set('userData.email', '')
            ->call('saveForm')
            ->assertHasErrors(['userData.email' => 'required_without']);
    }
}
