<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function search(Request $request){
        $search = strtolower($request->input('word'));
        $word = Word::where('word', $search)->first();
        $points = 0;
        if($word){
            $numberOfUniqueLetters = count(array_unique(str_split(strtolower($word->word))));
            $points += $numberOfUniqueLetters;
            $isPalindrome = false;
            $isAlmostPalindrome = false;
            if($search === strrev(strtolower($word->word))){
                $isPalindrome = true;
                $points += 3;
            }else{
                for($i = 0; $i < mb_strlen($word->word); $i++){
                    $arrayFromString = str_split($word->word);
                    unset($arrayFromString[$i]);
                    $newString = strtolower(implode($arrayFromString));
                    $array[] = $newString;
                    if($newString === strrev(strtolower($newString))){
                        $isAlmostPalindrome = true;
                        $points += 2;
                        break;
                    }
                }
            }
            return response()->json([
                'word' => $word,
                'numberOfUniqueLetters' => $numberOfUniqueLetters,
                'isPalindrome' => $isPalindrome,
                'isAlmostPalindrome' => $isAlmostPalindrome,
                'points' => $points
            ]);
        }else{
            return response()->json([
                'message' => "Couldn't find this word in the english dictionary."
            ], 500);
        }
        
    }
}
