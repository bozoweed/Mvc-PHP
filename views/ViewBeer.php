
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des bières</h2>
    <form class="gridX4 formRegister" style="margin: 0 13%;min-height: 315px;height: 26%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter une bière</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="label">Titre de la bière</label>
                    <br>
                    <input type="text" placeholder="Titre de la bière" id="label" name="label" required size="26">
                </div>   
                <div>
                    <label for="type">Recette</label>
                    <br>
                    <select id="type" name="recipe" >
                        <option value=''>Choisiez une recette</option>
                        <?php
                            foreach($recipes as $recipe):?>
                                <?= (!$recipe->avaible() ? "": "<option value='".$recipe->id()."'>".$recipe->label().' - '.$recipe->type()->label().'</option>');?>
                        <?php endforeach; ?>
                    </select>
                </div>   
            </div>
            <div class="flexRow space-around alignItemsCenter " style='margin: 10px 0 0 0;'>
                <div>
                    <label for="price">Prix de la bière</label>
                    <br>
                    <input type="number" placeholder="0.01" id="price" name="price" required step="0.01" size="26">
                </div>   
                <div>
                    <label for="alcoolLevel">Degrè d'alcool</label>
                    <br>
                    <input type="number" placeholder="0.01" id="alcoolLevel" name="alcoolLevel" required step="0.01" size="19">
                </div>
            </div>
            <div class="flexRow space-around alignItemsCenter " style="margin:10px 0;">
                <div style=" width: 80%;min-width: 329px;">
                    <label for="description">Description de la bière</label>
                    <br>
                    <textarea oninput='(elem)=>{elem.style.height = "1px";elem.style.height = (elem.scrollHeight)+"px";}' style="height: 50px;width: 100%;resize: none" placeholder="Entrez la bière ici&#10;les retrous a la ligne sont pris en compte" id="description" name="description" required ></textarea>
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
                   <th >Recette</th>
                   <th >Description</th>
                   <th >Degrè</th>
                   <th >Prix</th>
                   <th >Date de création</th>
                   <th class='hideLittleScreen' >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($beers as $beer):?>
                    <tr>
                        <td <?= $beer->archived() ? "style='color:red;'": "";?>  ><?= $beer->label();?></td>
                        <td <?= $beer->archived() || $beer->recipe()->type()->archived() ? "style='color:red;'": "";?>  ><?= $beer->recipe()->type()->label();?></td>
                        <td <?= $beer->archived() || !$beer->recipe()->avaible() ? "style='color:red;'": "";?>  ><?= $beer->recipe()->label();?></td>
                        <td <?= $beer->archived() ? "style='color:red;'": "";?>  ><textarea style="max-width: 85%; width: 85%; height: 100%;resize: none;color: <?= $beer->archived()  ? "red": "white"; ?>;background-color: transparent;" disabled><?= $beer->description();?></textarea></td>
                        <td <?= $beer->archived() ? "style='color:red;'": "";?>  ><?= $beer->alcoolLevel();?>%</td>
                        <td <?= $beer->archived() ? "style='color:red;'": "";?>  ><?= $beer->price();?>€</td>
                        <td <?= $beer->archived() ? "style='color:red;'": "";?>  ><?= $beer->productDate();?></td>
                        <td class='hideLittleScreen' <?= $beer->archived() ? "style='color:red;'": "";?>  ><?= $beer->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                $url =  $beer->archived() ? URL."beer/unarchive/".$beer->id(): URL."beer/archive/".$beer->id() ;
                                $title = $beer->archived() ?  "désarchiver":"archiver";
                                echo'<button title="'.$title.'" onclick="location.href=\''.$url.'\';">
                                        '.(  $beer->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                    </button>'; 
                            

                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div>
</div>