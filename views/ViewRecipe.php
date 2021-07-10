
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des recettes</h2>
    <form class="gridX4 formRegister" style="margin: 0 13%;min-height: 315px;height: 26%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter une recette</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="label">Titre de la recette</label>
                    <br>
                    <input type="text" placeholder="Titre de la recette" id="label" name="label" required size="26">
                </div>   
                <div>
                    <label for="type">Type de bière</label>
                    <br>
                    <select id="type" name="type" >
                        <option value=''>Choisiez un type</option>
                        <?php
                            foreach($types as $type):?>
                                <?= ($type->archived() ? "": "<option value='".$type->id()."'>".$type->label().'</option>');?>
                        <?php endforeach; ?>
                    </select>
                </div>   
            </div>
            <div class="flexRow space-around alignItemsCenter " style="margin:10px 0;">
                <div style=" width: 80%; min-width: 322px;">
                    <label for="description">Description de la recette</label>
                    <br>
                    <textarea oninput='(elem)=>{elem.style.height = "1px";elem.style.height = (elem.scrollHeight)+"px";}' style="height: 50px;width: 100%;resize: none" placeholder="Entrez la recette ici&#10;les retrous a la ligne sont pris en compte" id="description" name="description" required ></textarea>
                </div>   
            </div>
            <div class="flexRow space-around alignItemsCenter ">
                <button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Valider</button>  
            </div>         
        </div>
        
        
    </form>  
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >Titre</th>
                   <th >Type</th>
                   <th >Description</th>
                   <th >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($recipes as $recipe):?>
                    <tr>
                        <td <?= $recipe->archived() ? "style='color:red;'": "";?>  ><?= $recipe->label();?></td>
                        <td <?= $recipe->archived() || $recipe->type()->archived() ? "style='color:red;'": "";?>  ><?= $recipe->type()->label();?></td>
                        <td <?= $recipe->archived() ? "style='color:red;'": "";?>  ><textarea style="max-width: 85%; width: 85%; height: 100%;resize: none;color: <?= $recipe->archived() ? "red": "white"; ?>;background-color: transparent;" disabled><?= $recipe->description();?></textarea></td>
                        <td <?= $recipe->archived() ? "style='color:red;'": "";?>  ><?= $recipe->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                $url =  $recipe->archived() ? URL."recipe/unarchive/".$recipe->id(): URL."recipe/archive/".$recipe->id() ;
                                echo'<button onclick="location.href=\''.$url.'\';">
                                        '.(  $recipe->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                    </button>'; 
                            

                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div>
</div>