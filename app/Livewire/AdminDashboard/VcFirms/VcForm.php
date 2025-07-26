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

    public ?Vc $vc = null;

    public array $selectedVerticals = [];
    public array $selectedStages = [];
    public array $portfolioIds = [];
    public array $whitelistEmails = [];
    public array $official_x_accounts = [];
    public array $staff_x_accounts = [];

    public $stageTags;
    public $verticalTags;
    public $vcOptions;

    public string $country = '';
    public string $name = '';
    public string $website = '';
    public string $substack_url = '';
    public string $medium_url = '';
    public string $blog_url = '';
    public $countries = [];

    #[Rule('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public $logo;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'country' => 'nullable|string|exists:countries,code',
        'website' => 'nullable|string|max:255',
        'substack_url' => 'nullable|string|max:255',
        'medium_url' => 'nullable|string|max:255',
        'blog_url' => 'nullable|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'selectedVerticals' => 'array|required',
        'selectedStages' => 'array|required',
        'portfolioIds' => 'array',
        'whitelistEmails' => 'array',
        'whitelistEmails.*' => 'email:rfc,dns',
        'official_x_accounts' => 'array',
        'official_x_accounts.*' => 'string|max:255',
        'staff_x_accounts' => 'array',
        'staff_x_accounts.*' => 'string|max:255',
    ];

    public function mount()
    {
        $vc = $this->vc;

        $this->verticalTags = Tag::where('type', 'vertical')->orderBy('name')->get();
        $this->stageTags = Tag::where('type', 'stage')->orderBy('name')->get();
        $this->vcOptions = Vc::orderBy('name')->get(['id', 'name'])->toArray();

        if ($vc) {
            // Populate form data from existing VC
            $this->name = $vc->name;
            $this->country = $vc->country ?? '';
            $this->website = $vc->website ?? '';
            $this->substack_url = $vc->substack_url ?? '';
            $this->medium_url = $vc->medium_url ?? '';
            $this->blog_url = $vc->blog_url ?? '';
            $this->official_x_accounts = $vc->official_x_accounts ?? [];
            $this->staff_x_accounts = $vc->staff_x_accounts ?? [];
            $this->portfolioIds = $vc->investedIn()->pluck('vcs.id')->toArray();
            $this->selectedVerticals = $vc->tags()->where('type', 'vertical')->pluck('tags.id')->toArray();
            $this->selectedStages = $vc->tags()->where('type', 'stage')->pluck('tags.id')->toArray();
            $this->whitelistEmails = $vc->whitelists()->pluck('email')->toArray();
        }
        $this->loadCountries();
    }


    public function loadCountries()
    {
        $this->countries = cache()->rememberForever('countries_list_v1', function () {
            return Country::select('name','code')->get()->map(fn($c) => [
                'label' => $c->name,
                'code' => $c->code,
            ])->toArray();
        });
    }

    public function save()
    {
        $this->validate();

        try {

            $logoUrl = $this->storeLogo();

            if ($this->vc) {
                // Update
                $this->vc->update([
                    'name' => $this->name,
                    'country' => $this->country,
                    'website' => $this->website,
                    'substack_url' => $this->substack_url,
                    'medium_url' => $this->medium_url,
                    'blog_url' => $this->blog_url,
                    'official_x_accounts' => $this->official_x_accounts,
                    'staff_x_accounts' => $this->staff_x_accounts,
                    'logo_url' => $logoUrl ?? $this->vc->logo_url,
                ]);
                $vc = $this->vc;

                $this->logActivity($vc, 'Updated');


            } else {
                // Create new VC
                $vc = $this->createVc($logoUrl);
                $this->logActivity($vc, 'Created');
            }

            $this->syncTags($vc);
            $this->syncInvestments($vc);
            $this->syncWhitelist($vc);

            $this->success('VC saved successfully.');
            Cache::forget('whitelist:emails');

            return redirect()->route('core.vc-firms.index');

        } catch (\Throwable $e) {
            logger()->error('Error saving VC', ['error' => $e->getMessage()]);
            $this->error('An error occurred while saving the VC. Please try again.');
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
            'substack_url' => $this->substack_url,
            'medium_url' => $this->medium_url,
            'blog_url' => $this->blog_url,
            'official_x_accounts' => $this->official_x_accounts,
            'staff_x_accounts' => $this->staff_x_accounts,
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

        $vc->whitelists()->delete();


        $validEmails = collect($this->whitelistEmails)
            ->filter(fn($email) => !empty($email))
            ->map(fn($email) => strtolower(trim($email)))
            ->unique()
            ->map(fn($email) => ['email' => $email]);

        if ($validEmails->isNotEmpty()) {
            $vc->whitelists()->createMany($validEmails->toArray());
        }
    }


    protected function logActivity($vc, string $action): void
    {
        try {
            $username = auth()->user()->name ?? auth()->user()->email;
            activity('VC')
                ->event($action)

                ->causedBy(auth()->user())
                ->performedOn($vc)
                ->withProperties([
                    'action' => 'User '.  $username. ' ' . $action . ' : VC: ' . $vc->name,
                    'ip' => request()->ip() ?? 'N/A',
                ])
                ->log(" {$vc->name} {$action} by {$username}");

        } catch (\Throwable $e) {
            logger()->error('Error  saving activitylog for VC', ['error' => $e->getMessage()]);
        }
    }


    public function render()
    {
        return view('livewire.admin-dashboard.vc-firms.vc-form')
            ->title('VC Firms Form');
    }
}
