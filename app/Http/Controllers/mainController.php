<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPHtmlParser\Dom;
use Illuminate\Support\Facades\Mail;
use Session;

use App\User;

class mainController extends Controller
{
    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'region' => 'required',
            'type' => 'required',
            'wordsearched' => 'required',
            'prixmax' => 'required',
            'prixmin' => 'required',
        ]);

        $email = $request->input('email');
        $type = $request->input('type');
        $region = $request->input('region');
        $departement = $request->input('type');
        $numpage = 1;
        $words_searched = $request->input('wordsearched');
        $prixmin = $this->setPriceNum($request->input('prixmin'));
        $prixmax = $this->setPriceNum($request->input('prixmax'));

        $words_searched = urlencode($words_searched);

        // INSERT User in DB
        $user = new User;
        $user->email = $email;
        $user->type = $type;
        $user->region = $region;
        $user->words_searched = $words_searched;
        $user->prix_min = $prixmin;
        $user->prix_max = $prixmax;
        $user->save();

        $url = 'https://www.leboncoin.fr/' . $type . '/offres/' . $region . '/?th=' . $numpage . '&q=' . $words_searched . '&ps=' . $prixmin . '&pe=' . $prixmax;
        $html = file_get_contents($url);

        $dom = new Dom;
        $contents = new Dom;
        $dom->load($html);
        $test = $dom->getElementById('listingAds')->find('ul')->outerhtml;
        $contents = $dom->getElementById('listingAds')->find('li');
        //return count($contents);

        $body_html = "";
        $informations = array();

        foreach ($contents as $content) {
            $title = $content->find('a')->getAttribute('title');
            $link = $content->find('a')->getAttribute('href');
            $date = $content->find('aside')->find('p')->text;
            $prix = $content->find('h3')->text;
            $item_description = $content->find('p.item_supp')[1]->text;
            $img = $content->find('a')->find('span')->find('span')->getAttribute('data-imgsrc');
            $img = str_replace('//', 'http://', $img);
            $link = str_replace('//', 'http://', $link);

            $informations[] = array(
                "title"=>$title,
                "link"=>$link,
                "date"=>$date,
                "prix"=>$prix,
                "item_description"=>$item_description,
                "img"=>$img
            );
            //return $item_description;
            //$body_html .= '<div class="col-sm-12 col-md-6">' . $title . '<br>' . $date . '<br>' . $item_description . '<br>' . $prix . '<br>' . $link . '<br><br><img src="' . $img . '" alt=""><br></div>';
        }
        $data = $this->array_utf8_encode($informations);
        $this->sendEmail($email, $informations);


        return response()->json($data);

    }

    public function sendEmail($to, $informations)
    {
        Mail::send('welcome', array('informations'=>$informations), function($email) use($to) {
            $email->to($to, 'Jon Doe')->subject('The greatcorner, vos informations :)');
        });
    }

    public function unsubscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $email = $request->input('email');

        User::where('email', $email)->forceDelete();

        Session::flash('flash_message', 'You are unsubscribed from our DB');
        return redirect('/index');
    }

    private function setPriceNum($price)
    {
        if ($price == 0) {
            return 0;
        }
        if ($price >= 5 && $price < 10) {
            return 1;
        }
        if ($price >= 10 && $price < 15) {
            return 2;
        }
        if ($price >= 15 && $price < 20) {
            return 3;
        }
        if ($price >= 20 && $price < 30) {
            return 4;
        }
        if ($price >= 30 && $price < 40) {
            return 5;
        }
        if ($price >= 40 && $price < 50) {
            return 6;
        }
        if ($price >= 50 && $price < 75) {
            return 7;
        }
        if ($price >= 75 && $price < 100) {
            return 8;
        }
        if ($price >= 100 && $price < 200) {
            return 9;
        }
        if ($price >= 200 && $price < 250) {
            return 10;
        }
        if ($price >= 250 && $price < 500) {
            return 11;
        }
        if ($price >= 500 && $price < 750) {
            return 12;
        }
        if ($price >= 750 && $price < 1000) {
            return 13;
        }
        if ($price >= 1000 && $price < 1250) {
            return 14;
        }
        if ($price >= 1250 && $price < 1500) {
            return 15;
        }
        if ($price >= 1500) {
            return 16;
        }
    }

    public function array_utf8_encode($dat)
    {
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = self::array_utf8_encode($d);
        return $ret;
    }
}
