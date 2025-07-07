<?php

namespace App\Livewire\AdminDashboard\Crawler;

use App\Mail\ForwardNewsletterMailable;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.admin-dashboard')]
class NewsletterShowDetails extends Component
{
    use Toast;
    public Newsletter $newsletter;
    public string $email = '';

    public function mount(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter->load('vc');
    }


    public function forwardEmail()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        try {

            Mail::to($this->email)->queue(new ForwardNewsletterMailable($this->newsletter));


            $this->success('Send Newsletter Email', 'Email has been sent to ' . $this->email);

        } catch (\Exception $e) {
            Log::error('Failed to send newsletter: ' . $e->getMessage());

            $this->addError('email', 'Sending failed. Please try again later.');

           $this->warning('Forward failed','Please try again later.');
        }

        $this->reset('email');
    }



    public function render()
    {
        return view('livewire.admin-dashboard.crawler.newsletter-show-details');
    }
}
