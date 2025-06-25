<?php

namespace App\Livewire\AdminDashboard\VcFirms;

use App\Models\Country;
use App\Models\Tag;
use App\Models\Vc;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;


#[Layout('components.layouts.admin-dashboard')]
class VcForm extends Component
{
    use Toast, WithFileUploads;

    public array $selectedVerticals = [];
    public array $selectedStages = [];
    public $stageTags;
    public $verticalTags;
    public $vcOptions;
    public $ticket_min;
    public $ticket_max;
    public string $country = '';
    public $countries = [];
    public string $name = '';
    public string $website = '';
    public string $description = '';
    public array $portfolioIds = [];
    public array $whitelistEmails = [];

    #[Rule('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'country' => 'required|string|exists:countries,code',
        'website' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:1000',
        'ticket_min' => 'nullable|numeric|min:0',
        'ticket_max' => 'nullable|numeric|min:0|gte:ticket_min',
        'logo' => 'nullable|image|max:2048',
        'selectedVerticals' => 'array',
        'selectedStages' => 'array',
        'portfolioIds' => 'array',
        'whitelistEmails' => 'array',
        'whitelistEmails.*' => 'email:rfc,dns',
    ];

    /**
     * @throws \Exception
     */
    public function mount()
    {
        $this->verticalTags = Tag::where('type', 'vertical')->orderBy('name')->get();
        $this->stageTags = Tag::where('type', 'stage')->orderBy('name')->get();

        $this->vcOptions = Vc::orderBy('name')
            ->get(['id', 'name'])
            ->toArray();


    }

    public function loadCountries()
    {
        $this->countries = cache()->rememberForever('countries_list', function () {
            return Country::all()->map(function ($country) {
                return [
                    'label' => $country->name,
                    'code' => $country->code,
                ];
            })->toArray();
        });
    }

    public function generateDescriptionWithAI()
    {
        $this->info('AI not available now');
    }


    public function save()
    {
        try {
            $this->validate();

            $logoUrl = $this->storeLogo();
            $vc = $this->createVc($logoUrl);

            $this->syncTags($vc);
            $this->syncInvestments($vc);
            $this->syncWhitelist($vc);

            $this->success('VC saved successfully.');

            Cache::forget('whitelist:emails');


            return redirect()->route('core.vc-firms.index');

        } catch (\Throwable $e) {

            logger()->error('Error saving VC', ['error' => $e->getMessage()]);


            $this->error('An error occurred while saving the VC. Please try again.');

            return;
        }
    }




    protected function storeLogo(): ?string
    {
        if ($this->logo) {
            return $this->logo->store('vc_logos', 'public');
        }

        return null;
    }

    protected function createVc(?string $logoUrl): Vc
    {
        return Vc::create([
            'name' => $this->name,
            'country' => $this->country,
            'website' => $this->website,
            'description' => $this->description,
            'ticket_min' => $this->ticket_min,
            'ticket_max' => $this->ticket_max,
            'logo_url' => $logoUrl,
        ]);
    }

    protected function syncTags(Vc $vc): void
    {
        $vc->tags()->sync(array_merge(
            $this->selectedVerticals,
            $this->selectedStages
        ));
    }

    protected function syncInvestments(Vc $vc): void
    {
        $vc->investedIn()->sync($this->portfolioIds);
    }

    protected function syncWhitelist(Vc $vc): void
    {
        $existingEmails = $vc->whitelists()
            ->pluck('email')
            ->map(fn($e) => strtolower($e))
            ->toArray();

        $validEmails = collect($this->whitelistEmails)
            ->filter(fn($email) => !empty($email))
            ->map(fn($email) => strtolower(trim($email)))
            ->unique()
            ->reject(fn($email) => in_array($email, $existingEmails))
            ->map(fn($email) => ['email' => $email]);

        $vc->whitelists()->createMany($validEmails->toArray());
    }









    public function render()
    {
        return view('livewire.admin-dashboard.vc-firms.vc-form')
            ->title('VC Firms Form');
    }
}
