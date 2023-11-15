<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake recipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h1>&#127856; Online Cake Recipes</h1>
<?php
// Read the contents of recipes.txt
$recipesContent = file_get_contents('ZH CAKE BOOK/recipes.txt');

// Split the content into array based on type of cakes
$recipes = explode("#", $recipesContent);

// Remove the first empty element
array_shift($recipes);

// Create an associative array to store cake names, image file names, and their corresponding recipes
$cakeData = array();

// Loop through each recipe
foreach ($recipes as $recipe) {
    // Split the recipe into lines
    $lines = explode("\n", $recipe);

    // Extract cake name (first line starting from # character)
    // no need trim() # character as we already used explode() with it
    $cakeName = $lines[0];

    // Extract image file name (line starting with *)
    $imageFileName = trim($lines[1], "*");

    // Extract recipe description (starting from the third line)
    $recipeDescription = implode("\n", array_slice($lines, 2));

    // Store the cake name, image file name, and recipe description in the associative array (or map)
    $cakeData[$cakeName] = array(
        'image' => $imageFileName,
        'recipe' => $recipeDescription
    );
}

// Check if a cake is selected
if (isset($_POST['cake'])) {
    $selectedCake = $_POST['cake'];
    // Display the selected cake's recipe and image
    echo "<h2>$selectedCake</h2>";
    // Explode the recipe into steps and display each step on a new line
    $steps = explode("Step", $cakeData[$selectedCake]['recipe']);
    foreach ($steps as $step) {
        if (!empty($step)) {
            echo '<p>Step ' . trim($step) . '<br/>' . '</p>';
        }
    }
    echo '<img src="ZH CAKE BOOK/' . strtolower($cakeData[$selectedCake]['image']) . '" alt="' . htmlentities($selectedCake) . '">';
}
?>

<form action="index.php" method="POST">
    <label for="cake">Cakes: </label>
    <select name="cake" id="cake" onChange="this.form.submit();">
        <option value="">--- Choose a cake ---</option>
        <?php
        // Populate the dropdown menu with cake names
        foreach (array_keys($cakeData) as $cakeName) {
            echo '<option value="' . "$cakeName" . '">' . "$cakeName" . '</option>';
        }
        ?>
    </select>
    <input type="hidden" name="form_submitted" value="1">
</form>
</div>

</body>
</html>
