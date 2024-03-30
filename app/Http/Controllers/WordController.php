<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function search(Request $request){
        $search = strtolower($request->input('word'));
        $words = Word::where('word', $search)->get();
        $points = 0;
        if(count($words) > 0){
            $word = $words[0]->word;
            $numberOfUniqueLetters = count(array_unique(str_split(strtolower($word))));
            $points += $numberOfUniqueLetters;
            $isPalindrome = false;
            $isAlmostPalindrome = false;
            if($search === strrev(strtolower($word))){
                $isPalindrome = true;
                $points += 3;
            }else{
                for($i = 0; $i < mb_strlen($word); $i++){
                    $arrayFromString = str_split($word);
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
                'words' => $words,
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
