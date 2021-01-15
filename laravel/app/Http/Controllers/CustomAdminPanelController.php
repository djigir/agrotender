<?php

namespace App\Http\Controllers;

use App\Models\ADV\AdvTorgPost;
use App\Models\ADV\AdvTorgPostModerMsg;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomAdminPanelController extends Controller
{
    public function savePostModerMsg(Request $request)
    {
        $message = '';
        $replace = [
            'reason_1' => 'Вы указали заголовок, очень похожий на одно из ваших объявлений.',
            'reason_2' => 'Указанная Вами цена не отвечает действительной цене товара/услуги.',
            'reason_3' => 'В тексте или заголовке объявления указаны недопустимые слова.',
            'reason_4' => 'Заголовок или текст объявления набран в верхнем регистре.',
        ];
        foreach ($replace as $key => $value) {
            if ($request->get('message')&& $request->get($key))
                $message .= "$value<br>";
        }
        $message = str_replace('{TPL_RULES}',$message, $request->get('message'));
        AdvTorgPostModerMsg::create(
            ['post_id' => $request->get('post_id', 0),
                'add_date' => Carbon::now(),
                'msg' => $message
            ]
        );
        AdvTorgPost::find($request->get('post_id'))->update([
            'active' => 0,
        ]);


        return redirect($request->get('redirect'));

    }
}
