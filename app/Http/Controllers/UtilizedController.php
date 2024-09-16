<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilizedResearch;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\Dropbox;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use App\Models\ActivityLog;

class UtilizedController extends Controller
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

        // Define the expected fields for UtilizedResearch
        $expectedFields = [
            'title_research_program',
            'title_research_project',
            'project_leader_staff',
            'campus_college',
            'date_started',
            'date_completed',
            'ifnt_cvsu_research_type',
            'beneficiary_industry',
            'product_name_method',
            'brief_desc',
            'patent_utility',
            'initial_date_utilization',
            'development',
            'service',
            'utilization_others',
        ];

        try {
            foreach ($data as $row) {
                // Ensure $row is an array
                if (!is_array($row)) {
                    Log::error('Expected array for row but got: ' . gettype($row));
                    continue;
                }

                // Check if the row contains all expected fields
                if (array_intersect($expectedFields, array_keys($row)) === $expectedFields) {
                    // Create or update the UtilizedResearch record
                    UtilizedResearch::updateOrCreate(
                        ['id' => $row['id'] ?? null],
                        [   
                            'title_research_program' => $row['title_research_program'] ?? '',
                            'title_research_project' => $row['title_research_project'] ?? '',
                            'project_leader_staff' => $row['project_leader_staff'] ?? '',
                            'campus_college' => $row['campus_college'] ?? '',
                            'date_started' => $row['date_started'] ?? null,
                            'date_completed' => $row['date_completed'] ?? null,
                            'ifnt_cvsu_research_type' => $row['ifnt_cvsu_research_type'] ?? '',
                            'beneficiary_industry' => $row['beneficiary_industry'] ?? '',
                            'product_name_method' => $row['product_name_method'] ?? '',
                            'brief_desc' => $row['brief_desc'] ?? '',
                            'patent_utility' => $row['patent_utility'] ?? '',
                            'initial_date_utilization' => $row['initial_date_utilization'] ?? null,
                            'development' => $row['development'] ?? '',
                            'service' => $row['service'] ?? '',
                            'utilization_others' => $row['utilization_others'] ?? '',
                            'user_id' => $userID,
                        ]
                    );
                } else {
                    Log::error('Row missing expected fields: ' . json_encode($row));
                }
            }

            // Trigger the export method after saving research records
            return $this->downloadUtilizedResearchExcelFile($data);
        } catch (\Exception $e) {
            Log::error('Error saving utilized research: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while saving the utilized research.');
        }
    }

    private function downloadUtilizedResearchExcelFile($data)
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
            $templateFilePath = public_path('template/utilized/MFO-and-KRA-DATA-FORM.xlsx');
            $destinationFilePath = $folderPath . '/MFO-and-KRA-DATA-FORM.xlsx';

            if (!copy($templateFilePath, $destinationFilePath)) {
                Log::error("Failed to copy template file to $destinationFilePath");
                return response()->json(['error' => 'Failed to copy template file'], 500);
            }
        }

        // Load the copied Excel file as a PhpSpreadsheet object
        $destinationFilePath = $folderPath . '/MFO-and-KRA-DATA-FORM.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($destinationFilePath);

        // Get the sheet named "Utilized Research"
        $sheet = $spreadsheet->getSheetByName('Utilized Research');
        if (!$sheet) {
            Log::error("Sheet 'Utilized Research' not found");
            return response()->json(['error' => 'Sheet not found']);
        }

        // Define the starting row and column index
        $startRow = 5;
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
                'ifnt_cvsu_research_type',
                'beneficiary_industry',
                'product_name_method',
                'brief_desc',
                'patent_utility',
                'initial_date_utilization',
                'development',
                'service',
                'utilization_others',
            ] as $field) {
                $cellCoordinate = $startColumn . $currentRow;
                $value = $row[$field] ?? '';

                // Write the cell value
                $sheet->setCellValue($cellCoordinate, $value);
                $startColumn++;
            }
            $currentRow++;
        }

        // Save the modified spreadsheet to a file in the user-specific folder
        $excelWriter = new Xlsx($spreadsheet);
        $excelFileName = 'Utilized_Research_Export_' . $timestamp . '.xlsx';
        $excelFilePath = $folderPath . '/' . $excelFileName;

        $excelWriter->save($excelFilePath);

        // Save the file path and other details to Dropbox model with relative path
        Dropbox::create([
            'title' => 'Utilized Research (' . strtoupper(Carbon::now()->format('M')) . ')',
            'user_id' => $userID,
            'file_path' => 'export_forms/' . $folderName . '/' . $excelFileName, // Relative path
            'status' => 'pending',
        ]);

        // Log the activity
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'sent a report named Utilized Research (' . strtoupper(Carbon::now()->format('M')) . ')',
        ]);

        // Notify the admin
        $admin = User::where('roles', 'admin')->first();
        if ($admin) {
            Notification::create([
                'sender_id' => $userID,
                'receiver_id' => $admin->id,
                'message' => 'sent a report named Utilized Research (' . strtoupper(Carbon::now()->format('M')) . ')',
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
