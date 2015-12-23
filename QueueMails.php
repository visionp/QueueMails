<?php

namespace vision\queue_mails;

use Yii;
use yii\mail\BaseMailer;
use app\behaviors\UserIdCreatorBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "queue_mails".
 *
 * @property integer $id
 * @property string $email
 * @property string $subject
 * @property string $data
 * @property string $error
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class QueueMails extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 5;
    const STATUS_ERROR = 10;
    const STATUS_SENT = 15;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue_mails';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NEW],
            [['data', 'status'], 'required'],
            [['data', 'error'], 'string'],
            [['status', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['email', 'subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'subject' => 'Subject',
            'data' => 'Data',
            'error' => 'Error',
            'status' => 'Status',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function send(BaseMailer $mailer)
    {
        $status = false;
        try {
            $mail = $this->prepare($mailer);
            $status = $mail->send();
            if($status){
                $this->status = self::STATUS_SENT;
                $this->save();
            }
        } catch (\Exception $e) {
            $this->status = self::STATUS_ERROR;
            $this->error = $e->getMessage();
            $this->save();
        }
        return $status;
    }


    protected function prepare(BaseMailer $mailer)
    {
        $data = unserialize($this->data);

        $options = $data['options'];
        $methods = $data['methods'];

        if(isset($options['compose'])){
            $mail = $mailer->compose($options['compose']['view'], $options['compose']['params']);
            unset($options['compose']);
        } else {
            $mail = $mailer->compose();
        }

        foreach($methods as $method => $values){
            if(method_exists($mail, $method)){
                $mail->$method($values['value'], $values['options']);
            }
        }

        foreach($options as $option => $val){
            $method = 'set' . ucfirst($option);
            if(method_exists($mail, $method)){
                $mail->$method($val);
            }
        }

        return $mail;
    }
}
