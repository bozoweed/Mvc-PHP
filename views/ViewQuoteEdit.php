
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Devis N°<?=$quote->id() ?></h2>
    <form class="gridX4 formRegister" style="margin: 0px 7%;min-height: 215px;height: 23%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter un produit</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
        <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="type">Bière</label>
                    <br>
                    <select id="beer" name="beer" >
                        <option value=''>Choisiez une bière</option>
                        <?php
                            foreach($beers as $beer):?>
                                <?= ($beer->archived() ? "": "<option value='".$beer->id()."'>".$beer->label()." - ".$beer->recipe()->type()->label().' ('.$beer->price().'€)</option>');?>
                        <?php endforeach; ?>
                    </select>
                </div>
                

            </div>
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="quantity">Quantity:</label>
                    <br>
                    <input type="number" id="quantity" name="quantity" step="1" require size="26">
                </div>
                <div>
                    <label for="discount">Reduction:</label>
                    <br>
                    <input type="number" id="discount" name="discount" step="1" size="26">
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
                   <th >Bière</th>
                   <th >Quantité</th>
                   <th >Reduction</th>
                   <th >Prix total</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($quote->lines() as $line):?>
                    <tr>
                        <td <?= !$line->beer()->avaible() ? "style='color:red;'": "";?>  ><?= $line->beer()->label();?></td>
                        <td <?= !$line->beer()->avaible() ? "style='color:red;'": "";?>  ><?= $line->quantity();?></td>
                        <td ><?= $line->discount() ?$line->discount(): 0;?>€</td>
                        <td ><?= $line->price();?>€</td>
                        <td><?php 
                                $url =  URL."quote/edit/".$quote->id()."/delete/".$line->id();
                                $buttons="";                                
                                $buttons.='<button onclick="location.href=\''.$url .'\';">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    '; 
                                echo $buttons;
                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div>
</div>