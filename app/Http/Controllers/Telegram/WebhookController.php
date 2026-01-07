<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// сервис-контейнер
use App\Services\TelegramService;
// модель хранения входящих запросов
use App\Models\IncomingMessage;
// для отладки
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    // сервис-контейнер
    private $telegram_service;

    /**
     * Внедрение зависимости через конструктор класса
     */
    public function __construct(TelegramService $telegram_service)
    {
        $this->telegram_service = $telegram_service;
    }

    /**
     * Webhook routing
     * Распознаёт полученные данные и отправляет соответствующие ответы
     * @param r object объект класса Request
     * @return mixed возвращает результат работы вызываемых методов
     */
    public function webhook(Request $r)
    {
        // подготовка данных
        $bot_name = 'DevTestWgBot -> SquirrelBot'; // название бота
        $update_id = $r->input('update_id'); // обновление
        $message_id = $r->input('message.message_id'); // идентификатор сообщения
        $from_id = $r->input('message.from.id'); // идентификатор отправителя
        $first_name = $r->input('message.from.first_name'); // имя отправителя
        $last_name = $r->input('message.from.last_name'); // фамилия отправителя
        $username = $r->input('message.from.username'); // ник отправителя
        $chat_id = $r->input('message.chat.id'); // идентификатор чата
        $date = $r->input('message.date'); // временная метка отправления
        $text = $r->input('message.text'); // текст сообщения
        $callback_data = $r->input('callback_query.data'); // callback-команда
        $callback_message_id = $r->input('callback_query.message.message_id'); // идентификатор callback-сообщения
        $callback_chat_id = $r->input('callback_query.message.chat.id'); // идентификатор callback-чата
        $mark = 0; // числовой маркер
        $notes = 'some'; // текстовая метка

        // сохранение входящего сообщения (для аналитики)
        $incoming_message = IncomingMessage::create(
            [
                'bot_name' => $bot_name,
                'update_id' => $update_id,
                'message_id' => $message_id,
                'from_id' => $from_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'chat_id' => $chat_id,
                'date' => $date,
                'text' => $text,

                'callback_data' => $callback_data,
                'callback_message_id' => $callback_message_id,
                'callback_chat_id' => $callback_chat_id,

                'mark' => $mark,
                'notes' => $notes,
            ]
        );

        // пользователь отправил текст:
        if ($text == 'Старт' || $text == '/start') {
            $this->telegram_service->send_message($chat_id, 'Добро пожаловать в мир Сквирел! Пользуйтесь кнопкой "Меню" для навигации.');
        }

        // пользователь отправил текст:
        // elseif ($text == 'Меню') {
        // $buttons = $this->telegram_service->kit_buttons_menu();
        // $this->telegram_service->send_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал кнопку:
        // elseif ($callback_data == '/timetable') {

        //     // интерактивность кнопки
        //     $buttons = $this->telegram_service->kit_buttons_menu(1, '✅');
        //     $this->telegram_service->edit_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

        //     // отправка view
        //     $view = (string) view('Telegram.timetable');
        //     $this->telegram_service->send_message($callback_chat_id, $view);

        //     // отправка меню
        //     $buttons = $this->telegram_service->kit_buttons_menu();
        //     $this->telegram_service->send_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал пункт меню:
        elseif ($text == '/timetable') {

            // интерактивность кнопки
            // $buttons = $this->telegram_service->kit_buttons_menu(1, '✅');
            // $this->telegram_service->edit_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

            // отправка view
            $view = (string) view('Telegram.timetable');
            $this->telegram_service->send_message($chat_id, $view);

            // отправка меню
            // $buttons = $this->telegram_service->kit_buttons_menu();
            // $this->telegram_service->send_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons);
        }

        // пользователь выбрал кнопку:
        // elseif ($callback_data == '/mk') {

        //     // интерактивность кнопки
        //     $buttons = $this->telegram_service->kit_buttons_menu(2, '✅');
        //     $this->telegram_service->edit_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

        //     // отправка view
        //     $view = (string) view('Telegram.mk');
        //     $this->telegram_service->send_message($callback_chat_id, $view);

        //     // отправка меню
        //     $buttons = $this->telegram_service->kit_buttons_menu();
        //     $this->telegram_service->send_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал пункт меню:
        // elseif ($text == '/mk') {

        //     // интерактивность кнопки
        //     $buttons = $this->telegram_service->kit_buttons_menu(2, '✅');
        //     $this->telegram_service->edit_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

        //     // отправка view
        //     $view = (string) view('Telegram.mk');
        //     $this->telegram_service->send_message($chat_id, $view);

        //     // отправка меню
        //     $buttons = $this->telegram_service->kit_buttons_menu();
        //     $this->telegram_service->send_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал кнопку:
        // elseif ($callback_data == '/promotions') {

        //     // интерактивность кнопки
        //     $buttons = $this->telegram_service->kit_buttons_menu(3, '✅');
        //     $this->telegram_service->edit_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

        //     // отправка view
        //     $view = (string) view('Telegram.promotions');
        //     $this->telegram_service->send_message($callback_chat_id, $view);

        //     // отправка меню
        //     $buttons = $this->telegram_service->kit_buttons_menu();
        //     $this->telegram_service->send_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал пункт меню:
        elseif ($text == '/promotions') {

            // интерактивность кнопки
            // $buttons = $this->telegram_service->kit_buttons_menu(3, '✅');
            // $this->telegram_service->edit_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

            // отправка view
            $view = (string) view('Telegram.promotions');
            $this->telegram_service->send_message($chat_id, $view);

            // отправка меню
            // $buttons = $this->telegram_service->kit_buttons_menu();
            // $this->telegram_service->send_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons);
        }

        // пользователь выбрал кнопку:
        // elseif ($callback_data == '/programs') {

        //     // интерактивность кнопки
        //     $buttons = $this->telegram_service->kit_buttons_menu(4, '✅');
        //     $this->telegram_service->edit_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

        //     // отправка view
        //     $view = (string) view('Telegram.programs');
        //     $this->telegram_service->send_message($callback_chat_id, $view);

        //     // отправка меню
        //     $buttons = $this->telegram_service->kit_buttons_menu();
        //     $this->telegram_service->send_message_with_buttons($callback_chat_id, 'Что Вас интересует?', $buttons);
        // }

        // пользователь выбрал пункт меню:
        elseif ($text == '/programs') {

            // интерактивность кнопки
            // $buttons = $this->telegram_service->kit_buttons_menu(4, '✅');
            // $this->telegram_service->edit_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons, $callback_message_id);

            // отправка view
            $view = (string) view('Telegram.programs');
            $this->telegram_service->send_message($chat_id, $view);

            // отправка меню
            // $buttons = $this->telegram_service->kit_buttons_menu();
            // $this->telegram_service->send_message_with_buttons($chat_id, 'Что Вас интересует?', $buttons);
        } elseif ($text == '/events') {
            // отправка view
            $view = (string) view('Telegram.events');
            $this->telegram_service->send_message($chat_id, $view);
        } elseif ($text == '/about') {
            // отправка view
            $view = (string) view('Telegram.about');
            $this->telegram_service->send_message($chat_id, $view);
        } else {
            $this->telegram_service->send_message($chat_id, 'Не знаю такой команды, но скоро меня обучат.');
        }
    }

    /**
     * Установка вебхука
     */
    public function set()
    {
        // $http = $this->telegram_service->push_get('setWebhook', ['url' => 'https://where-go.ru/tg/webhook']);
        $http = $this->telegram_service->push_get('setWebhook', ['url' => 'https://light-bot.ru/tg/webhook']);
        dd(json_decode($http));
    }

    /**
     * Удаление вебхука
     */
    public function delete()
    {
        $http = $this->telegram_service->push_get('deleteWebhook', ['url' => 'drop_pending_updates']);
        dd(json_decode($http));
    }

    /**
     * Получение информации о работе вебхука
     */
    public function info()
    {
        $http = $this->telegram_service->push_get('getWebhookInfo');
        dd(json_decode($http));
    }
}
