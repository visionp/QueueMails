QueueMails
================
QueueMails


Installation
-----------

The preferred way to install this extension is through composer.

Either run

```
php composer.phar require --prefer-dist vision/yii2-private-messages "@dev"
```

or add to the require section of your composer.json file.

```
"vision/yii2-queue-mails":"@dev"
```

Configuration
-----
Once the extension is installed, add following code to your application configuration :

 ```
        'mailer' => [
            'class' => 'vision\queue_mails\Mailer',
            'mailsPerRound' => 5,
            'realMailer' => [
                'class' => '****',
                'apikey' => '*****'
            ]
        ],
  ```
  
  and /config/console.php:
  
   ```
          'mailer' => [
              'class' => 'vision\queue_mails\Mailer',
              'mailsPerRound' => 5,
              'realMailer' => [
                  'class' => '****',
                  'apikey' => '*****'
              ]
          ],
    ```
  
  Following properties are available for customizing the mail queue behavior.
  
  mailsPerRound: Number of emails to send at a time.
  

Run yii migrate command in command line:

yii migrate --migrationPath=@vendor/vision/queue-mails/migrations

Processing the mail queue
-----

Now calling Yii::$app->mailqueue->process() will process the message queue and send out the emails. 
In one of your controller actions:

```
public function actionSend()
{
    Yii::$app->mailqueue->process();
}
```

Most preferably this could be a console command (eg: mail/send) which can be triggered by a CRON job.
-----

Setting the CRON job

Set a CRON job to run console command:

 ```
    */10 * * * * php /var/www/html/myapp/yii mail/send
 ```
 
 Usage
 -----
 Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
     ->setFrom('from@domain.com')
     ->setTo($form->email)
     ->setSubject($form->subject)
     ->send();

