<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    public function exportLogToExcel() {
        $userID = auth()->user()->id;
    
        // Fetch logs with associated user details for the authenticated user
        $logs = ActivityLog::where('user_id', $userID)->with('user')->latest()->get();
    
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set the header row
        $sheet->setCellValue('A1', 'Role');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Middle Name');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Activity');
        $sheet->setCellValue('F1', 'Timestamp');
        
        $row = 2;
        foreach ($logs as $log) {
            $user = $log->user;
            // Define $createdAt within the loop
            $createdAt = Carbon::parse($log->created_at)->format('F d, Y') . ' (' . Carbon::parse($log->created_at)->diffForHumans() . ')';
    
            // Set cell values
            $sheet->setCellValue('A' . $row, $user->role);  // Assuming 'role' is a field in the User model
            $sheet->setCellValue('B' . $row, $user->fname);
            $sheet->setCellValue('C' . $row, $user->middlename);
            $sheet->setCellValue('D' . $row, $user->lname);
            $sheet->setCellValue('E' . $row, $log->activity);
            $sheet->setCellValue('F' . $row, $createdAt);
            
            $row++;
        }
    
        // Write the spreadsheet to a PHP output stream
        $writer = new Xlsx($spreadsheet);
    
        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });
    
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="my-activity-log.xlsx"');
    
        return $response;
    }
    
    public function exportToExcel() {
        // Fetch all logs with associated user details
        $logs = ActivityLog::with('user')->latest()->get();
    
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set the header row
        $sheet->setCellValue('A1', 'Role');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Middle Name');
        $sheet->setCellValue('D1', 'Last Name');
        $sheet->setCellValue('E1', 'Activity');
        $sheet->setCellValue('F1', 'Timestamp');
        
        $row = 2;
        foreach ($logs as $log) {
            $user = $log->user;
            // Define $createdAt within the loop
            $createdAt = Carbon::parse($log->created_at)->format('F d, Y') . ' (' . Carbon::parse($log->created_at)->diffForHumans() . ')';
            
            $sheet->setCellValue('A' . $row, $user->roles); 
            $sheet->setCellValue('B' . $row, $user->fname);
            $sheet->setCellValue('C' . $row, $user->middlename);
            $sheet->setCellValue('D' . $row, $user->lname);
            $sheet->setCellValue('E' . $row, $log->activity);
            $sheet->setCellValue('F' . $row, $createdAt);
            
            $row++;
        }
    
        // Write the spreadsheet to a PHP output stream
        $writer = new Xlsx($spreadsheet);
    
        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });
    
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="all-activity-log.xlsx"');
    
        return $response;
    }
    

    public function index() {
        $userID = auth()->user()->id;
        $logs = ActivityLog::where('user_id', $userID)->latest()->get();
        $userData = $logs->map(function ($log) {
            $createdAt = Carbon::parse($log->created_at);
            return [
                'activity' => $log->activity,
                'timestamp' => $createdAt->format('F d, Y') . ' (' . $createdAt->diffForHumans() . ')',
                'actions' => '          
                 <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="deleteActivity(' . $log->id . ')"><i class="fa-solid fa-trash"></i></button>
                  ',
            ];
        });
        return view('activity-log.index', ['users' => $userData]);
    }

    public function destroy($id) {
        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->delete();
        return response()->json(['status' => 'success']);
    }

    public function adminLog() {
        $authUser = auth()->user();
        if ($authUser->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $logs = ActivityLog::with('user')->latest()->get();
        $userData = $logs->map(function ($log) {
            $createdAt = Carbon::parse($log->created_at);
            return [
                'roles' => $log->user->roles,
                'fullname' => $log->user->fname . ' ' . $log->user->middlename . ' ' . $log->user->lname,
                'activity' => $log->activity,
                'timestamp' => $createdAt->format('F d, Y') . ' (' . $createdAt->diffForHumans() . ')',
                'actions' => '          
                 <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="deleteActivity(' . $log->id . ')"><i class="fa-solid fa-trash"></i></button>
                  ',
            ];
        });
        return view('activity-log.all-log', ['users' => $userData]);
    }
}
