<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\SplFileInfo;

class LunchController extends AbstractController
{
    /**
     * @Route("/lunch", name="lunch")
     */
    public function index(Request $request)
    {
        $date = $request->query->get('date') ?: date('Y-m-d') ;

        $ingredientData = $this->getIngredients();
        $recipeData = $this->getRecipe();

        $ingredientsName = [];
        $lessFreshIngredients = [];
        foreach ($ingredientData->ingredients as $value) {
            //check safety ingredients
            $value = (array) $value;
            if (strtotime($date) <= strtotime($value['use-by'])) {
                $ingredientsName[] = $value['title'];
                #list less fresh ingredients
                if (strtotime($date) >= strtotime($value['best-before'])) {
                    $lessFreshIngredients[] = $value['title'];
                }
            }
        }

        $count = 0;
        $recipesSuggestion = [];
        $recipesSuggestionFresh = [];
        $recipesSuggestionLessFresh = [];
        if ($ingredientsName) {
            foreach ($recipeData->recipes as $recipesList) {
                $recipesList = (array) $recipesList;
                if (!array_diff($recipesList['ingredients'], $ingredientsName)) {
                    $includeLessFresh = array_intersect($recipesList['ingredients'],$lessFreshIngredients);
                    $count = count($includeLessFresh);
                    if ($count == 0) {
                        $recipesSuggestionFresh[] = [
                            'recipes_name' => $recipesList['title'], 
                            'count_less_fresh' => $count, 
                            'the_less_fresh_best_before_date' => ''
                        ];
                    } else {
                        $checkBestBeforeDate = [];
                        foreach ($includeLessFresh as $itemOfLessFresh) {
                            $checkBestBeforeDate[] = $this->checkBestBefore($itemOfLessFresh);
                        }
                        sort($checkBestBeforeDate);

                        $recipesSuggestionLessFresh[] = [
                            'recipes_name' => $recipesList['title'], 
                            'count_less_fresh' => $count, 
                            'the_less_fresh_best_before_date' => date('Y-m-d',$checkBestBeforeDate[0])
                        ];

                        $columns = array_column($recipesSuggestionLessFresh, 'the_less_fresh_best_before_date');
                        array_multisort($columns, SORT_DESC, $recipesSuggestionLessFresh);
                    }
                }
            }

            $recipesSuggestion = array_merge($recipesSuggestionFresh, $recipesSuggestionLessFresh);
        }

        return $this->json($recipesSuggestion);
    }

    public function getIngredients()
    {
        $path = $this->getParameter('kernel.root_dir');
        $contents = file_get_contents($path.'/Ingredient/data.json');

        return json_decode($contents);
    }

    public function getRecipe()
    {
        $path = $this->getParameter('kernel.root_dir');
        $contents = file_get_contents($path.'/Recipe/data.json');

        return json_decode($contents);
    }

    public function checkBestBefore($data)
    {
        $ingredients = $this->getIngredients();
        foreach ($ingredients->ingredients as $value) {
            $value = (array) $value;
            if ($value['title'] == $data) {
                return strtotime($value['best-before']);
            }
        }
    }

}
