<?php

namespace App\Services\Participant;

use Hashids\Hashids;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;
use App\Imports\ParticipantImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\ParticipantResource;

class SaveClass
{
     public function update($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);

        $data = Participant::with('detail')->where('id',$id[0])->first();
        $data->update($request->all());
        $data->detail()->update($request->except('firstname','middlename','lastname','suffix','email','contact_no','option','id'));
       
        return [
            'data' => new ParticipantResource($data->refresh()),
            'message' => 'Participant update was successful!', 
            'info' => "You've successfully updated the selected user."
        ];
    }

    public function preview($request){
        $data =  Excel::toCollection(new ParticipantImport,$request->import_file);
       
        $rows = $data[0]; 
        foreach($rows as $row){ 
            if($row[0] != 'Timestamp'){
                $fullName =  $row[6];
                $nameParts = array_filter(explode(' ', trim($fullName))); // Split and remove empty spaces
                $count = count($nameParts);

                if ($count === 4) {
                    $firstName = $nameParts[0] . ' ' . $nameParts[1]; // First two words
                    $middleName = $nameParts[2];                     // Third word
                    $lastName = $nameParts[3];                       // Last word
                } else {
                    $firstName = $nameParts[0] ?? null;             // First word
                    $lastName = $nameParts[$count - 1] ?? null;     // Last word
                    $middleName = $count > 2 ? implode(' ', array_slice($nameParts, 1, $count - 2)) : null; // Middle words
                }

                switch($row[2]){
                    case 'Resource Speaker':
                        $type = 14;
                    break;
                    case 'Exhibitor':
                        $type = 15;
                    break;
                    case 'Participant':
                        $type = 16;
                    break;
                    case 'Organizer':
                        $type = 15;
                    break;
                }

                switch($row[9]){
                    case 'Male':
                        $sex = 2;
                    break;
                    case 'Female':
                        $sex = 3;
                    break;
                    case 'LGBT-Transwoman':
                        $sex = 2;
                    break;
                }

                $information[] = [
                    'type_id' => $type,
                    'email' => $row[1],
                    'contact_no' => $row[11],
                    'firstname' => $firstName,
                    'middlename' => $middleName,
                    'lastname' => $lastName,
                    'affiliation' => $row[7],
                    'designation' => $row[8],
                    'sex_id' => $sex,
                ];
            }
        }
        return $information;
    }

    public function upload($request){
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $results = [
            'success' => [],
            'failed' => [],
            'duplicate' => []
        ];
        $index= 0;
        $rows = $request->lists;

        foreach ($rows as $index => $row) {
            $type_id = $row['type_id'];
            $email = $row['email'];
            $contact_no = $row['contact_no'];
            $firstname = $row['firstname'];
            $middlename = $row['middlename'];
            $lastname = $row['lastname'];
            $affiliation = $row['affiliation'];
            $designation = $row['designation'];
            $sex_id = $row['sex_id'];

            try {
                $email_hash = hash('sha256', strtolower($email));
                $existing = Participant::where('email_hash',$email_hash)->first();

                if ($existing) {
                    $results['duplicate'][] = [
                        'row' => $index + 1,
                        'data' => $email,
                    ];
                    continue;
                }

                DB::beginTransaction();

                $participant = Participant::create([
                    'code' => $this->generateCode(),
                    'email' => $email,
                    'contact_no' => $contact_no,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                ]);
                if (! $participant) {
                    throw new \Exception('Failed to create participant record.');
                }

                $detail = $participant->detail()->create([
                    'affiliation' => $affiliation,
                    'designation' => $designation,
                    'sex_id' => $sex_id,   
                    'type_id' => $type_id
                ]);

                if (! $detail) {
                    throw new \Exception('Failed to create participant detail.');
                }

                DB::commit();

                $results['success'][] = [
                    'row' => $index + 1,
                    'data' => '-',
                ];

            } catch (\Exception $e) {
                DB::rollBack();
                $results['failed'][] = [
                    'row' => $index + 1,
                    'data' => $email,
                    'error' => $e->getMessage(),
                ];
            }
        }
    
        return $results;
    }

     private function generateCode(){
        $count = Participant::count();
        $code = 'DOSTIX-'.date('m').date('Y').'-R9-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
