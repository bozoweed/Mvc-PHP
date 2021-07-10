
<div class="flexColumns fullHauteur overflowScroll">
    <div <?php if(!isset($error)) echo "style='display:none;'";?> class="aligntextCenter errorMessage">
        <p> <?php  if(isset($error)) echo $error;?> </p>
    </div>
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion des types</h2>
    <form class="gridX4 formRegister" style="margin: 0 20%;min-height: 159px;height: 10%;"  method="post">
         <h2 class="gridX4FullRow flexRow space-around" style="height:40px">Ajouter un type</h2>
        <div class="gridX4FullRow flexColumns space-around" style="padding: 0 0 21px 0 ;">
            <div class="flexRow space-around alignItemsCenter ">
                <div>
                    <label for="label">Nom du type</label>
                    <br>
                    <input type="text" placeholder="Nom du type" id="label" name="label" required size="26">
                </div>
                
                <button style="padding: 6px;" type="submit"  id="submit" name="submit" value="Valider">Valider</button>                
                 
            </div>
        </div>
        
        
    </form>  
    <div class="gridX8">
        <table class="gridX8-1-8 alignTextCenter ">
            <thead>
                <tr>
                   <th >Type</th>
                   <th >Archiver</th>
                   <th >Action</th>
                </tr>
            </thead>
            <tfoot>                            
            </tfoot>
            <tbody>
            <?php
                foreach($types as $type):?>
                    <tr>
                        <td <?= $type->archived() ? "style='color:red;'": "";?>  ><?= $type->label();?></td>
                        <td <?= $type->archived() ? "style='color:red;'": "";?>  ><?= $type->archived() ? "Oui": "Non";?></td>
                        <td><?php 
                                $url =  $type->archived() ? URL."type/unarchive/".$type->id(): URL."type/archive/".$type->id() ;
                                echo'<button onclick="location.href=\''.$url.'\';">
                                        '.(  $type->archived() ? '<i class="fas fa-box-open"></i>' : '<i class="fas fa-archive"></i>').'
                                    </button>'; 
                            

                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </div>
</div>