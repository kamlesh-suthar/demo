<?php

namespace App\Observers;

use App\Jobs\SendNewEmployeeJoinedEmailJob;
use App\Mail\EmployeeJoined;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\NewEmployeeJoiningNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        Log::info('New Employee Created ' . $employee->name);

//        Mail::send('email.new_employee_joined', ['employee' => $employee], function ($message) {
//            $message->to('dharmik@prakashinfotech.com');
//            $message->subject('New employee Joined');
//        });

//        Mail::to(User::first())->send(new EmployeeJoined($employee));
//
//        User::first()->notify(new NewEmployeeJoiningNotification($employee));
//
//        dd('done');

        SendNewEmployeeJoinedEmailJob::dispatch($employee);
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        Log::info('Employee updated ' . $employee->name);
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        Log::info('Employees deleted ' . $employee->name);
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        Log::info('Employee force deleted ' . $employee->name);
    }
}
