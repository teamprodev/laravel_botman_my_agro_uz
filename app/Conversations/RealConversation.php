<?php

namespace App\Conversations;

use App\Models\Action;
use App\Models\Region;
use App\Models\Routes;
use App\Models\User;
use App\Services\Mailer\MailService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Attachments\Contact;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Services\SmsService\SmsService;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Appeal;
use App\Models\QuestionText;

const LANGUAGE = [['key' => "Uzbek", 'value' => 'uz'], ['key' => "Pусский", 'value' => 'ru']];

const QUESTIONS = [
    
    'YES' => ['name' => ['uz' => 'YES', 'ru' => 'DA'], 'value' => 'yes'],
    'NO' => ['name' => ['uz' => 'NO', 'ru' => 'NET'], 'value' => 'no'],
    'ASK_USER_A' => [['uz' => 'Место работы полностью UZ', 'ru' => ' Место работы полностью '], ['uz' => "Название организации UZ", 'ru' => ' Название организации  ']],
    'ASK_USER_B' => [['uz' => 'Nothing UZ', 'ru' => ' Nothing '], ['uz' => 'Направление деятельности UZ', 'ru' => ' Направление деятельности ']],
];
class RealConversation extends Conversation
{
    public $memory = [];
    public $language;
    public $usertype;
    protected $verify;
    public $key_indevidual;
    public $questions;
    public $user_question_data;
    public function __construct()
    {
<<<<<<< HEAD

        $questions = Questiontext::all();
        $this->key_indevidual["ru"][0]["name"] = $questions->keyBy(['name' => 'ASK_YURIDIK'])->ru;



        // $this->key_indevidual["ru"][0]["name"] = QuestionText::where('name', 'ASK_YURIDIK')->first()->ru;
=======
        $this->questions = QuestionText::select('name', 'uz', 'ru')->get()->keyBy('name')->toArray();
        
        $this->key_indevidual["ru"][0]["name"] = QuestionText::where('name', 'ASK_YURIDIK')->first()->ru;
>>>>>>> 88f73725c9a1a83783ef31c64997d36100388402
        $this->key_indevidual["ru"][0]["val"] = 0;
        $this->key_indevidual["ru"][1]["name"] = QuestionText::where('name', 'ASK_JISMONIY')->first()->ru;
        $this->key_indevidual["ru"][1]["val"] = 1;

        $this->key_indevidual["uz"][0]["name"] = QuestionText::where('name', 'ASK_YURIDIK')->first()->uz;
        $this->key_indevidual["uz"][0]["val"] = 0;
        $this->key_indevidual["uz"][1]["name"] = QuestionText::where('name', 'ASK_JISMONIY')->first()->uz;
        $this->key_indevidual["uz"][1]["val"] = 1;





        $this->user_question_data["ASK_USER_A"][1]["uz"] = QuestionText::where('name', 'ASK_JOB')->first()->uz;
        $this->user_question_data["ASK_USER_A"][1]["ru"] = QuestionText::where('name', 'ASK_JOB')->first()->ru;

        $this->user_question_data["ASK_USER_A"][0]["uz"] = QuestionText::where('name', 'ASK_COMPANY_NAME')->first()->uz;
        $this->user_question_data["ASK_USER_A"][0]["ru"] = QuestionText::where('name', 'ASK_COMPANY_NAME')->first()->ru;

        $this->user_question_data["ASK_USER_B"][1]["uz"] = QuestionText::where('name', 'ASK_FIELD')->first()->uz;
        $this->user_question_data["ASK_USER_B"][1]["ru"] = QuestionText::where('name', 'ASK_FIELD')->first()->ru;

        $this->user_question_data["ASK_USER_B"][0]["uz"] = QuestionText::where('name', 'ASK_FIELD')->first()->uz;
        $this->user_question_data["ASK_USER_B"][0]["ru"] = QuestionText::where('name', 'ASK_FIELD')->first()->ru;



        
        // $this->questions["ASK_Title"]["ru"] = QuestionText::where('name', 'ASK_THEME')->first()->ru;
        // $this->questions["ASK_Title"]["uz"] = QuestionText::where('name', 'ASK_THEME')->first()->uz;
        // $this->questions["Yes"]["ru"] = "да";
        // $this->questions["Yes"]["uz"] = "HA";
        // $this->questions["No"]["ru"] = "Нет";
        // $this->questions["No"]["uz"] = "Yo'q";
        // $this->questions["ASK_TRUE"]["ru"] = "Вы подтверждаете, что подали обращение правильно?";
        // $this->questions["ASK_TRUE"]["uz"] = "Murojaatingizni to'g'ri yuborganingizni tasdiqlaysizmi?";
        LOG::info($this->questions["ASK_LANGUAGE"]);
    }

    public function keyLanguages(){
        $ar = [];
        foreach (LANGUAGE as $key) {
            array_push($ar, Button::create($key['key'])->value($key['value']));
        }
        return Question::create($this->questions["ASK_LANGUAGE"]["uz"])
            ->addButtons($ar);
    }

    public function keyUserType()
    {
        $ar = [];
        foreach ($this->key_indevidual[$this->language] as $key) {
            array_push($ar,Button::create($key["name"])->value($key["val"]));
        }
        return Question::create($this->questions["ASK_USER_TYPE"][$this->language])
            ->addButtons($ar);
    }

    public function keyActions()
    {
        $ar = [];
        $actions = Action::all()->toArray();
        foreach ($actions as $key) {
            array_push($ar, Button::create($key[$this->language])->value($key["id"]));
        }
        return Question::create($this->questions["ASK_ACTION"][$this->language])
            ->addButtons($ar);
    }

    public function keyRegions()
    {
        $ar = [];
        $regions = Region::all()->toArray();
        foreach ($regions as $key) {
            $ar[] = Button::create($key[$this->language])->value($key["id"]);
        }
        return Question::create($this->questions["ASK_REGION"][$this->language])
            ->addButtons($ar);
    }

    
    public function keyRoutes()
    {
        $ar = [];
        $routes = Routes::all()->toArray();
        foreach ($routes as $key) {
            $ar[] = Button::create($key[$this->language])->value($key["id"]);
        }
        return Question::create($this->questions["ASK_ROUTE"][$this->language])
            ->addButtons($ar);
    }

    public function mediaRoutes()
    {
        return Question::create($this->questions["ASK_FILE_UPLOAD"][$this->language])
            ->addButtons([
                Button::create(QUESTIONS["YES"]["name"][$this->language])->value(QUESTIONS["YES"]["value"]),
                Button::create(QUESTIONS["NO"]["name"][$this->language])->value(QUESTIONS["NO"]["value"])
            ]);
    }

    public function run()
    {
            // $arr= QuestionText::select('name', 'uz', 'ru')->get()->keyBy('name');
            // $this->say(json_encode($arr, JSON_UNESCAPED_UNICODE));
        // $this->askImageFile();
        $this->askLanguage();
    }
    
    public function askLanguage()
    {
        $this->ask($this->keyLanguages(), function ($language) {
            if ($language->isInteractiveMessageReply()) {
                $this->language = $language->getValue();
                $this->askEmail();
            } else {
                return $this->repeat();
            }
        });
    }

    public function askEmail()
    {
        $this->ask($this->questions["ASK_EMAIL"][$this->language], function ($email) {
            $x = preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/  ', $email->getText()) == 1 ? true : false;
            if ($x == true) {
                $this->user_mamory["email"] = $email->getText();

                $this->askAction();
            } elseif ($x == false) {
                $this->say($this->questions["SAY_INCORRECT_FORMAT"][$this->language]);
                $this->repeat();
            }
        });
        // $this->user_mamory["email"]
    }

    public function askAction()
    {
        $this->ask($this->keyActions(), function ($actions) {
            if ($actions->isInteractiveMessageReply()) {
                $this->memory["action"] = $actions->getValue();
                $this->askTitle();

            } else $this->repeat();
        });
    }

    public function askTitle()
    {
        $this->ask($this->questions["ASK_THEME"][$this->language], function ($answer) {
            $this->user_mamory["title"] = $answer->getText();
            $this->askAppeal();
        });
    }

    public function askAppeal()
    {
        $this->ask($this->questions["ASK_QUESTION"][$this->language], function ($conversation) {
            if ($conversation->getText() != "tugat") {
                $this->memory["answer"] = $conversation->getText();
            } else $this->repeat();
            $this->askMedia();
        });
    }

    public function askMedia()
    {
        $this->ask($this->mediaRoutes(), function ($answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() == "ha") {
                    $this->askRoute();
                } else {
                    $this->askRoute();
                }
            } else $this->repeat();
        });
    }

    

    public function askRegion()
    {
        $this->ask($this->keyRegions(), function ($regions) {
            if ($regions->isInteractiveMessageReply()) {
                $this->memory["region"] = $regions->getValue();

                $this->askUserType();

            } else $this->repeat();
        });
    }

    public function askRoute()
    {
        $this->ask($this->keyRoutes(), function ($routes) {
            if ($routes->isInteractiveMessageReply()) {
                $this->memory["route"] = $routes->getValue();
                $this->askRegion();

            } else $this->repeat();
        });
    }

    public function UserLogin()
    {
        $user = User::where('email', $this->user_mamory["email"])->first();
        $this->memory["pass"] = "nopass";

        if (!$user) {
            $this->memory["pass"] = $this->generatePass();
            $text = 'Your username ' . $this->user_mamory["email"] . '  and password ' . $this->memory["pass"] . ' for Cabinet';
            if ($this->user_mamory["usertype"] == 0) {
                $user = User::create([
                    'name' => $this->user_mamory["name"],
                    'role_id' => 2,
                    'phone' => $this->user_mamory["phone"],
                    'individual' => $this->user_mamory["usertype"],
                    'remember_token' => $this->generatePass(32),
                    "email" => $this->user_mamory["email"],
                    "password" => Hash::make($this->memory["pass"]),
                    "individual" => $this->user_mamory["usertype"],
                    "place_of_work" =>  $this->memory["data"]["a"]
                ]);
            } else {
                $user = User::create([
                    'name' => $this->user_mamory["name"],
                    'role_id' => 2,
                    'phone' => $this->user_mamory["phone"],
                    'individual' => $this->user_mamory["usertype"],
                    'remember_token' => $this->generatePass(32),
                    "email" => $this->user_mamory["email"],
                    "password" => Hash::make($this->memory["pass"]),
                    "individual" => $this->user_mamory["usertype"],
                    "organization" => $this->memory["data"]["a"],
                    "activity" => $this->memory["data"]["b"]
                ]);
            }
            $email=$this->user_mamory["email"];
            $password=$this->memory["pass"];
            $text = $this->language == "uz" ? setting('sms.AccountUz').'<br>Email:'.$email.'<br>Password:'.$password : setting('sms.AccountRu').'<br>Email:'.$email.'<br>Password:'.$password;
            // $text = 'E-Mail: ' . $this->user_mamory["email"].' Password:'. $this->memory["pass"];

            $smsSender = new SmsService();
            $smsSender->send($this->user_mamory["phone"], $text);

            $details = [
                'title' => 'AGRO.UZ ',
                'body' => $text
            ];
            Mail::to($this->user_mamory["email"])->send(new SendMail($details));
        } else {
            $this->user_mamory["usertype"] = $user->individeual;
            $this->user_mamory["phone"] = $user->phone;
            $this->user_mamory["name"] = $user->name;
        }

        $this->user_mamory["id"] = $user->id;
        // Auth::login($user);

        $this->askEnd();
    }

    public function fillUserData(User $user)
    {

    }


    public function askPhone()
    {
        $this->ask($this->questions["ASK_PHONE"][$this->language], function ($phone) {
            $x = preg_match('/^9[012345789][0-9]{7}$/', $phone->getText()) == 1 ? true : false;
            if ($x == true) {
                $this->user_mamory["phone"] = $phone->getText();
                $this->verifyPhone($this->user_mamory["phone"]);
            } elseif ($x == false) {
                $this->say($this->questions["SAY_INCORRECT_FORMAT"][$this->language]);
                $this->repeat();
            }

        });
    }

    public function verifyPhone($phone)
    {
        $this->verify = $this->generatePass(4);
        $smsSender = new SmsService();
        $smsSender->send('998' . $phone, "My.Agro.Uz portali uchun tasdiqlash kodi: " . $this->verify);
        $this->ask($this->questions["ASK_VERIFY_PHONE"][$this->language], function ($verifycode) {
            Log::info($this->verify);
            if ($verifycode == $this->verify) {
                $this->UserLogin();

            } else {
                $this->say($this->questions["SAY_INCORRECT_CODE"][$this->language]);
                $this->repeat();
            }
        });

    }

    public function askName()
    {
        $this->ask(
            $this->questions["ASK_NAME"][$this->language],
            function ($name) {
            $this->user_mamory["name"] = $name->getText();
            $user = User::where('email', $this->user_mamory["email"])->first();
            if($user) {
                Log::info($user->phone);
                $this->verifyPhone($user->phone);
            }else {
                $this->askPhone();
            }

            }
        );
    }
    public function askUser(){
        if($this->user_mamory["usertype"] == 0){
            $this->ask($this->user_question_data["ASK_USER_A"][$this->user_mamory["usertype"]][$this->language], function($ask1){
                $this->memory["data"]["a"] = $ask1->getText();
                $this->ask($this->user_question_data["ASK_USER_B"][$this->user_mamory["usertype"]][$this->language]
                    , function($ask2) {
                    $this->memory["data"]['b'] = $ask2->getText();
                    $this->askName();
                });
            });
        } else {
            LOG::info($this->user_mamory["usertype"]);
            $this->ask($this->user_question_data["ASK_USER_A"][$this->user_mamory["usertype"]][$this->language], function($ask1){
                $this->memory["data"]["a"] = $ask1->getText();
                $this->askName();

            });
        }


    }

    public function askUserType()
    {
        $this->ask($this->keyUserType(), function ($usertype) {
            if ($usertype->isInteractiveMessageReply()) {
                $this->user_mamory["usertype"] = $usertype->getValue();
                $this->askUser();
            } else $this->repeat();
        });
    }


    public function askEnd() {
        $this->say($this->questions["ASK_NAME"][$this->language] .': '.$this->user_mamory["name"].'<br> '.$this->questions["SAY_ACTION"][$this->language].''.$this->memory["action"].'<br> Region: '.$this->memory["region"].'<br> Route: '.$this->memory["route"].'<br> E-mail: '.$this->user_mamory["email"].'<br> Tel: '.$this->user_mamory["phone"].'<br> ');
        $question = 
            Question::create($this->questions["ASK_VERIFY"][$this->language])
            ->addButtons([
                Button::create(QUESTIONS["YES"]["name"][$this->language])->value(QUESTIONS["YES"]["value"]),
                Button::create(QUESTIONS["NO"]["name"][$this->language])->value(QUESTIONS["NO"]["value"])
            ]);

        $this->ask($question, function ($answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() == QUESTIONS["YES"]["value"]) {
                    $appeal = new Appeal();
                    $appeal->title = $this->user_mamory["title"];
                    $appeal->text = $this->memory["answer"];
                    $appeal->user_id = $this->user_mamory["id"];
                    $appeal->region = $this->memory["region"];
                    $appeal->route = $this->memory["route"];
                    $appeal->type = $this->memory["action"];
                    $appeal->fullname = $this->user_mamory["name"];
                    if($this->user_mamory["usertype"]==1) {
                        $appeal->company = $this->memory["data"]["a"];
                        $appeal->branch = $this->memory["data"]["b"];
                    } else {
                        $appeal->workplace = $this->memory["data"]["a"];
                    }


                    $appeal->save();
                    $this->say( $this->questions["FINISH"][$this->language]);
                }else {
                    $this->askAppeal();
                }
            } else {
                $this->repeat();
            }


        });
    }
    public function askFiles(){
        $this->bot->receivesFiles(function($bot, $files) {

            foreach ($files as $file) {
        
                $url = $file->getUrl(); // The direct url
                $payload = $file->getPayload(); // The original payload
            }
            $this->say(json_encode($file->getPayload()));
        });
    }

    static function generatePass($length = 4)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}