<?php

namespace App\Imports;

use App\Models\Packet;
use App\Models\Treatment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PacketsImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        $missingTreatments = [];
    
        foreach ($rows as $index => $row) {
            $treatmentNames = array_map('trim', explode(',', $row['treatments']));
            $found = Treatment::whereIn('name', $treatmentNames)->pluck('name')->toArray();
            $notFound = array_diff($treatmentNames, $found);
    
            if (!empty($notFound)) {
                $missingTreatments[] = "Baris " . ($index + 2) . ": " . implode(', ', $notFound);
            }
        }
    
        if (!empty($missingTreatments)) {
            throw ValidationException::withMessages([
                'file' => ['Terdapat treatment yang belum terdaftar:', ...$missingTreatments]
            ]);
        }
    
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                $packetName = trim($row['nama_paket']);
    
                if (Packet::where('name', $packetName)->exists()) {
                    continue;
                }
    
                $packet = Packet::create([
                    'name' => $packetName,
                    'packet_price' => $row['harga_normal'],
                    'member_price' => $row['harga_member'],
                ]);
    
                $treatmentNames = array_map('trim', explode(',', $row['treatments']));
                $treatmentIds = Treatment::whereIn('name', $treatmentNames)->pluck('id');
    
                $packet->treatments()->sync($treatmentIds);
            }
        });
    }
    

    public function uniqueBy()
    {
        return 'name';
    }
}
