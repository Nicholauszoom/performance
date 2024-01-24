<?php
namespace App\Http\Controllers\API;

use App\Models\EMPL;
use App\Models\Employee;
use App\Models\NotificationTitle;

use Illuminate\Http\Request;
use App\Models\PushNotification;
use Illuminate\Routing\Controller;

class PushNotificationController extends Controller
{
    //  protected $email_data;
    // protected $data;    
    public function __construct()
    {
        //
        // $this->data = $email_data;
    }

  
    public static function bulksend($params)
    {
        try {
            $user = auth()->user()->emp_id;
    
            $employee = EMPL::where('emp_id', $params['id'])->first();
    
            $comment = new PushNotification();
            $comment->title = $params['title'] ?? null;
            $comment->body = $params['body'] ?? null;
            $comment->image= $params['img'] ?? null;
            $comment->receiver_emp_id = $params['id'] ?? null;
            $comment->leave_id = $params['leave_id'] ?? null;
            $comment->overtime_id = $params['overtime_id'] ?? null;
            $comment->sender_emp_id=$user;
            $comment->save();

            $fcmServerKey = env('FCM_SERVER_KEY');
           

    $deviceTokens = [$employee->device_token];
    $new_title= NotificationTitle::where('id',$comment->title)->get()->first();
  
    $notification = [
        'title' => $new_title->title,
        'body' => $params['body'] ,
        'image' =>  '',
        'sound' => 'default',
        'badge' => '1',
    ];
  
    $data = [
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        'id' =>   $comment->id,
        'status' => 'done',
    ];

    $payload = [
        'registration_ids' => $deviceTokens,
        'notification' => $notification,
        'data' => $data,
        'priority' => 'high',
    ];

    $headers = [
        'Authorization: key=' . $fcmServerKey,
        'Content-Type: application/json',
    ];
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $result = curl_exec($ch);
    curl_close($ch);
   
            return response([
                'msg' => 'Notification sent successfully',
                'result' => $result
            ], 200);
        } catch (\Exception $e) {
            // Handle the exception here
            return response([
                'error' => 'Failed to send notification',
                'message' => $e->getMessage(), // Include the error message if needed for debugging
            ], 500); // Use appropriate HTTP status code based on the error
        }
       
    }
    
    public function updateDeviceToken(Request $request,)
    {
        $user = auth()->user()->emp_id;

        $deviceToken = $request->input('device_token');

     //   $employee = Employee::find($employeeId);
     $employee = EMPL::where('emp_id', $user)->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee not found',$employee], 404);
        }

        if (!$employee->device_token) {
            // If device token doesn't exist, insert it
            $employee->device_token = $deviceToken;
            $employee->save();
            return response()->json(['message' => 'Device token inserted successfully'], 200);
        } elseif ($employee->device_token !== $deviceToken) {
            // Update the device token only if it's different
            $employee->device_token = $deviceToken;
            $employee->save();
            return response()->json(['message' => 'Device token updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Device token already exists and matches'], 200);
        }
    }

    public function test()
    {
        $user = auth()->user()->emp_id;
        PushNotificationController::bulksend([
            'title' => '3',
            'body' =>'Your leave request is successful approved',
            'img' => '',
            'id' => '100281',
            'leave_id' => '',
            'overtime_id' => '',
           
            ]);
          
    }
    public function updateNotification(Request $request){
       try{
        $user = auth()->user()->emp_id;
        $id = $request->id;

        $push_notifications =  PushNotification::where('receiver_emp_id',$user)->get();

        $comment =  PushNotification::where('receiver_emp_id',$user)->where('id',$id)->get()->first();
    
        $comment->status=1;
       
        $comment->save();
        return response(["msg"=>"successful updated"],200);
       }
       catch(Exception $e){
        return response(["msg"=>"Failed".$e],400);
       }

        // dd(PushNotification::where('receiver_emp_id',$user)->orderBy('created_at','desc')->get());
    }
    public function getNotifications()
    {
        $pushNotifications = PushNotification::orderBy('created_at', 'desc')
            ->where('receiver_emp_id', auth()->user()->emp_id)
            ->get();
                 
        foreach ($pushNotifications as $key => $notification) { 
            $slipArray = json_decode(json_encode($notification), true);
            $titles = NotificationTitle::where('id', $notification->title)->get();
    
            foreach ($titles as $title) {
                $slipArray['title_name'] = $title['title'];
            }
    
            $pushNotifications[$key] = (array) $slipArray; // Update the specific element in $pushNotifications
        }
    
        return response()->json($pushNotifications, 200);
    }
    

     public function getNotificationTitles()
     {
         $push_notifications=NotificationTitle::get();
         return response()->json($push_notifications, 200);
      }

      public function deleteNotification(Request $request)
      {
          $user = auth()->user()->emp_id;
          $notifications = $request->notification;
          $allNotFound = true;
      
          foreach ($notifications as $item) {
              $comment = PushNotification::where('receiver_emp_id', $user)->where('id', $item)->first();
      
              if ($comment) {
                  $comment->delete();
                  $allNotFound = false; // Set flag to false if at least one notification is found
              }
          }
      
          if ($allNotFound) {
              return response(['msg' => "None of the notifications exist"], 404);
          }
      
          return response(['msg' => "Successful"], 200);
      }
      
}
