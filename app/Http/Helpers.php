<?php

namespace App\Http;

class Helper{
    public static function sendNotification()
    {
        $serverKey = 'AAAAwjdLfl0:APA91bFj3Hp9dv3ZBVrR5hfWM9_s3YPCZiiwxMHoDzmXt1o-RhwEojWyvDrsGqNM69jO4QToiMzSWdZVxWFfzpWFh1NH26mP-kdZrxhLv6DPcd8j8OBpS8PZEv66rF7XUBZ9JVh_4fqh'; 
        $deviceTokens = [$deviceTokenProvider,$deviceTokenUser];

        $message = [
                'data' => [
                
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'city_name' => $request->input('city_name'),
                'city_id' =>  $request->input('city_id'),
                'screen' => 'PropertyDetails',
                'name' => $request->input('property_name'),
                'property_id' => $request->input('property_id'),
            ],
        ];
        $client = new Client();

        foreach ($deviceTokens as $key=>$deviceToken) {
            $message['to'] = $deviceToken;
            
            if($key == 0){
                $name =  $userName->name == null ? 'user' : (string) $userName->name;
                $message['notification'] = [
                'title' => 'Booked Successfully',
                'body' => 'Your property '.$request->input('property_name'). ' has been booked by '.$name
            ];
            $notification                 = new  Notification;  
            $notification->order_id       = $order->id; 
            $notification->city_id       = $request->input('city_id'); 
            $notification->property_id       = $request->input('property_id'); 
            
            $notification->user_id        = $provider_id;
            $notification->title       = "Stayzy";
            $notification->message     =  'Your property '.$request->input('property_name'). ' has been booked by '.$name;
            $notification->click_action  = 'FLUTTER_NOTIFICATION_CLICK';
            $notification->created_at   = Carbon::now();
            $notification->updated_at   = Carbon::now();
            $notification->save();
            }else{
                $message['notification'] = [
                'title' => 'Booked Successfully',
                'body' => 'You have successfully booked this '.$request->input('property_name'),
            ];
             $notification                 = new  Notification;  
            $notification->order_id       = $order->id; 
            $notification->city_id       = $request->input('city_id'); 
            $notification->property_id       = $request->input('property_id'); 
            
            $notification->user_id        = $user_id;
            $notification->title       = "Stayzy";
            $notification->message     = 'You have successfully booked this '.$request->input('property_name');
            $notification->click_action  = 'FLUTTER_NOTIFICATION_CLICK';
            $notification->created_at   = Carbon::now();
            $notification->updated_at   = Carbon::now();
            $notification->save();
            }
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'key=' . $serverKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $message,
            ]);
        }
    }
}
?>