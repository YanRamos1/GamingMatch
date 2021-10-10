<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddFriend extends Component
{
    public function render()
    {
        $users = User::where('id', '!=', Auth::user()->id)->limit(14)->latest()->get();

        return view('livewire.add-friend', compact('users'));
    }

    public function addToFriend($id)
    {
        try {
            $user = Auth::user();
            $recipient = User::find($id);
            if (!$recipient) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'User not found!']);
            } else {
                if ($user->befriend($recipient)) {
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request has been sent!']);

                } else {
                    $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Request has been failed!']);
                }
            }

        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
