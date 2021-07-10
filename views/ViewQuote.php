
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des devis</h2>
    <form class="gridX4 formRegister" style="margin: 0px 13%;min-height: 161px;height: 0%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Créer un devis</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="client">Client</label>
                    <br>
                    <select id="client" name="client" >
                        <option value=''>Choisiez un Client</option>
                        <?php
                            foreach($clients as $client):?>
                                <?= ($client->archived() ? "": "<option value='".$client->id()."'>".$client->fullName().'</option>');?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Valider</button>     
            </div>
                   
        </div>
        
        
    </form>  
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >N°</th>
                   <th >Créer le</th>
                   <th >Client</th>
                   <th >Bières disponibles</th>
                   <th >Prix total</th>
                   <th class='hideLittleScreen' >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($quotes as $quote):?>
                    <tr>
                        <td <?= $quote->archived() ? "style='color:red;'": "";?>  ><?= $quote->id();?></td>
                        <td <?=  $quote->archived() ? "style='color:red;'": "";?>  ><?= $quote->createDate();?></td>
                        <td <?= $quote->client()->archived() ||$quote->archived() ? "style='color:red;'": "";?>  ><?= $quote->client()->fullName();?></td>
                        <td <?= $quote->archived() ||  !$quote->beersAvaible() ? "style='color:red;'": "";?>  ><?= $quote->beersAvaible() ? "Oui": "Non";?></td>
                        <td <?= $quote->archived() ? "style='color:red;'": "";?>  ><?= $quote->totalPrice() ;?>€</td>
                        <td class='hideLittleScreen' <?= $quote->archived() ? "style='color:red;'": "";?>  ><?= $quote->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                  $url =  $quote->archived() ? URL."quote/unarchive/".$quote->id(): URL."quote/archive/".$quote->id() ;
                                  $buttons="";
                                  $title = $quote->archived() ?  "désarchiver":"archiver";
                                  echo'<button title="'.$title.'" onclick="location.href=\''.$url.'\';">
                                          '.(  $quote->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                      </button>
                                      '; 
                                  $buttons.='<button title="edtiter" onclick="location.href=\''.URL."quote/edit/".$quote->id().'\';">
                                          <i class="fal fa-file-edit"></i>
                                      </button>
                                      '; 
                                  $buttons.='<button title="générer la facture" onclick="location.href=\''.URL."quote/bill/".$quote->id().'\';">
                                            <i class="far fa-file-invoice-dollar"></i>
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