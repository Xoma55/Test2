<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 28.10.2016
 * Time: 13:00
 */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Главная';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-main">

    <?php \yii\widgets\Pjax::begin(['id' => 'mainUser']); ?>

    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns'=>[
                'id','username','email',

                ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{addFriend} {removeFriend} {userPage} {deleteUser}',
                    'buttons' => [
                        'addFriend' => function($url,$model,$key) {
                            if ($model->getFriend(Yii::$app->user->getId(),$key)==0) {
                                return Html::a('<span class="glyphicon glyphicon glyphicon-plus-sign"></span>',
                                    Yii::$app->urlManager->createUrl(['site/main','addFriend'=>$key]),
                                    ['title' => 'Добавить в друзья',]);
                            }
                        },
                        'removeFriend'=> function($url,$model,$key) {
                            if ($model->getFriend(Yii::$app->user->getId(),$key)==1) {
                                return Html::a('<span class="glyphicon glyphicon glyphicon-minus-sign"></span>',
                                    Yii::$app->urlManager->createUrl(['site/main','removeFriend'=>$key]),
                                    ['title' => 'Удалить из друзей',]);
                            }
                        },
                        'userPage'=> function($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon-info-sign"></span>',
                                Yii::$app->urlManager->createUrl(['site/userinfo','userId'=>$key]),
                                ['title' => 'Страница пользователя',]);
                        },
                        'deleteUser'=> function($url,$model,$key) {
                            return Html::a('<span class="glyphicon glyphicon glyphicon-remove"></span>',
                                Yii::$app->urlManager->createUrl(['site/main','deleteUser'=>$key]),
                                ['title' => 'Удалить пользователя','data'=>['confirm'=>'Удалить пользователя '.$model->username.'?']]);
                        }
                    ],

                ],


            ]
        ]);
    ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>