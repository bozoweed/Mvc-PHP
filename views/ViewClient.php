
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des clients</h2>
    <form class="gridX4FullRow gridX4 formRegister" style="margin: 0 7%;" method="post">       
    <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter un client</h2>
        <div class="gridX4HalfLeft flexColumns space-around  alignItemsCenter">
            <div>
                <label for="name">Nom:</label>
                <br>
                <input type="text" id="name" name="name" required size="26">
            </div>
            <div>
                <label for="email">Email:</label>
                <br>
                <input type="text" id="email" name="email" required size="26">
            </div>    
            <div>
                <label for="society">Socièté:</label>
                <br>
                <input type="text" id="society" name="society"  size="26">
            </div>            
        </div>
        <div class="gridX4HalfRight flexColumns space-around  alignItemsCenter">
            <div>
                <label for="lastName">Prénom:</label>
                <br>
                <input type="text" id="lastName" name="lastName" required size="26">
            
            </div>
            <div>
                <label for="phoneNumber">Numéro de portable:</label>
                <br>
                <input type="text" id="phoneNumber" name="phoneNumber" required size="26">
            </div>
            <div>
                <label for="deliveryAddress">Address de livraison:</label>
                <br>
                <input type="text" id="deliveryAddress" name="deliveryAddress" required size="26">
            </div>
                  
        </div>        
        <div class="gridX4FullRow flexColumns space-around">
            <div class="flexRow space-around " >
                <button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Valider</button>  
            </div>
              
        </div>  
    </form>   
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >Nom</th>
                   <th >Prénom</th>
                   <th >Email</th>
                   <th >Téléphone</th>                   
                   <th >Socièté</th>
                   <th class='hideLittleScreen'>Adresse</th>
                   <th class='hideLittleScreen'>Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($clients as $client):?>
                    <tr>
                        <td <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->name();?></td>
                        <td <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->lastName();?></td>
                        <td <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->email();?></td>
                        <td <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->phoneNumber();?></td>
                        <td <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->society();?></td>
                        <td class='hideLittleScreen' <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->deliveryAddress();?></td>
                        <td class='hideLittleScreen' <?= $client->archived() ? "style='color:red;'": "";?>  ><?= $client->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                $url =  $client->archived() ? URL."client/unarchive/".$client->id(): URL."client/archive/".$client->id() ;
                                $title = $client->archived() ?  "désarchiver":"archiver";
                                echo'<button title="'.$title.'" onclick="location.href=\''.$url.'\';">
                                        '.(  $client->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                    </button>'; 
                            

                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div> 
</div>