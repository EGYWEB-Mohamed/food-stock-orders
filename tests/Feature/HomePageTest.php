<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_homepage_work()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

    }

    public function test_is_homepage_has_products()
    {
        $this->seed();
        $this->get(route('home'))
             ->assertSee([
                 '<h5 class="card-title text-center">Burger</h5>',
                 '<h5 class="card-title text-center">Taco</h5>',
                 '<h5 class="card-title text-center">Fried Chicken</h5>',
                 '<h5 class="card-title text-center">Chicken Crepe</h5>'
             ],false);
    }
    public function test_is_there_login_and_register_url()
    {
        $this->get(route('home'))
             ->assertSee([route('filament.auth.login'),route('register')]);
    }
    public function test_is_auth_required_to_buy_new_product_work()
    {
        $this->post(route('checkout',1))
             ->assertRedirect(route('filament.auth.login'));
    }

    public function test_is_user_can_login_successfully()
    {
        $this->seed();
        $user = User::first();
        $response = $this->actingAs($user)->get(route('filament.auth.login'));
        $response->assertRedirect(route('filament.pages.dashboard'));
    }
    public function test_is_there_logout_and_dashboard_url()
    {
        $this->seed();
        $user = User::first();
        $this->actingAs($user)->get(route('home'))
             ->assertSee([route('filament.auth.logout'),route('filament.pages.dashboard')]);
    }

    public function test_is_user_can_logout()
    {
        $this->seed();
        $user = User::first();
        $this->actingAs($user)->post(route('filament.auth.logout'))->assertRedirect(route('filament.auth.login'));
        $this->assertGuest();
    }
}
