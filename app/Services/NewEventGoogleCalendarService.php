<?php

namespace App\Services;


use Google\Client;
use Google\Service\Calendar;


class NewEventGoogleCalendarService
{

    /**
     * Create a new event in google calendar
     *
     * @param string $text
     * @return url
     */
    public function createEvent(string $summary, string $description, string $start, string $end)
    {

        $client = new Client();
        $client->setApplicationName('Gemini Laravel app');
        $client->setAuthConfig(storage_path('app/service-account.json')); // Path to your JSON key
        $client->addScope(Calendar::CALENDAR_EVENTS);

        $service = new Calendar($client);

        // Example event
        $event = new \Google\Service\Calendar\Event([
            'summary' => $summary,
            'description' => $description,
            'start' => [
                'dateTime' => $start,
                'timeZone' => 'UTC', // Replace with your time zone
            ],
            'end' => [
                'dateTime' => $end,
                'timeZone' => 'UTC',
            ],
        ]);

        $calendarId = 'sergio.m.rib@gmail.com'; // Or the calendar ID you want to use
        $event = $service->events->insert($calendarId, $event);

        return $event->getHtmlLink();
    }
}

