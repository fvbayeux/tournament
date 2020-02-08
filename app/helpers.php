<?php

if (!function_exists('safeBroadcast')) {
    function safeBroadcast($event)
    {
        try {
            broadcast($event);
        } catch (\Illuminate\Broadcasting\BroadcastException $e) {
            Log::error('Failed to broadcast :' . $e->getMessage());
        }
    }
}