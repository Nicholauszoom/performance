<?php

namespace App\Imports;

use App\Models\Holiday;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HolidayDataImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $key => $holiday) {
            Log::info("Holiday ". $holiday);
            if(isset($holiday["name"]) && $holiday["date"]) {
               $holiday = Holiday::create([
                    "name"=> $holiday["name"],
                    "date" => Carbon::parse($holiday["date"]),
                    "recurring" => strtolower($holiday["recurring"]) == 'yes' ? 1 : 0,
                    ]);
                Log::info('Loaded holiday '. $holiday);

        } else {
            Log::error('Failed to import holiday '. $holiday);
        }
    }
}
}
