<?php
namespace App\Http\Controllers\API;

use App\Models\EMPL;
use App\Models\Employee;

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

    public function index()
    {
        $push_notifications = PushNotification::orderBy('created_at', 'desc')->get();
        return response()->json($push_notifications, 200);
     }
     public static function bulksend($title, $body, $img, $id)
    {
    $user = auth()->user()->emp_id;

    $employee = EMPL::where('emp_id', $user)->first();
 
    $comment = new PushNotification();
    $comment->title = $title;
    $comment->body = $body;
    $comment->image = $img;
    $comment->receiver_emp_id=$id;
    $comment->sender_emp_id=$user;
    $comment->save();

    $fcmServerKey = 'AAAAOqacTg8:APA91bHAbmLdf_oh9Wr_DaHhvznWVB4uLDloVvq0RKRfzXmXFlYSCX4ecsm4Dkb656XRo7PBa1mrkHkrQ1w9sfLsnni-y_KNYe-F7T9GeiIhC5qCg-3r1jwJLk8Z4xz5kvEK3VLOBzoQ';

    $deviceTokens = [$employee->device_token];

    $notification = [
        'title' => $title,
        'body' => $body,
        'image' => $img,
        'sound' => 'default',
        'badge' => '1',
    ];

    $data = [
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
        'id' => $id,
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

    return response()->json([
        'msg' => 'Notification sent successfully',
        'result' => $result
    ], 200);
}

//     public static function bulksend(Request $req)
//     {
//         $user = auth()->user()->emp_id;

//     //   $deviceToken = $request->input('device_token');

//      //   $employee = Employee::find($employeeId);
//      $employee = EMPL::where('emp_id', $user)->first();

//         $comment = new PushNotification();
//         $comment->title = $req->input('title');
//         $comment->body = $req->input('body');
//         $comment->image = $req->input('img');
//         $comment->save();


//         // Construct FCM payload
//        // $fcmServerKey = config('app.fcm_server_key');
//       // $employee = Employee::find($employeeId);
//        $fcmServerKey='AAAAOqacTg8:APA91bHAbmLdf_oh9Wr_DaHhvznWVB4uLDloVvq0RKRfzXmXFlYSCX4ecsm4Dkb656XRo7PBa1mrkHkrQ1w9sfLsnni-y_KNYe-F7T9GeiIhC5qCg-3r1jwJLk8Z4xz5kvEK3VLOBzoQ';
//       //  $deviceTokens = ['e2-zE6WPRPGLXpcI52ptwh:APA91bH8aGxf6RG7Tjw4XJeQA141K6RpEsxqi4zoV2q-pDSqUf3-suNim9fZQYMlJi0JyFRnEmtgZ7L-MGJOSbTbMwE0F807Tqr4kxUFtLJOPeYLKpppgjwcvwRTGWvnccl2ZtqSbdCH']; // Replace with actual device tokens
// $deviceTokens=[$employee->device_token];
//         $notification = [
//             'title' => $req->title,
//             'body' => $req->body,
//             'image' => $req->img,
//             'sound' => 'default',
//             'badge' => '1',
//         ];

//         $data = [
//             'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
//             'id' => $req->id,
//             'status' => 'done',
//         ];

//         $payload = [
//             'registration_ids' => $deviceTokens,
//             'notification' => $notification,
//             'data' => $data,
//             'priority' => 'high',
//         ];

//         $headers = [
//             'Authorization: key=' . $fcmServerKey,
//             'Content-Type: application/json',
//         ];

//         // Send FCM request
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
//         $result = curl_exec($ch);
//         curl_close($ch);

//         return response()->json([
//             'msg' => 'Notification sent successfully',
//             "result"=>$result
//         ], 200);
//     }


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
        PushNotificationController::bulksend("Testing Notification",
        "Your Leave request is successful granted",
      "",$user);
    }

    public function destroy(PushNotification $pushNotification)
    {
        //
    }
}
