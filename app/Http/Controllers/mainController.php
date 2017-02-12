<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use PHPHtmlParser\Dom;
use Illuminate\Support\Facades\Mail;
use Session;
use App\User;

class mainController extends Controller
{
    public function postIndex(Request $request)
    {
        $error_price = null;
        $this->validate($request, [
            'email' => 'required|email',
            'region' => 'required',
            'type' => 'required',
            'wordsearched' => 'required',
            'prixmax' => 'required',
            'prixmin' => 'required',
        ]);

        if ($this->setPriceNum($request->input('prixmin')) > $this->setPriceNum($request->input('prixmax'))) {
            $error = "Le prix min ne peut pas être supérieux au prix max";
            return view('pages.index', ['error' => $error]);
        }

        // INSERT User in DB
        $user = $this->setUser($request->input('email'), $request->input('type'), $request->input('region'), urlencode($request->input('wordsearched')), $this->setPriceNum($request->input('prixmin')), $this->setPriceNum($request->input('prixmax')));
        //Get Dom Html results
        $dom = new Dom;
        //$contents = new Dom;

        $dom->load($this->getHtmlResultFromUserRequest($user));


        if ($dom->getElementById('listingAds') != null) {
            $contents = $dom->getElementById('listingAds')->find('li');
            $informations = $this->setResultsInformationFromHtmlFile($contents);
            $this->sendEmail($user->email, $informations);
        } else {
            //return response()->json(["error" => "Il n'y a pas de résultats à votre requête"]);
            $error = "Il n'y a pas de résultats correspondants à votre requête";
            return view('pages.index', ['error' => $error]);
        }

        //return response()->json("ok");

        Session::flash('flash_message', 'Enregistrement créé <3');
        return redirect('/index');
    }

    public function getHtmlResultFromUserRequest($user)
    {
        $numpage = 1;
        $url = 'https://www.leboncoin.fr/' . $user->type . '/offres/' . $user->region . '/?th=' . $numpage . '&q=' . $user->words_searched . '&ps=' . $user->prixmin . '&pe=' . $user->prixmax;

        $html = file_get_contents($url);
        return $html;
    }

    public function setResultsInformationFromHtmlFile($contents)
    {
        $contents_local = new Dom;
        $contents_local->load($contents);
        $informations = array();
        foreach ($contents_local as $content) {
            $informations[] = array(
                "title" => $content->find('a')->getAttribute('title'),
                "link" => str_replace('//', 'http://', $content->find('a')->getAttribute('href')),
                "date" => $content->find('aside')->find('p')->text,
                "prix" => $content->find('h3')->text,
                "item_description" => $content->find('p.item_supp')[1]->text,
                "img" => $link = str_replace('//', 'http://', $content->find('a')->find('span')->find('span')->getAttribute('data-imgsrc'))
            );
        }

        return $informations;
    }

    public function sendEmail($to, $informations)
    {
        Mail::send('welcome', array('informations' => $informations), function ($email) use ($to) {
            $email->to($to, 'Jon Doe')->subject('The greatcorner, vos informations :)');
        });
    }

    public function postUnsubscribe(Request $request)
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

    public function setUser($email, $type, $region, $words_searched, $prixmin, $prixmax)
    {
        $user = new User;
        $user->email = $email;
        $user->type = $type;
        $user->region = $region;
        $user->words_searched = $words_searched;
        $user->prix_min = $prixmin;
        $user->prix_max = $prixmax;
        $user->save();

        return $user;

    }
}