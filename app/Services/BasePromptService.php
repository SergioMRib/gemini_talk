<?php

namespace App\Services;

class BasePromptService
{

    /**
     * Returns the base prompt
     *
     */
    public function getPrompt()
    {
        $currentDateTime = now();

        $text = 'My current app receives a user text input and it should respond with whether it is a calendar event or a note.
If it is a calendar event, consider today\'s datetime ${currentDateTime}, responde with:
 - title,
 - description,
 - startAt: use ISO datetime format for this,
 - endAt: if absent from user input default to 1h duration, use ISO datetime format,
If it is a note responde with:
 - title,
 - description;

If you think it should be neither (like a question, or an order of some sort) respond with a json with "type": "invalid".
the response MUST:
 - be a valid json
 - No text before or after, only json.
 - must start with an openning curly brace and end with a closing curly brace, because my system will parse and store the info you provide.

#Scenario A:
Calendar event json example:
{
  "type": "event",
  "title": "Team Meeting",
  "description": "Monthly meeting to discuss project updates and future tasks.",
  "dateTime": "2025-03-15T10:00:00Z"
}

User input exmaple for valid calendar events:
"Create an event on sunday for lunch with friends at 12h at Pizzaria Riviera"
"Meet my boss for a quick meeting on zoom, two days from now, 10am"
"Call my friend Albert in 1h"

#Scenario B
Note json example:
{
  "type": "note",
  "title": "Meeting Notes",
  "description": "Summary of key points discussed in the meeting."
}

User input example for valid notes:
"I use phare.com for uptime monitor of my apps"
"There is a hobbit fan made version that I want to watch"
"Do not stay up late"

#Scenario C
Invalid json example:
{
  "type": "invalid",
}

User input for invalid types:
"What should be the correct amount of sugar for a good coffee?"
"Tell me what is an Enneagram."
"gergefebfe kesfjsjf lksefekfj"

IMPORTANT: only output the json.

Here is the user input:
 ';

$text = "My current app receives a user text input and it should respond with whether it is a calendar event or a note.
If it is a calendar event, consider today's datetime $currentDateTime, responde with:
 - title,
 - description,
 - startAt: use ISO datetime format for this,
 - endAt: if absent from user input default to 1h duration, use ISO datetime format,
If it is a note responde with:
 - title,
 - description;

If you think it should be neither (like a question, or an order of some sort) respond with a json with \"type\": \"invalid\".
the response MUST:
 - be a valid json
 - No text before or after, only json.
 - must start with an openning curly brace and end with a closing curly brace, because my system will parse and store the info you provide.

#Scenario A:
Calendar event json example:
{
  \"type\": \"event\",
  \"title\": \"Team Meeting\",
  \"description\": \"Monthly meeting to discuss project updates and future tasks.\",
  \"dateTime\": \"2025-03-15T10:00:00Z\"
}

User input exmaple for valid calendar events:
\"Create an event on sunday for lunch with friends at 12h at Pizzaria Riviera\"
\"Meet my boss for a quick meeting on zoom, two days from now, 10am\"
\"Call my friend Albert in 1h\"

#Scenario B
Note json example:
{
  \"type\": \"note\",
  \"title\": \"Meeting Notes\",
  \"description\": \"Summary of key points discussed in the meeting.\"
}

User input example for valid notes:
\"I use phare.com for uptime monitor of my apps\"
\"There is a hobbit fan made version that I want to watch\"
\"Do not stay up late\"

#Scenario C
Invalid json example:
{
  \"type\": \"invalid\",
}

User input for invalid types:
\"What should be the correct amount of sugar for a good coffee?\"
\"Tell me what is an Enneagram.\"
\"gergefebfe kesfjsjf lksefekfj\"

IMPORTANT: only output the json.

Here is the user input:
 ";

        return $text;
    }
}

