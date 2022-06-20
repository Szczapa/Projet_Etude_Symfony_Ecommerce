<?php

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client('31ef18dd0f93b2d93654d535e9027e21', '6555dd2a5ffea8587594b12db2f6f83f', true, ['version' => 'v3.1']);

        $body = [
        'Messages' => [
        [
        'From' => [
          'Email' => "adam.gilabert@gt2sformation.fr",
          'Name' => "AFCI MEgacenter"
        ],
        'To' => [
          [
            'Email' => $to_email,
            'Name' => $to_name
          ]
        ],
            'TemplateID' => 4004590,
            'TemplateLanguage' => true,
            'Subject' => $subject,
            'Variables' => [
                'content' => $content,
            ]
        ]
        ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && $response->getData();
    }
}
