<?php

namespace App\Livewire\AdminDashboard\VcFirms;

use App\Models\Country;
use App\Services\AI\OpenAIService;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

#[Layout('components.layouts.admin-dashboard')]
class VcForm extends Component
{
    use Toast, WithFileUploads;

    public array $countries = [];
    public string $country = '';

    public string $name = '';
    public array $stages = [];
    public string $website = '';
    public string $description = '';
    public array $tags = [];

    #[Rule('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'stages' => 'required|array|min:1',
        'stages.*' => 'string|in:Pre-Seed,Seed,Series A,Series B,Growth',
        'website' => 'nullable|url',
        'description' => 'nullable|string',
        'tags' => 'array',
        'tags.*' => 'string',
        'country' => 'required|string|exists:countries,code',
    ];

    #[Lazy]
    public function loadCountries()
    {
        $this->countries = Country::all()->map(function ($country) {
            return [
                'label' => $country->name,
                'code' => $country->code,
            ];
        })->toArray();
    }


    public function save()
    {
        $validatedData = $this->validate();
    }


    public function generateDescriptionWithAI(): void
    {

        $this->validate([
            'description' => 'nullable|string',
            'tags' => 'array|required|min:1',
            'tags.*' => 'string',
            'name' => 'required|min:2',

        ]);

        $this->rateLimiter();


        $ai = new OpenAIService();

        try {
            $response = $ai->chat([
                ['role' => 'user', 'content' => $this->aiPrompt()]
            ], 'gpt-4-1106-preview', 0.4);
            $this->description = trim($response);
        } catch (\Exception $e) {
            $this->addError('description', 'Failed to generate description. Try again.');
        }
    }


    protected function rateLimiter()
    {
        $key = 'ai-description:' . auth()->id();

        if (RateLimiter::tooManyAttempts($key, 2)) {
            $this->addError('description', 'You are making requests too fast. Please wait a moment.');
            return;
        }

        RateLimiter::hit($key, 120);
    }


    protected function aiPrompt(): string
    {
        return "Generate a concise, professional, and investor-oriented description (limit 500 character) for a venture capital firm named '{$this->name}'.

If the firm is well-known and you have prior knowledge about it, include relevant background details, known investments, reputation, or positioning—alongside the provided data.

Otherwise, generate the description based solely on the following:

- Investment stages: " . implode(', ', $this->stages) . "
- Focus areas or themes: " . implode(', ', $this->tags) . "

Maintain a clear, modern tone suitable for a VC directory or professional profile. Highlight unique value propositions if applicable.";

    }


    public function render()
    {
        return view('livewire.admin-dashboard.vc-firms.vc-form')
            ->title('Add VC Firms');
    }
}
