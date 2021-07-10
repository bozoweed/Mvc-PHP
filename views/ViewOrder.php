
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des commandes</h2>    
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >N°</th>
                   <th >Facture</th>
                   <th >Créer le</th>
                   <th >Client</th>
                   <th >Bières disponibles</th>
                   <th class='hideLittleScreen' >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($orders as $order):?>
                    <tr>
                        <td <?= $order->archived() ? "style='color:red;'": "";?>  ><?= $order->id();?></td>
                        <td <?= $order->archived() ? "style='color:red;'": "";?>  ><?php
                                    $html ='<button title="voir la facture" onclick="location.href=\''.URL."bill/edit/".$order->bill()->id().'\';">
                                        <i '.($order->archived() || !$order->bill()->avaible() ? "style='color:red;'":"").' class="far fa-file-invoice-dollar"></i>
                                    </button>
                                    '; 
                                    
                                    
                                    echo $html;
                                    ?></td>
                        <td <?= $order->archived() ? "style='color:red;'": "";?>  ><?= $order->createDate();?></td>
                        <td <?= $order->bill()->client()->archived() || $order->archived() ? "style='color:red;'": "";?>  ><?= $order->bill()->client()->fullName();?></td>
                        <td <?= $order->archived() ||  !$order->bill()->beersAvaible() ? "style='color:red;'": "";?>  ><?= $order->bill()->beersAvaible() ? "Oui": "Non";?></td>
                        <td class='hideLittleScreen' <?= $order->archived() ? "style='color:red;'": "";?>  ><?= $order->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                    $url =  $order->archived() ? URL."order/unarchive/".$order->id(): URL."order/archive/".$order->id() ;
                                    $buttons="";
                                    $title = $order->archived() ?  "désarchiver":"archiver";
                                    echo'<button title="'.$title.'" onclick="location.href=\''.$url.'\';">
                                          '.(  $order->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                      </button>
                                      '; 
                                    $buttons.='<button title="voir la commande" onclick="location.href=\''.URL."order/view/".$order->id().'\';">
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