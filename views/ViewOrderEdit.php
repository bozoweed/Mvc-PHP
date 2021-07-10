
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Commande N°<?=$order->id() ?></h2>
    <div class="gridX4 formRegister" style="margin: 0px 7%;min-height: 215px;height: 23%;">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter un produit</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
        <div class="flexRow space-around alignItemsCenter ">               
                <div>
                    <label for="client">Client:</label>
                    <br>
                    <input type="text" id="client" name="client" disabled size="26" value="<?=$order->bill()->client()->fullName()?>">
                </div>
                <div>
                    <label for="society">Socièté:</label>
                    <br>
                    <input type="text" id="society" name="society" disabled size="26" value="<?=$order->bill()->client()->society()?>">
                </div>
            </div>
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="phoneNumber">Numéro de téléphone:</label>
                    <br>
                    <input type="text" id="phoneNumber" name="phoneNumber"  disabled size="26"  value="<?=$order->bill()->client()->phoneNumber()?>">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <br>
                    <input type="text" id="email" name="email" disabled size="26" value="<?=$order->bill()->client()->email()?>">
                </div>
                
            </div>
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="deliveryAddress">Adresse de livraison:</label>
                    <br>
                    <input type="text" id="deliveryAddress" name="deliveryAddress" disabled size="26" value="<?=$order->bill()->client()->deliveryAddress()?>">
                </div>
            </div>
            
                   
        </div>
        
        
    </div>  
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >Bière</th>
                   <th >Quantité</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($order->bill()->lines() as $line):?>
                    <tr>
                        <td <?= !$line->beer()->avaible() ? "style='color:red;'": "";?>  ><?= $line->beer()->label();?></td>
                        <td <?= !$line->beer()->avaible() ? "style='color:red;'": "";?>  ><?= $line->quantity();?></td>                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div>
</div>