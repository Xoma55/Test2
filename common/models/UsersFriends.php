<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "users_friends".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 */
class UsersFriends extends \yii\db\ActiveRecord
{

    public $username;
    public $email;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id'], 'required'],
            [['user_id', 'friend_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'friend_id' => 'Friend ID',
        ];
    }

    /**
     * @param int $userId
     * @param int $friendId
     * @return bool
     */
    public function deleteFriend($userId=0,$friendId=0) {

        // Удаление из 2-х таблиц сделаем через транзакцию
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($friendId === 0) {
                $deleteRow = self::findOne(['user_id' => $userId]);
            } else {
                $deleteRow = self::findOne(['user_id' => $userId, 'friend_id' => $friendId]);
            }
            if ($deleteRow) {
                $deleteRow->delete();
            }
            $transaction->commit();
            $ret=true;

        } catch (\Exception $e) {

            $transaction->rollBack();
            $ret=false;
        }

        return $ret;
    }

    public function getUsersList($userId) {

        $dataProvider = new ActiveDataProvider([
            'query' => static::find()
                ->select(['users_friends.id','users_friends.friend_id','user.username','user.email','user_id'=>'user.id'])
                ->leftJoin('user','users_friends.friend_id=user.id')
                ->where(['<>','users_friends.user_id',$userId])
                ->andWhere(['<>','users_friends.friend_id',$userId])
                ->orderBy('users_friends.friend_id'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }
}
