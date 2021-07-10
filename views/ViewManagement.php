
<div class="flexColumns fullHauteur overflowScroll">
    <h2 class=" flexRow space-evenly" style="height:40px">Géstion</h2>
    <div class="gridX4 formRegister" style="margin: 0 17%;">
        <div class="gridX4HalfLeft flexColumns space-around alignItemsCenter">            
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'register\';">
                            Ajouter un utilisateur
                        </button>';
                ?>
            </div>
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'type\';">
                            Gérer les types
                        </button>';
                ?>
            </div>
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'recipe\';">
                            Gérer les recettes
                        </button>';
                ?>
            </div>
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'beer\';">
                            Gérer les bières
                        </button>';
                ?>
            </div>
        </div>
        <div class="gridX4HalfRight flexColumns space-around alignItemsCenter">
            <div>                
                <?php
                    echo'<button onclick="location.href=\''.URL.'client\';">
                            Gérer les clients
                        </button>';
                ?>
            </div> 
            
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'quote\';">
                            Gérer les devis
                        </button>';
                ?>
            </div>
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'bill\';">
                            Gérer les factures
                        </button>';
                ?>
            </div>    
            <div>
                <?php
                    echo'<button onclick="location.href=\''.URL.'order\';">
                            Gérer les commandes
                        </button>';
                ?>
            </div>          
        </div>        
        
    </div>    
   
</div>