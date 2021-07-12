
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des factures</h2>
    <form class="gridX4 formRegister" style="margin: 0px 13%;min-height: 161px;height: 0%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Créer une facture</h2>
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
                   <th >Devis</th>
                   <th >Créer le</th>
                   <th >Client</th>
                   <th >Bières disponibles</th>
                   <th >Prix total</th>
                   <th >Payer</th>
                   <th class='hideLittleScreen' >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($bills as $bill):?>
                <?php if ($bill->archived() && !$displayArchived) continue; ?>
                    <tr>
                        <td <?= $bill->archived() ? "style='color:red;'": "";?>  ><?= $bill->id();?></td>
                        <td <?= $bill->archived() ? "style='color:red;'": "";?>  ><?php
                                    $html ="aucun devis";
                                    if( $bill->hadQuote()){
                                        $html ='<button title="voir le devis" onclick="location.href=\''.URL."quote/edit/".$bill->quote()->id().'\';">
                                            <i '.($bill->archived() || !$bill->quote()->avaible() ? "style='color:red;'":"").' class="fal fa-file-invoice"></i>
                                        </button>
                                        '; 
                                    }
                                    
                                    echo $html;
                                    ?></td>
                        <td <?=  $bill->archived() ? "style='color:red;'": "";?>  ><?= $bill->createDate();?></td>
                        <td <?= $bill->client()->archived() ||$bill->archived() ? "style='color:red;'": "";?>  ><?= $bill->client()->fullName();?></td>
                        <td <?= $bill->archived() ||  !$bill->beersAvaible() ? "style='color:red;'": "";?>  ><?= $bill->beersAvaible() ? "Oui": "Non";?></td>
                        <td <?= $bill->archived() ? "style='color:red;'": "";?>  ><?= $bill->totalPrice() ;?>€</td>
                        <td  <?= $bill->archived() || !$bill->payed() ? "style='color:red;'": ($bill->payed()?"style='color:green;'":"");?>  ><?= $bill->payed() ? "Oui": "Non";?></td>
                        <td class='hideLittleScreen' <?= $bill->archived() ? "style='color:red;'": "";?>  ><?= $bill->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                  $url =  $bill->archived() ? URL."bill/unarchive/".$bill->id(): URL."bill/archive/".$bill->id() ;
                                  $buttons="";
                                  $title = $bill->archived() ?  "désarchiver":"archiver";
                                  echo'<button title="'.$title.'" onclick="location.href=\''.$url.'\';">
                                          '.(  $bill->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                      </button>
                                      '; 
                                  $buttons.='<button title="editer" onclick="location.href=\''.URL."bill/edit/".$bill->id().'\';">
                                          <i class="fal fa-file-edit"></i>
                                      </button>
                                      '; 
                                      $buttons.='<button title="lancer la commande" onclick="location.href=\''.URL."bill/payed/".$bill->id().'\';">
                                            <i class="far fa-truck"></i>
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