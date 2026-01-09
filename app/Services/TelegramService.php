<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Набор кнопок для меню
     * @param index int указывает на индекс элемента массива
     * @param check_mark string emoji
     * @return mixed возвращает массив inline_keyboard
     */
    public function kit_buttons_menu($index = null, $check_mark = null)
    {
        return [
            'inline_keyboard' => [
                [
                    [
                        'text' => ($index == 1 ? $check_mark . ' ' : '') . 'Расписание',
                        'callback_data' => '/timetable',
                    ],
                    [
                        'text' => ($index == 2 ? $check_mark . ' ' : '') . 'Мастер-классы',
                        'callback_data' => '/mk',
                    ],
                ],
                [
                    [
                        'text' => ($index == 3 ? $check_mark . ' ' : '') . 'Акции',
                        'callback_data' => '/promotions',
                    ],
                    [
                        'text' => ($index == 4 ? $check_mark . ' ' : '') . 'Программы',
                        'callback_data' => '/programs',
                    ],
                ],
            ],
        ];
    }

    /**
     * Конструктор GET-запроса
     * @param method string метод взаимодействия с api.telegram
     * @param parameters mixed передаваемые параметры
     * @return mixed возвращает ответ на отправленный запрос
     */
    public function push_get($method, $parameters = null)
    {
        $api_token = config('telegram.SquirrelKidsBot');
        return Http::get("https://api.telegram.org/$api_token/$method", $parameters);
    }
    
    /**
     * Конструктор POST-запроса
     * @param method string метод взаимодействия с api.telegram
     * @param parameters mixed передаваемые параметры
     * @return mixed возвращает ответ на отправленный запрос
     */
    public function push_post($method, $parameters)
    {
        $api_token = config('telegram.SquirrelKidsBot');
        return Http::post("https://api.telegram.org/$api_token/$method", $parameters);
    }

    /**
     * Отправка сообщения
     * @param chat_id int идентификатор чата, в который будет отправлено сообщение
     * @param text text текст сообщения
     * @return mixed возвращает ответ на отправленный запрос
     */
    public function send_message($chat_id, $text)
    {
        $parameters = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
        ];

        return self::push_post('sendMessage', $parameters);
    }

    /**
     * Отправка сообщения с кнопками
     * @param chat_id int идентификатор чата, в который будет отправлено сообщение
     * @param text text текст сообщения
     * @param kit_buttons array набор кнопок
     * @return mixed возвращает ответ на отправленный запрос
     */
    public function send_message_with_buttons($chat_id, $text, $kit_buttons)
    {
        $parameters = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode($kit_buttons),
        ];

        return self::push_post('sendMessage', $parameters);
    }

    /**
     * Редактирование сообщения с кнопками
     * @param chat_id int идентификатор чата, в который будет отправлено сообщение
     * @param text text текст сообщения
     * @param kit_buttons mixed набор кнопок
     * @param callback_message_id int идентификатор редактируемого сообщения
     * @return mixed возвращает ответ на отправленный запрос
     */
    public function edit_message_with_buttons($chat_id, $text, $kit_buttons, $callback_message_id)
    {
        $parameters = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => json_encode($kit_buttons),
            'message_id' => $callback_message_id,
        ];

        return self::push_post('editMessageText', $parameters);
    }

    /**
     * Установка вебхука
     */
    public function set()
    {
        $http = self::push_get('setWebhook', ['url' => 'https://where-go.ru/tg/webhook']);
        dd(json_decode($http));
    }

    /**
     * Удаление вебхука
     */
    public function delete()
    {
        $http = self::push_get('deleteWebhook', ['url' => 'drop_pending_updates']);
        dd(json_decode($http));
    }

    /**
     * Получение информации о работе вебхука
     */
    public function info()
    {
        $http = self::push_get('getWebhookInfo');
        dd(json_decode($http));
    }
}
