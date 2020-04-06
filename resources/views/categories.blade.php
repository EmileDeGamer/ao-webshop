<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <table>
            <tr>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        if(isset($_GET['category'])){
                            $category = $_GET['category'];
                        }
                        else{
                            $category = $categories[0]->categoryName;
                        }
                    }
                    echo"<th>Categorie<form method='get' action=".$_SERVER['PHP_SELF']."><select name='category' onchange='if(this.value != 0) { this.form.submit(); }'>";
                        for ($i=0; $i < count($categories); $i++) {
                            if($categories[$i]->categoryName === $category){
                                echo "<option selected='selected' value=".$categories[$i]->categoryName.">".$categories[$i]->categoryName."</option>";
                            }
                            else{
                                echo "<option value=".$categories[$i]->categoryName.">".$categories[$i]->categoryName."</option>";
                            }
                        }
                    echo"</select></form></th>";
                ?>
            </tr>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        if(isset($_GET['category'])){
                            $category = $_GET['category'];
                            for ($i=0; $i < count($products); $i++) {
                                if($products[$i]->productCategory === $category){
                                    echo"<tr>";
                                        echo"<td>".$products[$i]->productName."</td>";
                                    echo"</tr>";
                                }
                            }
                        }
                    }
                ?>
            </tr>
        </table>
    </body>
</html>
