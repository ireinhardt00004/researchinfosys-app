<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchAward;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\Dropbox;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use App\Models\ActivityLog;

class ResearchAwardController extends Controller
{
    public function store(Request $request)
    {
        // Retrieve the data from the request
        $data = $request->input('table_data');
        
        // Debugging: Check the type and content of $data
        Log::info('Data received: ' . print_r($data, true));
        
        // Decode JSON if it's in JSON format
        if (is_string($data)) {
            $data = json_decode($data, true);
            
            // Check if JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decoding error: ' . json_last_error_msg());
                return redirect()->back()->withErrors('Invalid JSON format.');
            }
        }
        
        // Validate that $data is an array
        if (!is_array($data)) {
            Log::error('Expected array but got: ' . gettype($data));
            return redirect()->back()->withErrors('Invalid data format.');
        }
        
        $userID = auth()->user()->id;
    
        // Define the expected fields for the ResearchAward
        $expectedFields = [
            'title_research_program',
            'title_research_project',
            'project_leader_staff',
            'campus_college',
            'date_started',
            'date_completed',
            'research_title_award',
            'researcg_title_output',
            'researcher_award',
            'date_awarded_researcher',
            'venue',
            'awarding_body',
            'title_conference_symposium',
            'level',
        ];
    
        try {
            foreach ($data as $row) {
                // Ensure $row is an array
                if (!is_array($row)) {
                    Log::error('Expected array for row but got: ' . gettype($row));
                    continue;
                }
    
                // Log the current row data for debugging
                Log::info('Processing row: ' . json_encode($row));
                
                // Check if the row contains all expected fields
                $missingFields = array_diff($expectedFields, array_keys($row));
                if (empty($missingFields)) {
                    // Create or update the ResearchAward record
                    ResearchAward::updateOrCreate(
                        ['id' => $row['id'] ?? null],
                        [
                            'title_research_program' => $row['title_research_program'] ?? '',
                            'title_research_project' => $row['title_research_project'] ?? '',
                            'project_leader_staff' => $row['project_leader_staff'] ?? '',
                            'campus_college' => $row['campus_college'] ?? '',
                            'date_started' => $row['date_started'] ?? null,
                            'date_completed' => $row['date_completed'] ?? null,
                            'research_title_award' => $row['research_title_award'] ?? '',
                            'researcg_title_output' => $row['researcg_title_output'] ?? '',
                            'researcher_award' => $row['researcher_award'] ?? '',
                            'date_awarded_researcher' => $row['date_awarded_researcher'] ?? null,
                            'venue' => $row['venue'] ?? '',
                            'awarding_body' => $row['awarding_body'] ?? '',
                            'title_conference_symposium' => $row['title_conference_symposium'] ?? '',
                            'level' => $row['level'] ?? '',
                            'user_id' => $userID,
                        ]
                    );
                } else {
                    Log::error('Row missing expected fields: ' . json_encode($row) . ' Missing fields: ' . json_encode($missingFields));
                }
            }
    
            // Trigger the export method after saving research awards
            return $this->downloadResearchAwardExcelFile($data);
        } catch (\Exception $e) {
            Log::error('Error saving research awards: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while saving the research awards.');
        }
    }
    
    private function downloadResearchAwardExcelFile($data)
    {
        try {
            $user = auth()->user();
            $lname = $user->lname;
            $fname = $user->fname;
            $userID = $user->id;
            $timestamp = Carbon::now()->format('Ymd_His');
    
            // Folder name format: lname_fname_id_time_date
            $folderName = "{$lname}_{$fname}_{$userID}_{$timestamp}";
            $folderPath = public_path('export_forms/' . $folderName);
    
            // Check if the folder exists, if not create it
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true);
    
                // Copy the template file to the newly created folder
                $templateFilePath = public_path('template/research-award/MFO-and-KRA-DATA-FORM.xlsx');
                $destinationFilePath = $folderPath . '/MFO-and-KRA-DATA-FORM.xlsx';
    
                if (!copy($templateFilePath, $destinationFilePath)) {
                    Log::error("Failed to copy template file to $destinationFilePath");
                    return response()->json(['error' => 'Failed to copy template file'], 500);
                }
            }
    
            // Load the copied Excel file as a PhpSpreadsheet object
            $destinationFilePath = $folderPath . '/MFO-and-KRA-DATA-FORM.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($destinationFilePath);
    
            // Get the sheet named "Research Awards"
            $sheet = $spreadsheet->getSheetByName('Research Awards');
            if (!$sheet) {
                Log::error("Sheet 'Research Awards' not found");
                return response()->json(['error' => 'Sheet not found']);
            }
    
            // Define the starting row and column index
            $startRow = 6;
            $startColumn = 'B';
    
            // Write the data
            $currentRow = $startRow;
            foreach ($data as $row) {
                $startColumn = 'B';
                foreach ([
                    'title_research_program',
                    'title_research_project',
                    'project_leader_staff',
                    'campus_college',
                    'date_started',
                    'date_completed',
                    'research_title_award',
                    'research_title_output',
                    'researcher_award',
                    'date_awarded_researcher',
                    'venue',
                    'awarding_body',
                    'title_conference_symposium',
                    'level',
                ] as $field) {
                    $cellCoordinate = $startColumn . $currentRow;
                    $value = $row[$field] ?? '';
    
                    $sheet->setCellValue($cellCoordinate, $value);
                    $startColumn++;
                }
                $currentRow++;
            }
    
            // Save the modified spreadsheet to a file in the user-specific folder
            $excelWriter = new Xlsx($spreadsheet);
            $excelFileName = 'Research_Awards_Export_' . $timestamp . '.xlsx';
            $excelFilePath = $folderPath . '/' . $excelFileName;
    
            $excelWriter->save($excelFilePath);
    
            // Save the file path and other details to Dropbox model with relative path
            Dropbox::create([
                'title' => 'Research Awards (' . strtoupper(Carbon::now()->format('M')) . ')',
                'user_id' => $userID,
                'file_path' => 'export_forms/' . $folderName . '/' . $excelFileName, // Relative path
                'status' => 'pending',
            ]);
    
            // Log the activity
            ActivityLog::create([
                'user_id' => $userID,
                'activity' => 'sent a report named Research Awards (' . strtoupper(Carbon::now()->format('M')) . ')',
            ]);
    
            // Notify the admin
            $admin = User::where('roles', 'admin')->first();
            if ($admin) {
                Notification::create([
                    'sender_id' => $userID,
                    'receiver_id' => $admin->id,
                    'message' => 'sent a report named Research Awards (' . strtoupper(Carbon::now()->format('M')) . ')',
                    'is_read' => false,
                ]);
            }
    
            // Download the generated Excel file
            return response()->download($excelFilePath);
        } catch (\Throwable $e) {
            Log::error('Error exporting Excel file:', ['exception' => $e]);
            return response()->json(['error' => 'An error occurred while exporting the Excel file'], 500);
        }
    }
    
}
