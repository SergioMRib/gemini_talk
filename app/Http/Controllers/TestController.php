<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;

class TestController extends Controller
{
    public function store()
    {
        $client = new Client();
        $client->setApplicationName('Your Application Name');
        $client->setAuthConfig(storage_path('app/service-account.json')); // Path to your JSON key
        $client->addScope(Calendar::CALENDAR_EVENTS);

        $service = new Calendar($client);

        // Example event
        $event = new \Google\Service\Calendar\Event([
            'summary' => 'Test Event from Service Account',
            'description' => 'This is a test event created using a service account.',
            'start' => [
                'dateTime' => now()->addHours(1)->format('c'),
                'timeZone' => 'Europe/Lisbon', // Replace with your time zone
            ],
            'end' => [
                'dateTime' => now()->addHours(2)->format('c'),
                'timeZone' => 'Europe/Lisbon',
            ],
        ]);

        $calendarId = 'sergio.m.rib@gmail.com'; // Or the calendar ID you want to use
        $event = $service->events->insert($calendarId, $event);

        return 'Event created: ' . $event->getHtmlLink();
    }
}
