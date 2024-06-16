<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReservationReminders extends Command
{
    protected $signature = 'send:reservation-reminders';
    protected $description = 'Send reservation reminders to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        $reservations = Reservation::where('date', $tomorrow)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
        }

        return 0;
    }
}
