@extends('./layout')

@section('content')
    <table id="categoriesTable">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if(isset($_GET['category'])){
                    $category = $_GET['category'];
                }
                else{
                    $category = $categories[0]->categoryName;
                }
            }
            echo"<div id='categoriesSelectionDisplay'><span>Categorie:</span><form method='get' action=".$_SERVER['PHP_SELF']."><select name='category' onchange='if(this.value != 0) { this.form.submit(); }'>";
                for ($i=0; $i < count($categories); $i++) {
                    if($categories[$i]->categoryName === $category){
                        echo "<option selected='selected' value=".$categories[$i]->categoryName.">".$categories[$i]->categoryName."</option>";
                    }
                    else{
                        echo "<option value=".$categories[$i]->categoryName.">".$categories[$i]->categoryName."</option>";
                    }
                }
            echo"</select></form></div>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if(isset($_GET['category'])){
                    $category = $_GET['category'];
                }
            }
            if(isset($category)){
                for ($i=0; $i < count($products); $i++) {
                    if($products[$i]->productCategory === $category){
                        echo"<tr>";
                            echo"<td>";
                                echo"<form id=".$products[$i]->productName." method='post' action='/showProduct'>";
                                    ?>@csrf<?php
                                    echo "<button name='productName' value=".$products[$i]->productName." onclick='if(this.value != 0) { this.form.submit() }'>".$products[$i]->productName."</button>";
                                echo "</form>";
                            echo"</td>";
                        echo"</tr>";
                    }
                }
            }
        ?>
    </table>
@endsection
