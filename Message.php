<?php
/**
 * Created by PhpStorm.
 * User: Vision
 * Date: 23.12.2015
 * Time: 12:11
 */

namespace vision\queue_mails;

use Yii;
use  yii\mail\BaseMessage;
use  yii\mail\MailerInterface;

class Message extends BaseMessage
{

    protected $options = [];
    protected $methods = [];

    /**
     * Returns the character set of this message.
     * @return string the character set of this message.
     */
    public function getCharset()
    {
        return $this->param('charset');
    }

    /**
     * Sets the character set of this message.
     * @param string $charset character set name.
     * @return $this self reference.
     */
    public function setCharset($charset)
    {
        return $this->param('charset', $charset);
    }


    public function setCompose($view = null, array $params = [])
    {
        $this->actions('compose', ['view' => $view, 'params' => $params]);
    }

    /**
     * Returns the message sender.
     * @return string the sender
     */
    public function getFrom()
    {
        return $this->param('from');
    }

    /**
     * Sets the message sender.
     * @param string|array $from sender email address.
     * You may pass an array of addresses if this message is from multiple people.
     * You may also specify sender name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setFrom($from)
    {
        return $this->param('from', $from);
    }

    /**
     * Returns the message recipient(s).
     * @return array the message recipients
     */
    public function getTo()
    {
        $to = $this->param('to');
        if(is_array($to)){
            return  implode(', ', $to);
        }
        return $to;
    }

    /**
     * Sets the message recipient(s).
     * @param string|array $to receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setTo($to)
    {
        return $this->param('to', $to);
    }

    /**
     * Returns the reply-to address of this message.
     * @return string the reply-to address of this message.
     */
    public function getReplyTo()
    {
        return $this->param('replyTo');
    }

    /**
     * Sets the reply-to address of this message.
     * @param string|array $replyTo the reply-to address.
     * You may pass an array of addresses if this message should be replied to multiple people.
     * You may also specify reply-to name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setReplyTo($replyTo)
    {
        return $this->param('replyTo', $replyTo);
    }

    /**
     * Returns the Cc (additional copy receiver) addresses of this message.
     * @return array the Cc (additional copy receiver) addresses of this message.
     */
    public function getCc()
    {
        return $this->param('cc');
    }

    /**
     * Sets the Cc (additional copy receiver) addresses of this message.
     * @param string|array $cc copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setCc($cc)
    {
        return $this->param('cc', $cc);
    }

    /**
     * Returns the Bcc (hidden copy receiver) addresses of this message.
     * @return array the Bcc (hidden copy receiver) addresses of this message.
     */
    public function getBcc()
    {
        return $this->param('bcc');
    }

    /**
     * Sets the Bcc (hidden copy receiver) addresses of this message.
     * @param string|array $bcc hidden copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setBcc($bcc)
    {
        return $this->param('bcc', $bcc);
    }

    /**
     * Returns the message subject.
     * @return string the message subject
     */
    public function getSubject()
    {
        return $this->param('subject');
    }

    /**
     * Sets the message subject.
     * @param string $subject message subject
     * @return $this self reference.
     */
    public function setSubject($subject)
    {
        return $this->param('subject', $subject);
    }

    /**
     * Sets message plain text content.
     * @param string $text message plain text content.
     * @return $this self reference.
     */
    public function setTextBody($text)
    {
        return $this->param('textBody', $text);
    }

    /**
     * Sets message HTML content.
     * @param string $html message HTML content.
     * @return $this self reference.
     */
    public function setHtmlBody($html)
    {
        return $this->param('htmlBody', $html);
    }

    /**
     * Attaches existing file to the email message.
     * @param string $fileName full file name
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attach($fileName, array $options = [])
    {
        $this->actions('attach', ['value' => $fileName, 'options' => $options]);
    }

    /**
     * Attach specified content as file for the email message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attachContent($content, array $options = [])
    {
        $this->actions('attach_content', ['value' => $content, 'options' => $options]);
    }

    /**
     * Attach a file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $fileName file name.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embed($fileName, array $options = [])
    {
        $this->actions('embed', ['value' => $fileName, 'options' => $options]);
    }

    /**
     * Attach a content as file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embedContent($content, array $options = [])
    {
        $this->actions('embedContent', ['value' => $content, 'options' => $options]);
    }

    /**
     * Sends this email message.
     * @param MailerInterface $mailer the mailer that should be used to send this message.
     * If null, the "mail" application component will be used instead.
     * @return boolean whether this message is sent successfully.
     */
    public function send(MailerInterface $mailer = null)
    {
        $data['options'] = $this->options;
        $data['methods'] = $this->methods;

        $model = new QueueMails();

        $model->data = serialize($data);
        $model->email = $this->getTo();
        $model->subject = $this->getSubject();
        $model->user_id = Yii::$app->user->isGuest ? '' : Yii::$app->user->id;

        return $model->save();
    }


    /**
     * Returns string representation of this message.
     * @return string the string representation of this message.
     */
    public function toString()
    {

    }

    protected function param($name, $value = null)
    {
        if($value !== null){
            $this->options[$name] = $value;
            return $this;
        } else {
            return isset($this->options[$name]) ? $this->options[$name] : null;
        }
    }

    protected function actions($name, $params = null)
    {
        $this->methods[$name] = $params;
    }

}