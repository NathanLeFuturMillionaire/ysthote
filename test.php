<?php

function getRecipes(array $recipes) : array {
      
    // On crée un tableau vide qui recevra les données issues du paramètre $recipes
    $allRecipes = [];

    // On parcourt les valeurs de notre tableau
    foreach($recipes as $recipe) {
       // Et on stock toutes les données dans le tableau $allRecipes[]
       $allRecipes[] = $recipe;
 }
    // Et on fait un return
    return $allRecipes;
}

// Maintenant, on crée un tableau dont la fonction getRecipes() parcourira
$recipes = [
    [
        'title' => 'Titre de la recette 1',
        'recipe' => 'Description de la recette',
    ],
    [
        'title' => 'Titre de la recette 2',
        'recipe' => 'Description de la recette',
    ],
    [
        'title' => 'Titre de la recette 3',
        'recipe' => 'Description de la recette',
    ],
];

// Et on parcourt les valeurs du tableau en utilisant notre fonction
foreach(getRecipes($recipes) as $recipe) {
    echo $recipe['title'] . '<br>'; // Affiche Titre de la recette 1, Titre de la recette 2, etc...
}