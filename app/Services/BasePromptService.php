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


    public function buildPromptTellMeGemini(Array $notes, Array $events, Array $files, string $question) {

        $currentDateTime = now();
        $events_json = json_encode($events);
        $notes_json = json_encode($notes);
        $files_json = json_encode($files);

        $text = "You are my second brain. I am about to send all data from notes, events, and pdf files (name and summary) that I have in my system. Then I'll send a question.
    Your job is to read the question and see if any of that information relates to the question. Based on that you will come up with an answer to the question however you see fit but it should be as usefull as possible. In case of pdf files, state the name of the file as I'll be downloading it.
For the purpose of this interaction, any additional info that you possess (namely the info used to train you) outside of the provided info is to beignored.
For any date related question, today is exactly: $currentDateTime, but if the current time is before 3am consider all relative time words ( such as tomorrow, yesterday, in two days, etc) as possibly referring to the current day or the next day (as I may be asking before going to sleep).
Notes, events and files come right next. They are in json format after json_encode.

-- Events --
$events_json

-- Notes --
$notes_json

-- Files --
$files_json

-- The question I'm sending --
$question
";


        return $text;
    }

    public function buildPromptForFileProcessing()
    {
        $text = "I'm sending an image. Take look at it and come up with a max 4 word name and a max 1000 char summary. responde with a json format like this:
{\"name\": \"Example Name\", \"summary\": \"This is a sample summary.\"}";

        return $text;
    }

    public function buildPromptForPdfProcessing( String $pdfContent )
    {
        $text = "I'm sending a text that is the pdf text content. Take a look at it and come up with a max 4 word name and a max 1000 char summary. responde with a json format like this:
{\"name\": \"Example Name\", \"summary\": \"This is a sample summary.\"}
Here the text goes: " . $pdfContent;

        return $text;
    }
}

