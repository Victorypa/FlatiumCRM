<?php

namespace App\Console\Commands\Amo;

use App\User;
use Carbon\Carbon;
use App\Models\Orders\Order;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class AmoDataFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amo:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from amo crm';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $client;

    protected $token = '927a17dd6d264d99c1970535eda5ebf7';

    protected $email = 'ilya.gavrilov@flatium.ru';

    protected $amo_ids = [];

    protected $order_amo_ids = [];

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            'cookies' => true
        ]);

        $this->amo_ids = [];
        $this->order_amo_ids = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fetchOrderAmoIds();

        $this->authentication();

        if (count($this->order_amo_ids) === 0) {
            foreach ($this->allowedStatuses() as $allowed_status_id) {
                if ($this->fetchAmoOrders($allowed_status_id) !== null) {
                    foreach ($this->fetchAmoOrders($allowed_status_id) as $order) {
                        $this->createOrder($order, "https://flatium.amocrm.ru/" . $order->contacts->_links->self->href);
                    }
                }

            }
        } else {
            foreach ($this->allowedStatuses() as $allowed_status_id) {
                if ($this->fetchAmoOrders($allowed_status_id) !== null) {
                    foreach ($this->fetchAmoOrders($allowed_status_id) as $order) {
                        array_push($this->amo_ids, $order->id);
                    }
                }
            }


            if (count($diffIds = array_diff($this->amo_ids, $this->order_amo_ids)) != 0 ) {
                foreach ($diffIds as $key => $value) {
                    $response = json_decode(
                        $this->client->request('GET', 'https://flatium.amocrm.ru/api/v2/leads?id=' . $value . '&type=json'
                    )->getBody())->_embedded->items;

                    $this->createOrder($response[0], "https://flatium.amocrm.ru/" . $response[0]->contacts->_links->self->href);
                }

            }
        }

    }

    protected function allowedStatuses()
    {
        $allowed_status_ids = [19015585, 21236431, 18733813, 21851482, 20686033];

        return $allowed_status_ids;
    }

    protected function authentication()
    {
        $link= 'https://flatium.amocrm.ru/private/api/auth.php?type=json';

        $this->client->request('POST', $link, [
            'form_params' => [
                'USER_LOGIN' => $this->email,
                'USER_HASH' => $this->token
            ],
        ]);
    }

    protected function fetchAmoOrders($allowed_status_id)
    {
        $link = "https://flatium.amocrm.ru/api/v2/leads?status=$allowed_status_id&type=json";

        // $link = 'https://flatium.amocrm.ru/api/v2/leads?id=9870837&type=json';

        $response = $this->client->request('GET', $link);

        if (json_decode($response->getBody()) === null) {
            return null;
        } else {
            return json_decode($response->getBody())->_embedded->items;
        }
    }

    protected function fetchOrderAmoIds()
    {
        $orders = Order::get();

        foreach ($orders as $order) {
            array_push($this->order_amo_ids, $order->amo_id);
        }
    }

    protected function createOrder($data, $contact_link = null)
    {
         $user = $this->createUser($contact_link);

        //  Order::create([
        //     'amo_id' => $data->id,
        //     'user_id' => $user->id,
        //     'order_name' => $data->name,
        //     'client_name' => $user->name,
        //     'status' => $data->status_id,
        //     'created_at' => Carbon::createFromTimestamp($data->created_at)
        // ]);
    }

    protected function createUser($contact_link)
    {
        $contact = json_decode($this->client->request('GET', $contact_link)->getBody())->response->contacts[0];

        $phone = $contact->custom_fields[0]->values[0]->value;

        $uselessLetters = ['+', ' ', '(', ')', '-'];
        
        dump(str_replace($uselessLetters, "", $phone));

        // return User::create([
        //     'name' => $contact->name,
        //     'phone' => $phone,
        //     'password' => str_random(6)
        // ]);
    }
}
