<?php

namespace App\Exports;

use App\Models\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class ConfirmedBookingsExport implements FromCollection, WithHeadings, WithCustomCsvSettings
{

    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {

        return $this->bookings->map(function ($booking) {
                $candidate = $booking->candidate;
                $fullName = $candidate
                    ? "{$candidate->first_name} {$candidate->last_name}"
                    : 'N/A';

                return [
                    'MailAddress' => $candidate->email ?? '',
                    'Name' => $fullName,
                    'Gender (1:Male, 2:Female)' => $candidate->gender === 'male' ? 1 : ($candidate->gender === 'female' ? 2 : ''),
                    'Nationality code' => 15, // For Bangladesh Nationality_id 15
                    'Birthday (YYYY/MM/DD)' => $candidate->date_of_birth
                        ? \Carbon\Carbon::parse($candidate->date_of_birth)->format('Y/m/d')
                        : '',
                ];
            });
    }


    public function headings(): array
    {
        return [
            'MailAddress',
            'Name',
            '"Gender (1:Male, 2:Female)"', // manually quote
            'Nationality code',
            'Birthday (YYYY/MM/DD)',
        ];
    }

    // 👇 This disables automatic double quotes around CSV fields
    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true,
            'delimiter' => ',',
            'enclosure' => '', // <- this removes quotes
        ];
    }
}
