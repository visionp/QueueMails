<?php
/**
 * Created by PhpStorm.
 * User: VisioN
 * Date: 21.12.2015
 * Time: 17:26
 */

namespace vision\queue_mails;

use Yii;
use yii\base\InvalidConfigException;
use yii\mail\BaseMailer;

class Mailer extends BaseMailer {

    const LOG_ERROR = 'queue_error';

    public $realMailer = [];

    /**
     * Number of letters for the attempted
     * @var int
     */
    public $mailsPerRound = 5;


    /**
     * @var string the default class name of the new message instances created by [[createMessage()]]
     */
    public $messageClass = 'vision\queue_mails\Message';


    /**
     * @return bool
     * @throws InvalidConfigException
     */
    public function process()
    {
        $mailer = $this->getMailer();
        $items = QueueMails::find()->where(['!=', 'status', QueueMails::STATUS_SENT])->limit($this->mailsPerRound)->orderBy('id DESC')->all();
        $valid = true;

        foreach($items as $item){
            $valid = $valid && $item->send($mailer);
        }
        return $valid;
    }


    /**
     * @return object
     * @throws InvalidConfigException
     */
    protected function getMailer()
    {
        $config = $this->realMailer;
        if (!array_key_exists('class', $config)) {
            throw new InvalidConfigException('You must set class for realMailer');
        }

        return Yii::createObject($config);
    }


    /**
     * Sends the specified message.
     *
     * @param Message $message the message to be sent
     * @return boolean whether the message is sent successfully
     */
    protected function sendMessage($message)
    {
        try {
            return $message->send();
        } catch (\Exception $e) {
            \Yii::error('A queue error occurred: ' . get_class($e) . ' - ' . $e->getMessage(), self::LOG_ERROR);
            return false;
        }
    }


}